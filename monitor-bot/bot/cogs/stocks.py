"""Stocks cog — Finnhub API integration.

APIs used:
- Finnhub (https://finnhub.io/api/v1) — 60 calls/min free tier
  - /quote — Real-time stock quotes
  - /stock/insider-sentiment — Insider sentiment (MSPR)
  - /calendar/earnings — Upcoming earnings

Slash commands:
- /stock quote <ticker>
- /stock sentiment <ticker>
- /stock earnings <ticker>

Background monitor:
- market_movers_loop — every 5 min during market hours, alert on >5% moves
"""

import logging
from datetime import datetime, timezone
from typing import Optional

import discord
from discord import app_commands
from discord.ext import commands, tasks

from bot.services.api_client import ApiClient
from bot.utils.cache import Cache
from bot.utils.config import FINNHUB_API_KEY, CACHE_TTL, WEBHOOK_URL
from bot.utils.embeds import COLORS, create_embed
from bot.utils.rate_limiter import RateLimiter
from bot.services.webhook_manager import WebhookManager

logger = logging.getLogger(__name__)

# Major indices tickers to monitor for big moves
WATCHLIST = ["AAPL", "MSFT", "GOOGL", "AMZN", "TSLA", "NVDA", "META", "SPY", "QQQ", "AMD"]


