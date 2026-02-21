"""News & sentiment cog — GDELT, Finnhub news.

APIs used:
- GDELT (https://api.gdeltproject.org/api/v2) — free, no key, 100 calls/min
  - /doc/doc — full-text search across global news
- Finnhub News Sentiment (https://finnhub.io/api/v1) — 60 calls/min free
  - /news?category=general — market news
  - /company-news — company-specific news

Slash commands:
- /news headlines — top market headlines from Finnhub
- /news search <query> — search global news via GDELT
- /news company <ticker> — company-specific news from Finnhub
"""

import logging

import discord
from discord import app_commands
from discord.ext import commands

from bot.services.api_client import ApiClient
from bot.utils.cache import Cache
from bot.utils.config import FINNHUB_API_KEY, CACHE_TTL
from bot.utils.embeds import COLORS, create_embed
from bot.utils.rate_limiter import RateLimiter

logger = logging.getLogger(__name__)


class NewsCog(commands.Cog, name="News"):
    """News and sentiment data from GDELT and Finnhub."""

    def __init__(self, bot: commands.Bot) -> None:
        self.bot = bot
        self.gdelt_api = ApiClient(base_url="https://api.gdeltproject.org/api/v2")
        self.finnhub_api = ApiClient(
            base_url="https://finnhub.io/api/v1",
            headers={"X-Finnhub-Token": FINNHUB_API_KEY} if FINNHUB_API_KEY else {},
        )
        self.cache = Cache()
        self.gdelt_limiter = RateLimiter(calls=100, period=60)
        self.finnhub_limiter = RateLimiter(calls=60, period=60)

    async def cog_load(self) -> None:
        logger.info("News cog loaded (Finnhub key: %s)", "yes" if FINNHUB_API_KEY else "no")

    async def cog_unload(self) -> None:
        await self.gdelt_api.close()
        await self.finnhub_api.close()

    news_group = app_commands.Group(name="news", description="News and sentiment commands")

    @news_group.command(name="search", description="Search global news via GDELT")
    @app_commands.describe(query="Search query for global news")
    async def news_search(self, interaction: discord.Interaction, query: str) -> None:
        """Search GDELT — free, no API key required."""
        await interaction.response.defer()
        await self.gdelt_limiter.acquire()

        cache_key = f"gdelt_search_{query.lower().replace(' ', '_')}"
        cached = await self.cache.get(cache_key)
        if cached:
            data = cached
        else:
            data = await self.gdelt_api.get(
                "/doc/doc",
                params={
                    "query": query,
                    "mode": "ArtList",
                    "maxrecords": "5",
                    "format": "json",
                },
            )
            if data:
                await self.cache.set(cache_key, data, CACHE_TTL["news"])

        if not data or not data.get("articles"):
            await interaction.followup.send(f"No news found for `{query}`.")
            return

        articles = data["articles"][:5]
        fields = []
        for article in articles:
            title = article.get("title", "No title")[:256]
            source = article.get("domain", "Unknown")
            url = article.get("url", "")
            fields.append((
                title,
                f"Source: {source}\n[Read more]({url})" if url else f"Source: {source}",
                False,
            ))

        embed = create_embed(
            title=f"News: {query}",
            description=f"Top {len(articles)} result(s) from GDELT",
            color=COLORS["news"],
            fields=fields,
        )
        await interaction.followup.send(embed=embed)

    @news_group.command(name="headlines", description="Get top market headlines")
    async def news_headlines(self, interaction: discord.Interaction) -> None:
        """Top market headlines from Finnhub — requires API key."""
        await interaction.response.defer()

        if not FINNHUB_API_KEY:
            await interaction.followup.send("Finnhub API key not configured.", ephemeral=True)
            return

        await self.finnhub_limiter.acquire()

        # TODO: Implement Finnhub market news
        # GET /news?category=general&token={key}
        await interaction.followup.send("Top market headlines — coming soon!")

    @news_group.command(name="company", description="Get company-specific news")
    @app_commands.describe(ticker="Stock ticker symbol (e.g., AAPL)")
    async def news_company(self, interaction: discord.Interaction, ticker: str) -> None:
        """Company news from Finnhub — requires API key."""
        await interaction.response.defer()

        if not FINNHUB_API_KEY:
            await interaction.followup.send("Finnhub API key not configured.", ephemeral=True)
            return

        await self.finnhub_limiter.acquire()

        # TODO: Implement Finnhub company news
        # GET /company-news?symbol={ticker}&from=YYYY-MM-DD&to=YYYY-MM-DD&token={key}
        await interaction.followup.send(f"News for `{ticker.upper()}` — coming soon!")


async def setup(bot: commands.Bot) -> None:
    await bot.add_cog(NewsCog(bot))
