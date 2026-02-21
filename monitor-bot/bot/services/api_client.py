"""Base aiohttp client with retry, backoff, and shared session."""

import logging
from typing import Any, Optional

import aiohttp

logger = logging.getLogger(__name__)


class ApiClient:
    """Async HTTP client with automatic retry and exponential backoff.

    Args:
        base_url: Base URL for all requests.
        headers: Default headers to include.
        max_retries: Number of retries on failure.
    """

    def __init__(
        self,
        base_url: str = "",
        headers: Optional[dict[str, str]] = None,
        max_retries: int = 3,
    ) -> None:
        self.base_url = base_url.rstrip("/")
        self.headers = headers or {}
        self.max_retries = max_retries
        self._session: Optional[aiohttp.ClientSession] = None

    async def _get_session(self) -> aiohttp.ClientSession:
        """Get or create the shared aiohttp session."""
        if self._session is None or self._session.closed:
            self._session = aiohttp.ClientSession(headers=self.headers)
        return self._session

    async def close(self) -> None:
        """Close the aiohttp session."""
        if self._session and not self._session.closed:
            await self._session.close()

    async def get(
        self,
        endpoint: str,
        params: Optional[dict[str, Any]] = None,
        headers: Optional[dict[str, str]] = None,
    ) -> Optional[dict]:
        """GET request with retry logic."""
        return await self._request("GET", endpoint, params=params, headers=headers)

    async def post(
        self,
        endpoint: str,
        json: Optional[dict] = None,
        headers: Optional[dict[str, str]] = None,
    ) -> Optional[dict]:
        """POST request with retry logic."""
        return await self._request("POST", endpoint, json=json, headers=headers)

    async def _request(
        self,
        method: str,
        endpoint: str,
        params: Optional[dict] = None,
        json: Optional[dict] = None,
        headers: Optional[dict[str, str]] = None,
    ) -> Optional[dict]:
        """Execute an HTTP request with exponential backoff retry."""
        import asyncio

        url = f"{self.base_url}/{endpoint.lstrip('/')}" if self.base_url else endpoint
        session = await self._get_session()
        backoff_delays = [1, 2, 4]  # seconds

        for attempt in range(self.max_retries):
            try:
                async with session.request(
                    method, url, params=params, json=json, headers=headers
                ) as resp:
                    if resp.status == 200:
                        return await resp.json()
                    elif resp.status == 429:
                        # Rate limited — wait and retry
                        retry_after = float(
                            resp.headers.get("Retry-After", backoff_delays[attempt])
                        )
                        logger.warning(
                            "Rate limited on %s %s, waiting %.1fs", method, url, retry_after
                        )
                        await asyncio.sleep(retry_after)
                        continue
                    else:
                        logger.warning(
                            "%s %s returned status %d", method, url, resp.status
                        )
                        if attempt < self.max_retries - 1:
                            await asyncio.sleep(backoff_delays[attempt])
                        continue
            except (aiohttp.ClientError, asyncio.TimeoutError) as e:
                logger.warning(
                    "%s %s attempt %d failed: %s", method, url, attempt + 1, e
                )
                if attempt < self.max_retries - 1:
                    await asyncio.sleep(backoff_delays[attempt])
                continue

        logger.error("All %d attempts failed for %s %s", self.max_retries, method, url)
        return None
