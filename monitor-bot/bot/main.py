"""Bot entry point — auto-loads cogs, handles errors, graceful shutdown."""

import asyncio
import logging
import os
import signal
import sys

import discord
from discord.ext import commands

from bot.utils.config import DISCORD_TOKEN, LOG_LEVEL

# Logging setup
logging.basicConfig(
    level=getattr(logging, LOG_LEVEL, logging.INFO),
    format="%(asctime)s [%(levelname)s] %(name)s: %(message)s",
    handlers=[
        logging.StreamHandler(),
        logging.FileHandler("bot.log", encoding="utf-8"),
    ],
)
logger = logging.getLogger("monitor-bot")


class MonitorBot(commands.Bot):
    """Main bot class with auto cog loading and graceful shutdown."""

    def __init__(self) -> None:
        intents = discord.Intents.default()
        intents.message_content = True
        intents.guilds = True

        super().__init__(
            command_prefix=commands.when_mentioned_or("!"),
            intents=intents,
            help_command=None,
        )

    async def setup_hook(self) -> None:
        """Auto-load all cogs from the cogs/ directory."""
        cogs_dir = os.path.join(os.path.dirname(__file__), "cogs")
        for filename in sorted(os.listdir(cogs_dir)):
            if filename.endswith(".py") and not filename.startswith("_"):
                cog_name = f"bot.cogs.{filename[:-3]}"
                try:
                    await self.load_extension(cog_name)
                    logger.info("Loaded cog: %s", cog_name)
                except Exception as e:
                    logger.warning("Failed to load cog %s: %s", cog_name, e)

    async def on_ready(self) -> None:
        logger.info("Logged in as %s (ID: %s)", self.user, self.user.id)
        logger.info("Connected to %d guild(s)", len(self.guilds))
        # Sync slash commands
        try:
            synced = await self.tree.sync()
            logger.info("Synced %d slash command(s)", len(synced))
        except Exception as e:
            logger.warning("Failed to sync commands: %s", e)

    async def on_command_error(
        self, ctx: commands.Context, error: commands.CommandError
    ) -> None:
        """Global error handler — log and continue, never crash."""
        if isinstance(error, commands.CommandNotFound):
            return
        if isinstance(error, commands.MissingPermissions):
            await ctx.send("You don't have permission to use this command.")
            return
        if isinstance(error, commands.CommandOnCooldown):
            await ctx.send(f"Command on cooldown. Try again in {error.retry_after:.1f}s.")
            return
        logger.error("Unhandled command error in %s: %s", ctx.command, error)


def main() -> None:
    """Run the bot with graceful shutdown handling."""
    if not DISCORD_TOKEN:
        logger.critical("DISCORD_TOKEN not set in environment. Exiting.")
        sys.exit(1)

    bot = MonitorBot()

    async def shutdown(sig: signal.Signals) -> None:
        logger.info("Received %s, shutting down...", sig.name)
        await bot.close()

    async def runner() -> None:
        async with bot:
            # Register signal handlers for graceful shutdown
            loop = asyncio.get_running_loop()
            for sig in (signal.SIGINT, signal.SIGTERM):
                loop.add_signal_handler(sig, lambda s=sig: asyncio.create_task(shutdown(s)))
            await bot.start(DISCORD_TOKEN)

    try:
        asyncio.run(runner())
    except KeyboardInterrupt:
        logger.info("Bot stopped by keyboard interrupt.")


if __name__ == "__main__":
    main()
