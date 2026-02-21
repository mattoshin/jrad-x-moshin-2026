"""Crypto cog — CoinGecko, Fear & Greed Index, DeFi Llama, Whale Alert.

APIs used:
- CoinGecko (https://api.coingecko.com/api/v3) — 30 calls/min free, 10K/month
- Alternative.me Fear & Greed (https://api.alternative.me/fng/) — free, no key
- DeFi Llama (https://api.llama.fi) — free, no key
- Whale Alert (https://api.whale-alert.io) — requires key

Slash commands:
- /crypto price <coin> — price, market cap, 24h change
- /crypto fear — Fear & Greed Index (works without key)
- /crypto tvl — DeFi total value locked
- /crypto trending — trending coins on CoinGecko
"""

import logging

import discord
from discord import app_commands
from discord.ext import commands, tasks

from bot.services.api_client import ApiClient
from bot.utils.cache import Cache
from bot.utils.config import COINGECKO_API_KEY, CACHE_TTL
from bot.utils.embeds import COLORS, create_embed
from bot.utils.rate_limiter import RateLimiter

logger = logging.getLogger(__name__)


class CryptoCog(commands.Cog, name="Crypto"):
    """Cryptocurrency data from CoinGecko and related APIs."""

    def __init__(self, bot: commands.Bot) -> None:
        self.bot = bot
        self.coingecko = ApiClient(base_url="https://api.coingecko.com/api/v3")
        self.fng_api = ApiClient(base_url="https://api.alternative.me")
        self.defillama = ApiClient(base_url="https://api.llama.fi")
        self.cache = Cache()
        self.limiter = RateLimiter(calls=30, period=60)

    async def cog_load(self) -> None:
        logger.info("Crypto cog loaded (CoinGecko key: %s)", "yes" if COINGECKO_API_KEY else "no")

    async def cog_unload(self) -> None:
        await self.coingecko.close()
        await self.fng_api.close()
        await self.defillama.close()

    crypto_group = app_commands.Group(name="crypto", description="Cryptocurrency commands")

    @crypto_group.command(name="fear", description="Get the Crypto Fear & Greed Index")
    async def crypto_fear(self, interaction: discord.Interaction) -> None:
        """Fear & Greed Index — no API key required."""
        await interaction.response.defer()

        cached = await self.cache.get("crypto_fng")
        if cached:
            data = cached
        else:
            data = await self.fng_api.get("/fng/", params={"limit": "1"})
            if data:
                await self.cache.set("crypto_fng", data, CACHE_TTL["crypto"])

        if not data or not data.get("data"):
            await interaction.followup.send("Could not fetch Fear & Greed data.")
            return

        entry = data["data"][0]
        value = int(entry["value"])
        label = entry["value_classification"]

        if value <= 25:
            color = 0xE74C3C  # Extreme Fear
        elif value <= 45:
            color = 0xE67E22  # Fear
        elif value <= 55:
            color = 0xF1C40F  # Neutral
        elif value <= 75:
            color = 0x2ECC71  # Greed
        else:
            color = 0x27AE60  # Extreme Greed

        embed = create_embed(
            title="Crypto Fear & Greed Index",
            description=f"**{value}** — {label}",
            color=color,
            fields=[
                ("Score", f"{value}/100", True),
                ("Classification", label, True),
            ],
        )
        await interaction.followup.send(embed=embed)

    @crypto_group.command(name="price", description="Get cryptocurrency price")
    @app_commands.describe(coin="Coin ID (e.g., bitcoin, ethereum)")
    async def crypto_price(self, interaction: discord.Interaction, coin: str) -> None:
        """Fetch price from CoinGecko."""
        await interaction.response.defer()
        await self.limiter.acquire()

        # TODO: Implement full CoinGecko price lookup
        # GET /simple/price?ids={coin}&vs_currencies=usd&include_24hr_change=true&include_market_cap=true
        await interaction.followup.send(f"Price lookup for `{coin}` — coming soon!")

    @crypto_group.command(name="tvl", description="Get DeFi total value locked")
    async def crypto_tvl(self, interaction: discord.Interaction) -> None:
        """DeFi TVL from DeFi Llama — no API key required."""
        await interaction.response.defer()

        # TODO: Implement DeFi Llama TVL lookup
        # GET /v2/historicalChainTvl
        await interaction.followup.send("DeFi TVL data — coming soon!")

    @crypto_group.command(name="trending", description="Get trending coins")
    async def crypto_trending(self, interaction: discord.Interaction) -> None:
        """Trending coins from CoinGecko."""
        await interaction.response.defer()
        await self.limiter.acquire()

        # TODO: Implement CoinGecko trending
        # GET /search/trending
        await interaction.followup.send("Trending coins — coming soon!")


async def setup(bot: commands.Bot) -> None:
    await bot.add_cog(CryptoCog(bot))