class StocksCog(commands.Cog, name="Stocks"):
    """Stock market data via Finnhub API."""

    def __init__(self, bot: commands.Bot) -> None:
        self.bot = bot
        self.api = ApiClient(
            base_url="https://finnhub.io/api/v1",
            headers={"X-Finnhub-Token": FINNHUB_API_KEY} if FINNHUB_API_KEY else {},
        )
        self.cache = Cache()
        self.limiter = RateLimiter(calls=60, period=60)
        self.webhook = WebhookManager(WEBHOOK_URL)

    async def cog_load(self) -> None:
        if FINNHUB_API_KEY:
            self.market_movers_loop.start()
            logger.info("Stocks cog loaded with Finnhub API key")
        else:
            logger.warning("Stocks cog loaded WITHOUT Finnhub API key — commands will fail")

    async def cog_unload(self) -> None:
        self.market_movers_loop.cancel()
        await self.api.close()
        await self.webhook.close()

    def _check_api_key(self) -> bool:
        if not FINNHUB_API_KEY:
            return False
        return True

    async def _fetch_quote(self, ticker: str) -> Optional[dict]:
        """Fetch real-time quote for a ticker."""
        cache_key = f"stock_quote_{ticker.upper()}"
        cached = await self.cache.get(cache_key)
        if cached:
            return cached

        await self.limiter.acquire()
        data = await self.api.get("/quote", params={"symbol": ticker.upper(), "token": FINNHUB_API_KEY})
        if data and data.get("c", 0) > 0:
            await self.cache.set(cache_key, data, CACHE_TTL["stocks"])
            return data
        return None

    # --- Slash command group ---
    stock_group = app_commands.Group(name="stock", description="Stock market commands")

    @stock_group.command(name="quote", description="Get a real-time stock quote")
    @app_commands.describe(ticker="Stock ticker symbol (e.g., AAPL)")
    async def stock_quote(self, interaction: discord.Interaction, ticker: str) -> None:
        if not self._check_api_key():
            await interaction.response.send_message(
                "Finnhub API key not configured. Contact the bot admin.", ephemeral=True
            )
            return

        await interaction.response.defer()

        data = await self._fetch_quote(ticker)
        if not data:
            await interaction.followup.send(f"Could not find quote for `{ticker.upper()}`.")
            return

        current = data["c"]
        change = data["d"]
        pct_change = data["dp"]
        high = data["h"]
        low = data["l"]
        open_price = data["o"]
        prev_close = data["pc"]

        arrow = "\u2B06\uFE0F" if change >= 0 else "\u2B07\uFE0F"
        color = 0x2ECC71 if change >= 0 else 0xE74C3C

        embed = create_embed(
            title=f"{arrow} {ticker.upper()} — ${current:.2f}",
            description=f"**Change:** ${change:+.2f} ({pct_change:+.2f}%)",
            color=color,
            fields=[
                ("Open", f"${open_price:.2f}", True),
                ("High", f"${high:.2f}", True),
                ("Low", f"${low:.2f}", True),
                ("Prev Close", f"${prev_close:.2f}", True),
            ],
        )
        await interaction.followup.send(embed=embed)

    @stock_group.command(name="sentiment", description="Get insider sentiment for a stock")
    @app_commands.describe(ticker="Stock ticker symbol (e.g., AAPL)")
    async def stock_sentiment(self, interaction: discord.Interaction, ticker: str) -> None:
        if not self._check_api_key():
            await interaction.response.send_message(
                "Finnhub API key not configured.", ephemeral=True
            )
            return

        await interaction.response.defer()
        await self.limiter.acquire()

        cache_key = f"stock_sentiment_{ticker.upper()}"
        cached = await self.cache.get(cache_key)
        if cached:
            data = cached
        else:
            data = await self.api.get(
                "/stock/insider-sentiment",
                params={"symbol": ticker.upper(), "from": "2024-01-01", "to": "2025-12-31", "token": FINNHUB_API_KEY},
            )
            if data:
                await self.cache.set(cache_key, data, CACHE_TTL["stocks"] * 5)

        if not data or not data.get("data"):
            await interaction.followup.send(f"No insider sentiment data found for `{ticker.upper()}`.")
            return

        latest = data["data"][-1] if data["data"] else None
        if not latest:
            await interaction.followup.send(f"No recent sentiment data for `{ticker.upper()}`.")
            return

        mspr = latest.get("mspr", 0)
        change_val = latest.get("change", 0)

        sentiment_label = "Bullish" if mspr > 0 else "Bearish" if mspr < 0 else "Neutral"
        color = 0x2ECC71 if mspr > 0 else 0xE74C3C if mspr < 0 else COLORS["stocks"]

        embed = create_embed(
            title=f"Insider Sentiment — {ticker.upper()}",
            description=f"**Overall:** {sentiment_label}",
            color=color,
            fields=[
                ("MSPR Score", f"{mspr:.4f}", True),
                ("Net Change", f"{change_val}", True),
                ("Period", f"{latest.get('year', 'N/A')}-{latest.get('month', 'N/A')}", True),
            ],
        )
        await interaction.followup.send(embed=embed)

    @stock_group.command(name="earnings", description="Get upcoming earnings calendar")
    @app_commands.describe(ticker="Stock ticker symbol (e.g., AAPL)")
    async def stock_earnings(self, interaction: discord.Interaction, ticker: str) -> None:
        if not self._check_api_key():
            await interaction.response.send_message(
                "Finnhub API key not configured.", ephemeral=True
            )
            return

        await interaction.response.defer()
        await self.limiter.acquire()

        cache_key = f"stock_earnings_{ticker.upper()}"
        cached = await self.cache.get(cache_key)
        if cached:
            data = cached
        else:
            data = await self.api.get(
                "/calendar/earnings",
                params={"symbol": ticker.upper(), "token": FINNHUB_API_KEY},
            )
            if data:
                await self.cache.set(cache_key, data, CACHE_TTL["stocks"] * 10)

        if not data or not data.get("earningsCalendar"):
            await interaction.followup.send(f"No upcoming earnings found for `{ticker.upper()}`.")
            return

        entries = data["earningsCalendar"][:5]
        fields = []
        for entry in entries:
            date = entry.get("date", "N/A")
            eps_est = entry.get("epsEstimate", "N/A")
            eps_act = entry.get("epsActual", "N/A")
            revenue_est = entry.get("revenueEstimate", "N/A")
            fields.append((
                f"{date}",
                f"EPS Est: {eps_est} | EPS Act: {eps_act}\nRev Est: {revenue_est}",
                False,
            ))

        embed = create_embed(
            title=f"Earnings Calendar — {ticker.upper()}",
            description=f"Next {len(entries)} earnings report(s)",
            color=COLORS["stocks"],
            fields=fields,
        )
        await interaction.followup.send(embed=embed)

    # --- Background monitor ---
    @tasks.loop(minutes=5)
    async def market_movers_loop(self) -> None:
        """Check watchlist for stocks with >5% moves during market hours."""
        now = datetime.now(timezone.utc)
        # Only run during US market hours (roughly 14:30-21:00 UTC, Mon-Fri)
        if now.weekday() >= 5:
            return
        if not (14 <= now.hour <= 21):
            return

        for ticker in WATCHLIST:
            try:
                data = await self._fetch_quote(ticker)
                if not data:
                    continue

                pct_change = data.get("dp", 0)
                if abs(pct_change) >= 5.0:
                    current = data["c"]
                    arrow = "\u2B06\uFE0F" if pct_change > 0 else "\u2B07\uFE0F"
                    color = 0x2ECC71 if pct_change > 0 else 0xE74C3C

                    embed = create_embed(
                        title=f"{arrow} ALERT: {ticker} moved {pct_change:+.2f}%",
                        description=f"**Current Price:** ${current:.2f}",
                        color=color,
                        fields=[
                            ("Change", f"${data['d']:+.2f} ({pct_change:+.2f}%)", True),
                            ("High", f"${data['h']:.2f}", True),
                            ("Low", f"${data['l']:.2f}", True),
                        ],
                    )

                    if WEBHOOK_URL:
                        await self.webhook.send(embed)
            except Exception as e:
                logger.error("Error checking %s: %s", ticker, e)

    @market_movers_loop.before_loop
    async def before_market_movers(self) -> None:
        await self.bot.wait_until_ready()


async def setup(bot: commands.Bot) -> None:
    await bot.add_cog(StocksCog(bot))
