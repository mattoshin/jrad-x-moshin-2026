"""Tests for the embed builder utility."""

import unittest
from unittest.mock import patch

import discord

from bot.utils.embeds import COLORS, WATERMARK_TEXT, create_embed


class TestCreateEmbed(unittest.TestCase):
    """Tests for create_embed function."""

    def test_basic_embed(self):
        """Embed should have title, description, and color."""
        embed = create_embed(title="Test", description="Hello", color=0xFF0000)
        assert embed.title == "Test"
        assert embed.description == "Hello"
        assert embed.color == discord.Color(0xFF0000)

    def test_default_color(self):
        """Embed should use default color when none specified."""
        embed = create_embed(title="Test")
        assert embed.color == discord.Color(0x36A2B1)

    def test_fields_added(self):
        """Fields should be added to the embed."""
        fields = [
            ("Name1", "Value1", True),
            ("Name2", "Value2", False),
        ]
        embed = create_embed(title="Test", fields=fields)
        assert len(embed.fields) == 2
        assert embed.fields[0].name == "Name1"
        assert embed.fields[0].value == "Value1"
        assert embed.fields[0].inline is True
        assert embed.fields[1].name == "Name2"
        assert embed.fields[1].inline is False

    def test_no_fields(self):
        """Embed without fields should have empty fields list."""
        embed = create_embed(title="Test")
        assert len(embed.fields) == 0

    @patch("bot.utils.embeds.FREE_TIER_WATERMARK", True)
    def test_free_tier_watermark(self):
        """Free tier embed should include watermark footer."""
        embed = create_embed(title="Test", is_free_tier=True)
        assert embed.footer.text == WATERMARK_TEXT

    @patch("bot.utils.embeds.FREE_TIER_WATERMARK", True)
    def test_paid_tier_no_watermark(self):
        """Paid tier embed should not include watermark."""
        embed = create_embed(title="Test", is_free_tier=False)
        assert embed.footer is None or embed.footer.text != WATERMARK_TEXT

    @patch("bot.utils.embeds.FREE_TIER_WATERMARK", False)
    def test_watermark_disabled(self):
        """Watermark should not appear when FREE_TIER_WATERMARK is false."""
        embed = create_embed(title="Test", is_free_tier=True)
        assert embed.footer is None or embed.footer.text != WATERMARK_TEXT

    def test_footer_override(self):
        """Custom footer should override watermark."""
        embed = create_embed(title="Test", footer_override="Custom Footer")
        assert embed.footer.text == "Custom Footer"

    def test_thumbnail_url(self):
        """Thumbnail should be set when provided."""
        embed = create_embed(title="Test", thumbnail_url="https://example.com/img.png")
        assert embed.thumbnail.url == "https://example.com/img.png"

    def test_image_url(self):
        """Image should be set when provided."""
        embed = create_embed(title="Test", image_url="https://example.com/img.png")
        assert embed.image.url == "https://example.com/img.png"

    def test_url_set(self):
        """Title URL should be set when provided."""
        embed = create_embed(title="Test", url="https://example.com")
        assert embed.url == "https://example.com"

    def test_timestamp_set(self):
        """Embed should include a timestamp."""
        embed = create_embed(title="Test")
        assert embed.timestamp is not None

    def test_colors_dict(self):
        """COLORS dict should have entries for all verticals."""
        expected_keys = ["stocks", "crypto", "sports", "cards", "realestate", "news", "misc", "success", "error"]
        for key in expected_keys:
            assert key in COLORS, f"Missing color for vertical: {key}"
            assert isinstance(COLORS[key], int), f"Color for {key} should be int"


if __name__ == "__main__":
    unittest.main()
