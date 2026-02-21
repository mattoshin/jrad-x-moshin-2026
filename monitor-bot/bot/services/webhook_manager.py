"""Webhook delivery with Discord rate limit queuing."""

import asyncio
import logging
from typing import Optional

import aiohttp
import discord

logger = logging.getLogger(__name__)

# Discord rate limit: ~5 messages per second per channel
RATE_LIMIT_DELAY = 0.25  # seconds between sends


class WebhookManager:
    """Send embeds via webhook URL with rate limit awareness.

    Args:
        webhook_url: Discord webhook URL.
    """

    def __init__(self, webhook_url: str = "") -> None:
        self.webhook_url = webhook_url
        self._queue: asyncio.Queue[discord.Embed] = asyncio.Queue()
        self._session: Optional[aiohttp.ClientSession] = None
        self._running = False

    async def _get_session(self) -> aiohttp.ClientSession:
        if self._session is None or self._session.closed:
            self._session = aiohttp.ClientSession()
        return self._session

    async def send(self, embed: discord.Embed, webhook_url: Optional[str] = None) -> bool:
        """Send an embed via webhook. Returns True on success."""
        url = webhook_url or self.webhook_url
        if not url:
            logger.error("No webhook URL configured")
            return False

        session = await self._get_session()
        payload = {"embeds": [embed.to_dict()]}

        try:
            async with session.post(url, json=payload) as resp:
                if resp.status == 204:
                    return True
                elif resp.status == 429:
                    retry_after = (await resp.json()).get("retry_after", 1.0)
                    logger.warning("Webhook rate limited, waiting %.1fs", retry_after)
                    await asyncio.sleep(retry_after)
                    # Retry once
                    async with session.post(url, json=payload) as retry_resp:
                        return retry_resp.status == 204
                else:
                    logger.warning("Webhook send failed with status %d", resp.status)
                    return False
        except (aiohttp.ClientError, asyncio.TimeoutError) as e:
            logger.error("Webhook send error: %s", e)
            return False

    async def send_batch(
        self, embeds: list[discord.Embed], webhook_url: Optional[str] = None
    ) -> int:
        """Send multiple embeds with rate limiting. Returns count of successful sends."""
        sent = 0
        for embed in embeds:
            if await self.send(embed, webhook_url):
                sent += 1
            await asyncio.sleep(RATE_LIMIT_DELAY)
        return sent

    async def close(self) -> None:
        """Close the aiohttp session."""
        if self._session and not self._session.closed:
            await self._session.close()
