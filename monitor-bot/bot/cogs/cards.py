"""Trading cards cog — PokemonTCG.io, PokemonPriceTracker.

APIs used:
- PokemonTCG.io (https://api.pokemontcg.io/v2) — 20K requests/day free
- PokemonPriceTracker — scraping/API TBD

Slash commands:
- /cards search <name> — search for a Pokemon card
- /cards price <card_id> — get price for a specific card
- /cards set <set_name> — get info about a card set
"""

import logging

import discord
from discord import app_commands
from discord.ext import commands

from bot.services.api_client import ApiClient
from bot.utils.cache import Cache
from bot.utils.config import POKEMON_TCG_API_KEY, CACHE_TTL
from bot.utils.embeds import COLORS, create_embed
from bot.utils.rate_limiter import RateLimiter

logger = logging.getLogger(__name__)


class CardsCog(commands.Cog, name="Cards"):
    """Pokemon Trading Card data."""

    def __init__(self, bot: commands.Bot) -> None:
        self.bot = bot
        headers = {}
        if POKEMON_TCG_API_KEY:
            headers["X-Api-Key"] = POKEMON_TCG_API_KEY
        self.api = ApiClient(base_url="https://api.pokemontcg.io/v2", headers=headers)
        self.cache = Cache()
        self.limiter = RateLimiter(calls=1000, period=86400)

    async def cog_load(self) -> None:
        logger.info("Cards cog loaded (PokemonTCG key: %s)", "yes" if POKEMON_TCG_API_KEY else "no")

    async def cog_unload(self) -> None:
        await self.api.close()

    cards_group = app_commands.Group(name="cards", description="Trading card commands")

    @cards_group.command(name="search", description="Search for a Pokemon card")
    @app_commands.describe(name="Card name to search for")
    async def cards_search(self, interaction: discord.Interaction, name: str) -> None:
        await interaction.response.defer()
        await self.limiter.acquire()

        # TODO: Implement card search
        # GET /cards?q=name:{name}&pageSize=5
        await interaction.followup.send(f"Search results for `{name}` — coming soon!")

    @cards_group.command(name="price", description="Get price for a Pokemon card")
    @app_commands.describe(card_id="Card ID (e.g., base1-4)")
    async def cards_price(self, interaction: discord.Interaction, card_id: str) -> None:
        await interaction.response.defer()
        await self.limiter.acquire()

        # TODO: Implement card price lookup
        # GET /cards/{card_id} — prices in cardmarket/tcgplayer fields
        await interaction.followup.send(f"Price for card `{card_id}` — coming soon!")

    @cards_group.command(name="set", description="Get info about a card set")
    @app_commands.describe(set_name="Set name to search for")
    async def cards_set(self, interaction: discord.Interaction, set_name: str) -> None:
        await interaction.response.defer()
        await self.limiter.acquire()

        # TODO: Implement set search
        # GET /sets?q=name:{set_name}
        await interaction.followup.send(f"Set info for `{set_name}` — coming soon!")


async def setup(bot: commands.Bot) -> None:
    await bot.add_cog(CardsCog(bot))
