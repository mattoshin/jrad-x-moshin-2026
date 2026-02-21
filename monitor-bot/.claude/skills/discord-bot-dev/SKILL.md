# Skill: Discord Bot Developer

## Description
Specialized skill for developing and extending the MonitorBot Discord bot. Use this skill when adding new cogs, commands, API integrations, or modifying bot behavior.

## When to Use
- Adding a new slash command or command group
- Integrating a new external API
- Adding background monitoring tasks
- Debugging discord.py interactions
- Modifying embed formatting or caching behavior

## Cog Development Checklist

### Creating a New Cog
1. Create `bot/cogs/{name}.py` following the `stocks.py` pattern
2. Add module-level docstring listing APIs, rate limits, and slash commands
3. Create a class inheriting `commands.Cog` with `name` parameter
4. In `__init__`: create `ApiClient`, `Cache`, `RateLimiter` instances
5. In `cog_load`: log whether API keys are configured
6. In `cog_unload`: close all API client sessions
7. Create an `app_commands.Group` for namespaced slash commands
8. Add `setup(bot)` async function at module bottom
9. Add API key to `config.py` and `.env.example` if needed
10. Add rate limit entry to `RATE_LIMITS` dict in `config.py`
11. Add cache TTL entry to `CACHE_TTL` dict in `config.py`

### Adding a Slash Command
```python
@group.command(name="cmd", description="Short description")
@app_commands.describe(param="Parameter description")
async def cmd_name(self, interaction: discord.Interaction, param: str) -> None:
    # 1. Check API key if required
    if not API_KEY:
        await interaction.response.send_message("API key not configured.", ephemeral=True)
        return

    # 2. Defer response (required for API calls that may take >3s)
    await interaction.response.defer()

    # 3. Check cache
    cached = await self.cache.get(cache_key)
    if cached:
        data = cached
    else:
        # 4. Rate limit before external call
        await self.limiter.acquire()
        # 5. Make API call
        data = await self.api.get("/endpoint", params={...})
        if data:
            await self.cache.set(cache_key, data, CACHE_TTL["vertical"])

    # 6. Build embed with create_embed()
    embed = create_embed(title="...", color=COLORS["vertical"], fields=[...])

    # 7. Send response
    await interaction.followup.send(embed=embed)
```

### Adding a Background Task
```python
@tasks.loop(minutes=5)
async def my_monitor_loop(self) -> None:
    # Check conditions, fetch data, send webhook alerts
    pass

@my_monitor_loop.before_loop
async def before_my_monitor(self) -> None:
    await self.bot.wait_until_ready()
```

## Common Patterns

### Error Handling in Commands
- Always defer before API calls: `await interaction.response.defer()`
- Check for missing API keys early with `ephemeral=True` error
- Return user-friendly messages on API failures
- Never expose raw API errors to users

### Cache Key Convention
```
{vertical}_{endpoint}_{identifier}
# Examples:
stock_quote_AAPL
crypto_fng
gdelt_search_bitcoin
cheapshark_deals_top
```

### Embed Field Limits
- Title: max 256 characters
- Description: max 4096 characters
- Field name: max 256 characters
- Field value: max 1024 characters
- Max 25 fields per embed
- Total embed size: max 6000 characters

## Files Reference
- **Entry point**: `bot/main.py`
- **Reference cog**: `bot/cogs/stocks.py` (fully functional)
- **API client**: `bot/services/api_client.py`
- **Cache**: `bot/utils/cache.py`
- **Rate limiter**: `bot/utils/rate_limiter.py`
- **Embeds**: `bot/utils/embeds.py`
- **Config**: `bot/utils/config.py`
