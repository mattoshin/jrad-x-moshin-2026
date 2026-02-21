"""Real estate cog — Redfin CSV data, FRED mortgage rates.

APIs used:
- Redfin Data Center (https://redfin-public-data.s3.us-west-2.amazonaws.com) — free CSV downloads
- FRED (https://api.stlouisfed.org/fred) — 120 calls/min free, requires API key
  - MORTGAGE30US — 30-year fixed mortgage rate
  - CSUSHPINSA — S&P Case-Shiller Home Price Index

Slash commands:
- /realestate mortgage — current 30-year mortgage rate from FRED
- /realestate housing — S&P Case-Shiller home price index
- /realestate market <zip_code> — local market data from Redfin
"""

import logging

import discord
from discord import app_commands
from discord.ext import commands

from bot.services.api_client import ApiClient
from bot.utils.cache import Cache
from bot.utils.config import FRED_API_KEY, CACHE_TTL
from bot.utils.embeds import COLORS, create_embed
from bot.utils.rate_limiter import RateLimiter

logger = logging.getLogger(__name__)


class RealEstateCog(commands.Cog, name="RealEstate"):
    """Real estate data from FRED and Redfin."""

    def __init__(self, bot: commands.Bot) -> None:
        self.bot = bot
        self.fred_api = ApiClient(base_url="https://api.stlouisfed.org/fred")
        self.cache = Cache()
        self.limiter = RateLimiter(calls=120, period=60)

    async def cog_load(self) -> None:
        logger.info("RealEstate cog loaded (FRED key: %s)", "yes" if FRED_API_KEY else "no")

    async def cog_unload(self) -> None:
        await self.fred_api.close()

    realestate_group = app_commands.Group(name="realestate", description="Real estate data commands")

    @realestate_group.command(name="mortgage", description="Get current 30-year mortgage rate")
    async def realestate_mortgage(self, interaction: discord.Interaction) -> None:
        """30-year fixed mortgage rate from FRED — requires API key."""
        await interaction.response.defer()

        if not FRED_API_KEY:
            await interaction.followup.send("FRED API key not configured.", ephemeral=True)
            return

        cached = await self.cache.get("fred_mortgage30")
        if cached:
            data = cached
        else:
            await self.limiter.acquire()
            data = await self.fred_api.get(
                "/series/observations",
                params={
                    "series_id": "MORTGAGE30US",
                    "api_key": FRED_API_KEY,
                    "file_type": "json",
                    "sort_order": "desc",
                    "limit": "5",
                },
            )
            if data:
                await self.cache.set("fred_mortgage30", data, CACHE_TTL["realestate"])

        if not data or not data.get("observations"):
            await interaction.followup.send("Could not fetch mortgage rate data.")
            return

        latest = data["observations"][0]
        rate = latest.get("value", "N/A")
        date = latest.get("date", "N/A")

        # Build recent trend
        observations = data["observations"][:5]
        trend_lines = []
        for obs in observations:
            trend_lines.append(f"{obs['date']}: **{obs['value']}%**")

        embed = create_embed(
            title="30-Year Fixed Mortgage Rate",
            description=f"**Current: {rate}%** (as of {date})",
            color=COLORS["realestate"],
            fields=[
                ("Recent Trend", "\n".join(trend_lines), False),
                ("Source", "Federal Reserve (FRED)", True),
            ],
        )
        await interaction.followup.send(embed=embed)

    @realestate_group.command(name="housing", description="Get S&P Case-Shiller Home Price Index")
    async def realestate_housing(self, interaction: discord.Interaction) -> None:
        """S&P/Case-Shiller Home Price Index from FRED."""
        await interaction.response.defer()

        if not FRED_API_KEY:
            await interaction.followup.send("FRED API key not configured.", ephemeral=True)
            return

        await self.limiter.acquire()

        # TODO: Implement Case-Shiller index lookup
        # GET /series/observations?series_id=CSUSHPINSA&api_key={key}&file_type=json&sort_order=desc&limit=5
        await interaction.followup.send("Case-Shiller Home Price Index — coming soon!")

    @realestate_group.command(name="market", description="Get local market data")
    @app_commands.describe(zip_code="ZIP code for local market data")
    async def realestate_market(self, interaction: discord.Interaction, zip_code: str) -> None:
        await interaction.response.defer()

        # TODO: Implement Redfin CSV data parsing
        # Download CSV from Redfin Data Center for the given zip code
        await interaction.followup.send(f"Market data for `{zip_code}` — coming soon!")


async def setup(bot: commands.Bot) -> None:
    await bot.add_cog(RealEstateCog(bot))
