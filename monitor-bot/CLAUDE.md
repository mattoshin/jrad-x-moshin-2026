# MonitorBot — Discord Multi-Vertical Data Bot

## Project Overview
MonitorBot is a multi-vertical Discord bot that delivers real-time data across stocks, crypto, sports betting, trading cards, real estate, news/sentiment, and miscellaneous categories. Built as a freemium SaaS — free tier embeds include a watermark footer.

## Tech Stack
- **Python 3.11+** with **discord.py v2.0+** (slash commands via `app_commands`)
- **aiohttp** for all HTTP requests (never use `requests` — it blocks the event loop)
- **python-dotenv** for environment config
- **Railway** for deployment (Dockerfile + railway.toml)

## Architecture

### Directory Structure
```
monitor-bot/
├── bot/
│   ├── main.py              # Entry point — auto-loads cogs, error handling
│   ├── cogs/                 # One file per vertical
│   │   ├── stocks.py         # Finnhub — fully functional reference cog
│   │   ├── crypto.py         # CoinGecko, Fear & Greed, DeFi Llama
│   │   ├── sports.py         # The Odds API, ESPN
│   │   ├── cards.py          # PokemonTCG.io
│   │   ├── realestate.py     # FRED, Redfin
│   │   ├── news.py           # GDELT, Finnhub news
│   │   └── misc.py           # CheapShark, USASpending, NWS
│   ├── services/
│   │   ├── api_client.py     # Shared aiohttp client with retry/backoff
│   │   └── webhook_manager.py # Rate-aware webhook delivery
│   └── utils/
│       ├── config.py         # Env var loader, CACHE_TTL, RATE_LIMITS
│       ├── cache.py          # Async TTL dict cache
│       ├── rate_limiter.py   # Token bucket algorithm
│       └── embeds.py         # Embed builder with free-tier watermark
├── tests/
├── docs/
├── .env.example
├── requirements.txt
├── Dockerfile
└── railway.toml
```

### Key Patterns

**Cog Pattern** — Every cog follows the `stocks.py` pattern:
1. `__init__` creates ApiClient, Cache, RateLimiter instances
2. `cog_load` logs status (API key present or not)
3. `cog_unload` closes all API sessions
4. Slash commands use `app_commands.Group` for namespacing
5. Cache before API calls, rate-limit before external requests
6. Use `create_embed()` for all embeds (handles watermark)

**API Client** — Always use `ApiClient` from `bot.services.api_client`:
- 3 retries with exponential backoff (1s, 2s, 4s)
- Handles 429 rate limits via `Retry-After` header
- Shared aiohttp session per client instance

**Caching** — `Cache` from `bot.utils.cache`:
- TTL-based, per-vertical TTLs in `config.py`
- Always check cache before API call
- Cache key format: `{vertical}_{endpoint}_{params}`

**Rate Limiting** — `RateLimiter` from `bot.utils.rate_limiter`:
- Token bucket algorithm, per-API limits in `config.py`
- Call `await self.limiter.acquire()` before every external API call

**Embeds** — `create_embed()` from `bot.utils.embeds`:
- Always use this function, never build `discord.Embed` directly
- Free-tier embeds auto-append watermark footer
- Color constants: `COLORS["stocks"]`, `COLORS["crypto"]`, etc.

## API Rate Limits (Free Tiers)
| API | Limit | Period |
|-----|-------|--------|
| Finnhub | 60 calls | per minute |
| CoinGecko | 30 calls | per minute |
| The Odds API | 500 credits | per month |
| PokemonTCG.io | 20,000 requests | per day |
| FRED | 120 calls | per minute |
| GDELT | 100 calls | per minute |
| CheapShark | 60 calls | per minute |
| NWS | 60 calls | per minute |
| ESPN | unlimited | no key needed |
| Alternative.me F&G | unlimited | no key needed |
| DeFi Llama | unlimited | no key needed |

## Coding Conventions
- Type hints on all function signatures
- Docstrings on classes and public methods
- `logger = logging.getLogger(__name__)` at module level
- Never block the event loop — use `aiohttp`, never `requests`
- Degrade gracefully when API keys are missing (log warning, return user-friendly message)
- All secrets via environment variables, never hardcode

## Running
```bash
cp .env.example .env
# Fill in DISCORD_TOKEN (required) and optional API keys
pip install -r requirements.txt
python -m bot.main
```

## Testing
```bash
python -m pytest tests/ -v
```
