"""Load environment variables with sensible defaults."""

import os
from dotenv import load_dotenv

load_dotenv()


def get_env(key: str, default: str = "") -> str:
    """Get an environment variable with a default fallback."""
    return os.getenv(key, default)


# Discord
DISCORD_TOKEN: str = get_env("DISCORD_TOKEN")
BOT_PREFIX: str = get_env("BOT_PREFIX", "!")

# API Keys
FINNHUB_API_KEY: str = get_env("FINNHUB_API_KEY")
COINGECKO_API_KEY: str = get_env("COINGECKO_API_KEY")
ODDS_API_KEY: str = get_env("ODDS_API_KEY")
POKEMON_TCG_API_KEY: str = get_env("POKEMON_TCG_API_KEY")
FRED_API_KEY: str = get_env("FRED_API_KEY")

# Testing
WEBHOOK_URL: str = get_env("WEBHOOK_URL")

# Feature flags
FREE_TIER_WATERMARK: bool = get_env("FREE_TIER_WATERMARK", "true").lower() == "true"
LOG_LEVEL: str = get_env("LOG_LEVEL", "INFO")

# Cache TTLs (seconds) per vertical
CACHE_TTL = {
    "stocks": 60,
    "crypto": 30,
    "sports": 120,
    "cards": 3600,
    "realestate": 86400,
    "news": 300,
    "misc": 600,
}

# Rate limits per API (calls, period_seconds)
RATE_LIMITS = {
    "finnhub": (60, 60),
    "coingecko": (30, 60),
    "odds_api": (10, 60),
    "sec_edgar": (10, 1),
    "pokemon_tcg": (1000, 86400),
    "gdelt": (100, 60),
    "fred": (120, 60),
    "cheapshark": (60, 60),
    "nws": (60, 60),
}
