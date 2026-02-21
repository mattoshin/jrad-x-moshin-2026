# Embed Standards

All bot responses use standardized Discord embeds built via `create_embed()` in `bot/utils/embeds.py`.

## Color Palette

| Vertical | Color | Hex |
|----------|-------|-----|
| Stocks | Green | `0x1DB954` |
| Crypto | Bitcoin Orange | `0xF7931A` |
| Sports | Reddit Orange | `0xFF4500` |
| Cards | Pokemon Yellow | `0xFFCB05` |
| Real Estate | Blue | `0x4A90D9` |
| News | Gray | `0x808080` |
| Misc | Purple | `0x9B59B6` |
| Success | Green | `0x2ECC71` |
| Error | Red | `0xE74C3C` |

## Embed Structure

```
┌─────────────────────────────────────────┐
│ Title (max 256 chars)                   │
│─────────────────────────────────────────│
│ Description (max 4096 chars)            │
│                                         │
│ Field 1 Name    Field 2 Name (inline)   │
│ Field 1 Value   Field 2 Value           │
│                                         │
│ Field 3 Name (full width)               │
│ Field 3 Value                           │
│─────────────────────────────────────────│
│ Footer: Powered by MonitorBot           │
│ Timestamp: 2026-02-21 12:00 UTC         │
└─────────────────────────────────────────┘
```

## Usage

```python
from bot.utils.embeds import COLORS, create_embed

embed = create_embed(
    title="Title Here",
    description="Description text",
    color=COLORS["stocks"],
    fields=[
        ("Field Name", "Field Value", True),   # inline
        ("Field Name", "Field Value", False),  # full width
    ],
    thumbnail_url="https://example.com/thumb.png",
    image_url="https://example.com/image.png",
    url="https://example.com",
    footer_override="Custom footer (overrides watermark)",
    is_free_tier=True,  # adds watermark footer
)
```

## Free Tier Watermark

When `FREE_TIER_WATERMARK=true` (default) and `is_free_tier=True`:
- Footer text: `"Powered by MonitorBot | discord.gg/invite"`
- Paid servers can disable via subscription dashboard

## Conventions

1. **Prices**: Always format with `$` and 2 decimal places: `$123.45`
2. **Percentages**: Include sign and 2 decimals: `+1.23%`, `-4.56%`
3. **Arrows**: Use `⬆️` for positive, `⬇️` for negative changes
4. **Timestamps**: All embeds auto-include UTC timestamp
5. **Fields**: Use inline=True for 2-3 related values side-by-side
6. **Truncation**: Truncate long titles to 256 chars, field values to 1024 chars
7. **Error embeds**: Use `COLORS["error"]` with clear message, no stack traces
