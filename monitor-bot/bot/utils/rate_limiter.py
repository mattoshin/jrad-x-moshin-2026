"""Per-API rate limiter using token bucket algorithm."""

import asyncio
import time


class RateLimiter:
    """Token bucket rate limiter for API calls.

    Args:
        calls: Maximum number of calls allowed per period.
        period: Time period in seconds.
    """

    def __init__(self, calls: int, period: float) -> None:
        self.calls = calls
        self.period = period
        self._tokens = float(calls)
        self._last_refill = time.monotonic()
        self._lock = asyncio.Lock()

    async def acquire(self) -> None:
        """Wait until a token is available, then consume one."""
        while True:
            async with self._lock:
                now = time.monotonic()
                elapsed = now - self._last_refill
                self._tokens = min(
                    self.calls, self._tokens + elapsed * (self.calls / self.period)
                )
                self._last_refill = now

                if self._tokens >= 1.0:
                    self._tokens -= 1.0
                    return

            # Wait a bit before retrying
            wait_time = (1.0 - self._tokens) * (self.period / self.calls)
            await asyncio.sleep(wait_time)
