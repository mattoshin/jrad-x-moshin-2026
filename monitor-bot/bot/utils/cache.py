"""Simple async dict-based cache with TTL support."""

import time
import asyncio
from typing import Any, Optional


class Cache:
    """TTL-based async cache using an in-memory dictionary."""

    def __init__(self) -> None:
        self._store: dict[str, tuple[Any, float]] = {}
        self._lock = asyncio.Lock()

    async def get(self, key: str) -> Optional[Any]:
        """Return cached value or None if expired/missing."""
        async with self._lock:
            if key in self._store:
                value, expiry = self._store[key]
                if time.monotonic() < expiry:
                    return value
                del self._store[key]
        return None

    async def set(self, key: str, value: Any, ttl_seconds: int) -> None:
        """Store a value with a TTL."""
        async with self._lock:
            self._store[key] = (value, time.monotonic() + ttl_seconds)

    async def clear(self) -> None:
        """Clear all cached entries."""
        async with self._lock:
            self._store.clear()

    async def cleanup(self) -> None:
        """Remove all expired entries."""
        now = time.monotonic()
        async with self._lock:
            expired = [k for k, (_, exp) in self._store.items() if now >= exp]
            for k in expired:
                del self._store[k]
