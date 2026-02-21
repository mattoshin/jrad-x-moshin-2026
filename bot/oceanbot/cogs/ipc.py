import os
import sys
import logging
import discord
import requests
import json
import time

from discord.ext import commands, ipc
from discord.ext.ipc.server import route
from discord.ext.ipc.errors import IPCError

class Routes(commands.Cog):
    def __init__(self, bot: commands.Bot):
        self.bot = bot
        if not hasattr(bot, "ipc"):
            bot.ipc = ipc.Server(self.bot, host="127.0.0.1", port=2300, secret_key=os.getenv('BOT_IPC_SECRET', 'change-me-in-production'))
            bot.ipc.start()

    @commands.Cog.listener()
    async def on_ipc_ready(self):
        logging.info("Ipc is ready")
    
    @commands.Cog.listener()
    async def on_ipc_error(self, endpoint: str, error: IPCError):
        logging.error(endpoint, "raised", error)
    
    @route()
    async def get_server(self, data):
        guild = self.bot.get_guild(data.guild_id)
        if (guild != None):
            return {
                "guild":{
                    "id": guild.id,
                    "name": guild.name,
                    "owner": guild.owner_id,
                    "members": guild.member_count,
                    "categories": len(guild.categories),
                    "text_channels": len(guild.text_channels),
                    "voice_channels": len(guild.voice_channels),
                    "roles": len(guild.roles),
                    "region": guild.preferred_locale[1]

                }
            }
        else:
            return {
                "guild": None
            }

    @route()
    async def create_monitor(self, data):
        url = "https://admin.mocean.info/api/fulfillment/plan/%s" % (str(data.monitor_id))
        print(url)
        orderRequest = requests.get(url)
        print(orderRequest.text)
        if (orderRequest.json()["server"]):
            jsonBody = orderRequest.json()
            guild = self.bot.get_guild(jsonBody["server"])
            if (guild != None):
                controlcat = await self.bot.fetch_channel(jsonBody["control_category"]["category"])
                category = await guild.create_category(name=controlcat.name)
                jsonData = {
                    "plan": data.monitor_id,     
                    "control_category": jsonBody["control_category"]["id"],
                    "categoryid": category.id
                }
                requests.post("https://admin.mocean.info/api/bot/categories/client", data=jsonData)

                time.sleep(5)
                for channel in controlcat.channels:
                    newChannel = await category.create_text_channel(name=channel.name)
                    createUrl = "https://admin.mocean.info/api/bot/channels/client"
                    jsonData = {
                        
                        "plan": data.monitor_id,
                        "category": category.id,
                        "control_channel": channel.id,
                        "channel": newChannel.id
                    }
                    createClientChannel = requests.post(createUrl, data=jsonData)
                    print(createClientChannel.text)
                return {"guild":"success"}
            else:
                return {
                    "guild": None
                }
        else:
            return {
                "guild": None
            }

    @route()
    async def get_monitor(self, data):
        controlcat = await self.bot.fetch_channel(str(data.monitor_id))
        controlUrl = "https://admin.mocean.info/api/bot/channels/control"
        time.sleep(1)
        for channel in controlcat.channels:
            
            controlJson = {
                "category": channel.category_id,
                "channel": channel.id,
                "name": channel.name
            }
            createControlChannel = requests.post(controlUrl, data=controlJson)
        return {"guild":"success"}

    @route()
    async def send_announcement(self, data):
        guild = self.bot.get_guild(data.guild_id)
        if (guild != None):
            updateChannelSearch = discord.utils.get(self.bot.get_all_channels(), guild__id=data.guild_id, name='mocean-announcements')
            if (updateChannelSearch == None):
                overwrites = {
                    guild.default_role: discord.PermissionOverwrite(read_messages=False),
                    guild.me: discord.PermissionOverwrite(read_messages=True)
                }

                newChannel = await guild.create_text_channel(name='mocean-announcements', overwrites=overwrites)
                sendMessage = await newChannel.send(content=str(data.announcement))
                print(sendMessage)
            else:
                sendMessage = await updateChannelSearch.send(content=str(data.announcement))
        else:
            print(guild)
        return {"guild":"success"}

    @route()
    async def send_announcements(self, data):
        url = "https://admin.mocean.info/api/bot/servers/%s" % (str(data.product))
        orderRequest = requests.get(url)
        for guildid in orderRequest.json():
            guild = self.bot.get_guild(guildid)
            if (guild != None):
                updateChannelSearch = discord.utils.get(self.bot.get_all_channels(), guild__id=guildid, name='mocean-announcements')
                if (updateChannelSearch == None):
                    overwrites = {
                        guild.default_role: discord.PermissionOverwrite(read_messages=False),
                        guild.me: discord.PermissionOverwrite(read_messages=True)
                    }
                    newChannel = await guild.create_text_channel(name='mocean-announcements', overwrites=overwrites)
                    sendMessage = await newChannel.send(content=str(data.announcement))
                    print(sendMessage)
                else:
                    sendMessage = await updateChannelSearch.send(content=str(data.announcement))
            else:
                print(guild)
        return {"guild":"success"}

async def setup(bot):
    await bot.add_cog(Routes(bot))
