"""Misc cog — CheapShark game deals, USASpending, NWS weather.

APIs used:
- CheapShark (https://www.cheapshark.com/api/1.0) — free, no key, 60 calls/min
  - /deals — current game deals
  - /games — search for games
- USASpending (https://api.usaspending.gov/api/v2) — free, no key
  - /search/spending_by_award — government contract data
- National Weather Service (https://api.weather.gov) — free, no key
  - /points/{lat},{lon} — weather forecast by coordinates

Slash commands:
- /misc deals [title] — search game deals on CheapShark
- /misc weather <location> — weather forecast from NWS
- /misc spending <keyword> — government spending search
"""

import logging

import discord
from discord import app_commands
from discord.ext import commands

from bot.services.api_client import ApiClient
from bot.utils.cache import Cache
from bot.utils.config import CACHE_TTL
from bot.utils.embeds import COLORS, create_embed
from bot.utils.rate_limiter import RateLimiter

logger = logging.getLogger(__name__)


class MiscCog(commands.Cog, name="Misc"):
    """Miscellaneous data — game deals, weather, government spending."""

    def __init__(self, bot: commands.Bot) -> None:
        self.bot = bot
        self.cheapshark = ApiClient(base_url="https://www.cheapshark.com/api/1.0")
        self.usaspending = ApiClient(base_url="https://api.usaspending.gov/api/v2")
        self.nws = ApiClient(base_url="https://api.weather.gov")
        self.cache = Cache()
        self.cheapshark_limiter = RateLimiter(calls=60, period=60)
        self.nws_limiter = RateLimiter(calls=60, period=60)

    async def cog_load(self) -> None:
        logger.info("Misc cog loaded (all APIs are free, no keys needed)")

    async def cog_unload(self) -> None:
        await self.cheapshark.close()
        await self.usaspending.close()
        await self.nws.close()

    misc_group = app_commands.Group(name="misc", description="Miscellaneous commands")

    @misc_group.command(name="deals", description="Search game deals on CheapShark")
    @app_commands.describe(title="Game title to search for (optional)")
    async def misc_deals(self, interaction: discord.Interaction, title: str = "") -> None:
        """Game deals from CheapShark — free, no API key required."""
        await interaction.response.defer()
        await self.cheapshark_limiter.acquire()

        cache_key = f"cheapshark_deals_{title.lower().replace(' ', '_') or 'top'}"
        cached = await self.cache.get(cache_key)
        if cached:
            data = cached
        else:
            params = {"pageSize": "5", "sortBy": "Deal Rating"}
            if title:
                params["title"] = title
            data = await self.cheapshark.get("/deals", params=params)
            if data:
                await self.cache.set(cache_key, data, CACHE_TTL["misc"])

        if not data:
            await interaction.followup.send("Could not fetch game deals.")
            return

        deals = data[:5] if isinstance(data, list) else []
        if not deals:
            await interaction.followup.send(f"No deals found for `{title}`." if title else "No deals found.")
            return

        fields = []
        for deal in deals:
            game_title = deal.get("title", "Unknown")[:256]
            sale_price = deal.get("salePrice", "N/A")
            normal_price = deal.get("normalPrice", "N/A")
            savings = float(deal.get("savings", 0))
            deal_id = deal.get("dealID", "")
            store_id = deal.get("storeID", "")

            fields.append((
                game_title,
                f"**${sale_price}** ~~${normal_price}~~ ({savings:.0f}% off)\n"
                f"[View Deal](https://www.cheapshark.com/redirect?dealID={deal_id})",
                False,
            ))

        embed = create_embed(
            title=f"Game Deals{f': {title}' if title else ''}",
            description=f"Top {len(deals)} deal(s) from CheapShark",
            color=COLORS["misc"],
            fields=fields,
        )
        await interaction.followup.send(embed=embed)

    @misc_group.command(name="weather", description="Get weather forecast")
    @app_commands.describe(location="Location as 'lat,lon' (e.g., 40.7128,-74.0060 for NYC)")
    async def misc_weather(self, interaction: discord.Interaction, location: str) -> None:
        """Weather forecast from NWS — free, no API key required."""
        await interaction.response.defer()
        await self.nws_limiter.acquire()

        # TODO: Implement NWS weather lookup
        # 1. GET /points/{lat},{lon} to get forecast URL
        # 2. GET the forecast URL for detailed forecast
        await interaction.followup.send(f"Weather for `{location}` — coming soon!")

    @misc_group.command(name="spending", description="Search government spending")
    @app_commands.describe(keyword="Keyword to search for in government contracts")
    async def misc_spending(self, interaction: discord.Interaction, keyword: str) -> None:
        """Government spending data from USASpending — free, no key."""
        await interaction.response.defer()

        # TODO: Implement USASpending search
        # POST /search/spending_by_award with keyword filters
        await interaction.followup.send(f"Government spending for `{keyword}` — coming soon!")


async def setup(bot: commands.Bot) -> None:
    await bot.add_cog(MiscCog(bot))
