"""Shared embed builder with watermark logic for free tier."""

from datetime import datetime, timezone
from typing import Optional

import discord

from bot.utils.config import FREE_TIER_WATERMARK

# Color constants by vertical
COLORS = {
    "stocks": 0x1DB954,
    "crypto": 0xF7931A,
    "sports": 0xFF4500,
    "cards": 0xFFCB05,
    "realestate": 0x4A90D9,
    "news": 0x808080,
    "misc": 0x9B59B6,
    "success": 0x2ECC71,
    "error": 0xE74C3C,
}

WATERMARK_TEXT = "Powered by MonitorBot | discord.gg/invite"


def create_embed(
    title: str,
    description: str = "",
    color: int = 0x36A2B1,
    fields: Optional[list[tuple[str, str, bool]]] = None,
    footer_override: Optional[str] = None,
    thumbnail_url: Optional[str] = None,
    image_url: Optional[str] = None,
    url: Optional[str] = None,
    is_free_tier: bool = True,
) -> discord.Embed:
    """Build a standardized Discord embed.

    Args:
        title: Embed title.
        description: Embed body text.
        color: Hex color int.
        fields: List of (name, value, inline) tuples.
        footer_override: Custom footer text (overrides watermark).
        thumbnail_url: URL for thumbnail image.
        image_url: URL for main image.
        url: Clickable URL for the title.
        is_free_tier: Whether the server is on free tier.
    """
    embed = discord.Embed(
        title=title,
        description=description,
        color=color,
        timestamp=datetime.now(timezone.utc),
        url=url,
    )

    if fields:
        for name, value, inline in fields:
            embed.add_field(name=name, value=value, inline=inline)

    if thumbnail_url:
        embed.set_thumbnail(url=thumbnail_url)

    if image_url:
        embed.set_image(url=image_url)

    # Footer logic: watermark on free tier, custom otherwise
    if footer_override:
        embed.set_footer(text=footer_override)
    elif is_free_tier and FREE_TIER_WATERMARK:
        embed.set_footer(text=WATERMARK_TEXT)

    return embed
