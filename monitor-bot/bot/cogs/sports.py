"""Sports betting cog — The Odds API, ESPN.

APIs used:
- The Odds API (https://api.the-odds-api.com/v4) — 500 credits/month free
- ESPN undocumented API (https://site.api.espn.com) — free, no key

Slash commands:
- /sports odds <sport> — live odds for a sport
- /sports scores <sport> — live scores from ESPN
- /sports schedule <sport> — upcoming games
"""

import logging

import discord
from discord import app_commands
from discord.ext import commands

from bot.services.api_client import ApiClient
from bot.utils.cache import Cache
from bot.utils.config import ODDS_API_KEY, CACHE_TTL
from bot.utils.embeds import COLORS, create_embed
from bot.utils.rate_limiter import RateLimiter

logger = logging.getLogger(__name__)

SPORTS_MAP = {
    "nfl": "americanfootball_nfl",
    "nba": "basketball_nba",
    "mlb": "baseball_mlb",
    "nhl": "icehockey_nhl",
    "soccer": "soccer_epl",
    "mma": "mma_mixed_martial_arts",
}


class SportsCog(commands.Cog, name="Sports"):
    """Sports betting odds and scores."""

    def __init__(self, bot: commands.Bot) -> None:
        self.bot = bot
        self.odds_api = ApiClient(base_url="https://api.the-odds-api.com/v4")
        self.espn_api = ApiClient(base_url="https://site.api.espn.com/apis/site/v2")
        self.cache = Cache()
        self.limiter = RateLimiter(calls=10, period=60)

    async def cog_load(self) -> None:
        logger.info("Sports cog loaded (Odds API key: %s)", "yes" if ODDS_API_KEY else "no")

    async def cog_unload(self) -> None:
        await self.odds_api.close()
        await self.espn_api.close()

    sports_group = app_commands.Group(name="sports", description="Sports betting commands")

    @sports_group.command(name="odds", description="Get live betting odds")
    @app_commands.describe(sport="Sport (nfl, nba, mlb, nhl, soccer, mma)")
    async def sports_odds(self, interaction: discord.Interaction, sport: str) -> None:
        await interaction.response.defer()

        if not ODDS_API_KEY:
            await interaction.followup.send("Odds API key not configured.", ephemeral=True)
            return

        # TODO: Implement odds lookup
        # GET /sports/{sport_key}/odds?apiKey={key}&regions=us&markets=h2h
        await interaction.followup.send(f"Odds for `{sport}` — coming soon!")

    @sports_group.command(name="scores", description="Get live scores")
    @app_commands.describe(sport="Sport (nfl, nba, mlb, nhl)")
    async def sports_scores(self, interaction: discord.Interaction, sport: str) -> None:
        """Live scores from ESPN — no API key required."""
        await interaction.response.defer()

        # TODO: Implement ESPN scores
        # GET /sports/{sport_path}/scoreboard
        await interaction.followup.send(f"Live scores for `{sport}` — coming soon!")

    @sports_group.command(name="schedule", description="Get upcoming games")
    @app_commands.describe(sport="Sport (nfl, nba, mlb, nhl)")
    async def sports_schedule(self, interaction: discord.Interaction, sport: str) -> None:
        await interaction.response.defer()

        # TODO: Implement schedule lookup from ESPN
        await interaction.followup.send(f"Schedule for `{sport}` — coming soon!")


async def setup(bot: commands.Bot) -> None:
    await bot.add_cog(SportsCog(bot))
