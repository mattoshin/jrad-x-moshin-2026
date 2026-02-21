import logging, os, json, redis, requests
import discord
from colorama import Fore, Back, Style

INFO = "[\x1b[33m?\x1b[37m] "
ERROR = "[\x1b[31m-\x1b[37m] "
SUCCESS = "[\x1b[32m+\x1b[37m] "

botTrigger = "!"

logger = logging.getLogger('discord')
logger.setLevel(logging.INFO)
handler = logging.FileHandler(filename='bot.log', encoding='utf-8', mode='w')
handler.setFormatter(logging.Formatter('%(asctime)s:%(levelname)s:%(name)s: %(message)s'))
logger.addHandler(handler)
console_handler = logging.StreamHandler()
console_handler.setLevel(logging.INFO)
logger.addHandler(console_handler)

r = redis.Redis(host='localhost', port=6379, db=0)

def save_config(config_data):
    with open('config.json', 'w') as outfile:
        json.dump(config_data, outfile, indent=4, sort_keys=True)

if not os.path.exists('config.json'):
    config = {'token': '', 'text_only_messages_filtering': False,
              'synced_channels': [], 'client_channels': [], 
              "synced_servers": [], "synced_categories": [],
              "client_categories": []}
    save_config(config)
else:
    config = json.load(open("config.json"))

if config['token'] == '':
    logger.critical('Configuration file no completed : Discord token is missing')
    exit(1)
    
def checkChannel(channel):
    r = requests.get("https://admin.mocean.info/api/bot/channels/control/%s" % (channel))
    if(str(channel) not in r.text):
        return False
    else:
        try:
            if r.json()["id"] == channel:
                return r.json()
            else:
                return False
        except ValueError:
            return False


def checkControlCategory(category):
    r = requests.get("https://admin.mocean.info/api/bot/categories/control/%s" % (category))
    if(str(category) not in r.text):
        return False
    else:
        return r.json()

class MyClient(discord.Client):
    async def on_ready(self):
        print(f'Logged in as {self.user} (ID: {self.user.id})')
        print('------')

    async def on_message(self, message):
        # we do not want the bot to reply to itself
        if message.author.id == self.user.id:
            return

        # if message.content.startswith(botTrigger):
        #     content = message.content[1:].split(" ")[0]
        #     command = content.split(" ", 1)[0]
        #     commandSuffix = None
        #     if (len(message.content.split(" ")) > 1):
        #         commandSuffix = message.content.split(" ", 1)[1]

        #     if(commandSuffix):
        #         print(commandSuffix)
            
        #     if (command == "category"):
        #         await message.channel.send(message.channel.id)
        #     return
        # else:
        # if message.channel.id not in config["synced_channels"]:
        #     return
        checkChannelResponse = checkChannel(message.channel.id)
        if checkChannelResponse == False:
            return

        if checkChannelResponse["channel_type"] != "1":
            return

        broadcast_list = ""

        messagesent = 0
        for response_data in checkChannelResponse["channel_data"]:
            if response_data != message.channel.id:
                synced_channel_id = response_data["channelId"]
                channel = client.get_channel(int(synced_channel_id))
                if channel is None:
                        logger.error("Channel ID:%s does not exist or the bot is not allowed.", synced_channel_id)
                        await self.send_error_message("New Message Error", ("Channel ID:%s does not exist or the bot is not allowed." % (synced_channel_id)))
                else:
                    # emb = None
                    # if len(message.embeds) >= 1:
                    #     emb = discord.Embed(**message.embeds[0])
                    
                    
                    if response_data["role"] != None:
                        messagecontent = message.content.replace("@roles", "<@&%s>" % (response_data["role"]))
                        
                    else:
                        messagecontent = message.content

                    if (message.embeds):
                        if(message.embeds[0].title):
                            if(message.embeds[0].url):
                                embed = discord.Embed(
                                    title=message.embeds[0].title,
                                    description=message.embeds[0].description,
                                    url=message.embeds[0].url,
                                    colour=0x36a2b1
                                )
                            else:
                                embed = discord.Embed(
                                    title=message.embeds[0].title,
                                    description=message.embeds[0].description,
                                    colour=0x36a2b1
                                )
                        else:
                            embed = discord.Embed(
                                title=message.embeds[0].title,
                                description=message.embeds[0].description,
                                colour=0x36a2b1
                            )


                        if(message.embeds[0].thumbnail.url):
                            embed.set_thumbnail(message.embeds[0].thumbnail.url)
                            # print(message.embeds[0].thumbnail)

                        if(message.embeds[0].image.url):
                            embed.set_image(message.embeds[0].image.url)
                        if(message.embeds[0].fields):
                            for field in message.embeds[0].fields:
                                embed.add_field(name=field.name, value=field.value, inline=False)
                        embed.set_footer(icon_url='https://demo.mocean.info/static/media/logo.ea13ac93d258993e52c2.png', text='Powered by https://mocean.info/')
                        send_message = await channel.send(embed=embed)
                    else:
                        embed = discord.Embed(colour=0x36a2b1, description=messagecontent)        
                        if message.attachments:
                            # embed = discord.Embed(title="Mocean Monitors", colour=0x36a2b1, description=messagecontent)                            #
                            embed.set_image(url=message.attachments[0].url)
                            # embed.set_footer(icon_url='https://demo.mocean.info/static/media/logo.ea13ac93d258993e52c2.png', text='Powered by https://mocean.info/')
                            # send_message = await channel.send(embed=embed)
                            # messagesent += 1
                            # r.rpush('message:%s' % (message.id), '%s:%s' % (channel.id,send_message.id))
                            # broadcast_list += "\n - {0} (ID:{1}) : Message ID:{2}".format(channel.guild.name,
                            #                                                             channel.guild.id,
                            #                                                             send_message.id)
                        # else:
                        #     embed = discord.Embed(title="Mocean Monitors", colour=0x36a2b1, description=messagecontent)
                        #     embed.set_footer(icon_url='https://demo.mocean.info/static/media/logo.ea13ac93d258993e52c2.png', text='Powered by https://mocean.info/')
                        #     send_message = await channel.send(embed=embed)
                        #     messagesent += 1
                        #     r.rpush('message:%s' % (message.id), '%s:%s' % (channel.id,send_message.id))
                        #     broadcast_list += "\n - {0} (ID:{1}) : Message ID:{2}".format(channel.guild.name,
                        #                                                                 channel.guild.id,
                        #                                                                 send_message.id)
                        
                        embed.set_footer(icon_url='https://demo.mocean.info/static/media/logo.ea13ac93d258993e52c2.png', text='Powered by https://mocean.info/')
                        
                    
                        if response_data["role"] != None and "@roles" in message.content:
                            send_message = await channel.send(content=("<@&%s>" % (response_data["role"])), embed=embed)
                            
                        else:
                            send_message = await channel.send(embed=embed)

                    messagesent += 1
                    r.rpush('message:%s' % (message.id), '%s:%s' % (channel.id,send_message.id))
                    broadcast_list += "\n - {0} (ID:{1}) : Message ID:{2}".format(channel.guild.name,
                                                                                channel.guild.id,
                                                                                send_message.id)

        logger.info("Message ID:%s posted by %s (ID:%s) from server %s (ID:%s) broadcasted to : %s",
                message.id, message.author.name, message.author.id, message.guild.name, message.guild.id,
                broadcast_list)
        await self.send_success_message("New Message", ("Message ID:%s posted by %s from server %s broadcasted to : %s channels" % 
        (message.id, message.author.name, message.guild.name, messagesent)))
        await message.add_reaction("👍")

    async def on_message_edit(self, before, after):
        checkChannelResponse = checkChannel(before.channel.id)
        if checkChannelResponse == False:
            return
        
        if checkChannelResponse["channel_type"] != "1":
            return

        messagesent = 0
        for item in r.lrange('message:%s' % (before.id), 0, -1 ):
            splititem = item.decode("utf-8").split(":")
            channelid = splititem[0]
            messageid = splititem[1]
            channel = client.get_channel(int(channelid))
            if channel is None:
                    logger.error("Channel ID:%s does not exist or the bot is not allowed.", channelid)
                    await self.send_error_message("Message Edit Error", ("Channel ID:%s does not exist or the bot is not allowed." % (channelid)))
            else:
                messagetoedit = await channel.fetch_message(int(messageid))
                if messagetoedit is None:
                        logger.error("Message ID:%s does not exist or the bot is not allowed.", messagetoedit)
                        await self.send_error_message("Message Edit Error", ("Message ID:%s does not exist or the bot is not allowed." % (messageid)))
                else:
                    role = [x for x in checkChannelResponse["channel_data"] if x["role"] != None]
                    if role[0]:
                        if role[0]["role"]:
                            if role[0]["role"]!= None:
                                messagecontent = after.content.replace("@roles", ("<@&%s>" % (role[0]["role"])))
                            else:
                                messagecontent = after.content
                        else:
                            messagecontent = after.content
                    else:
                        messagecontent = after.content
                    embed = discord.Embed(colour=0x36a2b1, description=messagecontent)
                    embed.set_footer(icon_url='https://demo.mocean.info/static/media/logo.ea13ac93d258993e52c2.png', text='Powered by https://mocean.info/')
                    await messagetoedit.edit(embed=embed)
                    messagesent += 1
                    print("Edited %s" % (messageid))
        await self.send_success_message("Message Edit", ("Message ID:%s edited by %s from server %s broadcasted to : %s channels" % 
            (after.id, after.author.name, after.guild.name, messagesent)))

    async def on_message_delete(self, message):
        checkChannelResponse = checkChannel(message.channel.id)
        if checkChannelResponse == False:
            return
        

        if checkChannelResponse["channel_type"] != "1":
            return
        messagesent = 0
        for item in r.lrange('message:%s' % (message.id), 0, -1 ):
            splititem = item.decode("utf-8").split(":")
            channelid = splititem[0]
            messageid = splititem[1]
            channel = client.get_channel(int(channelid))
            if channel is None:
                    logger.error("Channel ID:%s does not exist or the bot is not allowed.", channelid)
                    await self.send_error_message("Message Delete Error", ("Channel ID:%s does not exist or the bot is not allowed." % (channelid)))
            else:
                try:
                    messagetodel = await channel.fetch_message(int(messageid))
                    if messagetodel is None:
                            logger.error("Message ID:%s does not exist or the bot is not allowed.", messageid)
                            await self.send_error_message("Message Delete Error", ("Message ID:%s does not exist or the bot is not allowed." % (messageid)))
                    else:
                        await messagetodel.delete()
                        messagesent += 1
                        print("Deleted %s" % (messageid))
                except Exception as e:
                    logger.error("Message ID:%s does not exist or the bot is not allowed.", messageid)
                    await self.send_error_message("Message Delete Error", ("Message ID:%s does not exist or the bot is not allowed." % (messageid)))
                

        await self.send_success_message("Message Delete", ("Message ID:%s deleted by %s from server %s broadcasted to : %s channels" % 
            (message.id, message.author.name, message.guild.name, messagesent)))

    async def on_guild_channel_create(self, channel):
        checkControlCategoryResponse = checkControlCategory(channel.category_id)
        if checkControlCategoryResponse == False:
            return

        channelsmirrored = 0
        createdchannels = []
        controlUrl = "https://admin.mocean.info/api/bot/channels/control"
        controlJson = {
            "category": channel.category_id,
            "channel": channel.id,
            "name": channel.name
        }
        createControlChannel = requests.post(controlUrl, data=controlJson)

        if checkControlCategoryResponse["type"] != "1":
            return

        for categoryLn in checkControlCategoryResponse["synced_categories"]:
            category = categoryLn["categoryid"]
            selectedcat = client.get_channel(int(category))
            if selectedcat is None:
                logger.error("Category ID:%s does not exist or the bot is not allowed.", category)
                await self.send_error_message("Channel Update Error", ("Category ID:%s does not exist or the bot is not allowed." % (category)))
            else:
                createdchannel = await selectedcat.create_text_channel(name=channel.name)
                if createdchannel is None:
                    return
                channelsmirrored += 1
                createUrl = "https://admin.mocean.info/api/bot/channels/client"
                jsonData = {
                    
                    "plan": categoryLn["plan"],
                    "category": category,
                    "control_channel": channel.id,
                    "channel": createdchannel.id
                }
                createClientChannel = requests.post(createUrl, data=jsonData)
                createdchannels.append(createdchannel.id)
            if channelsmirrored == 0:
                return


        logger.info("Channel ID:%s / %s created %s channels", channel.id, channel.name, channelsmirrored)
        await self.send_success_message("Channel Created", ("Channel ID:%s created in %s was broadcasted to : %s servers" % 
            (channel.id, channel.guild.name, channelsmirrored)))





    async def on_guild_channel_update(self, before, after):
        
        if(type(before) is discord.channel.TextChannel):

            checkChannelResponse = checkChannel(before.id)
            if checkChannelResponse == False:
                return
            

            channelsupdate = 0
            controlUrl = "https://admin.mocean.info/api/bot/channels/control"
            controlJson = {
                "channel": before.id,
                "name": after.name
            }
            createControlChannel = requests.put(controlUrl, data=controlJson)

            
            if checkChannelResponse["channel_type"] != "1":
                return

            for response_data in checkChannelResponse["channel_data"]:
                if response_data != before.id:
                    synced_channel_id = response_data["channelId"]
                    channel = client.get_channel(int(synced_channel_id))
                    if channel is None:
                        logger.error("Sync Channel ID:%s does not exist or the bot is not allowed.", synced_channel_id)
                        await self.send_error_message("Channel Update Error", ("Sync Channel ID:%s does not exist or the bot is not allowed." % (synced_channel_id)))
                    else:
                        if(before.name != after.name):
                            await channel.edit(name=after.name, topic=after.topic)

                            channelsupdate += 1
            await self.send_success_message("Channel Update", ("Channel ID:%s updated in %s was broadcasted to : %s servers" % 
                (channel.id, channel.guild.name, channelsupdate)))
                            
                            # elif(before.position != after.position):
                            #     if(channel.category_id in config["client_categories"][str(before.category.id)]["synced_categories"]):
                            #         # if(after.position == 0):
                            #         #     channel.move(beginning=True)
                            #         try:
                            #             x = await channel.edit(position=after.position)
                            #             print("%s - %s - %s - %s - %s" % (channel.category.name, channel.id, channel.name, channel.position, x))
                            #         except Exception as e:
                            #             print(e)
        # elif(type(before) is discord.channel.CategoryChannel):
        #     print("oks")
    
    async def on_guild_channel_delete(self, channel):
        
        if(type(channel) is discord.channel.TextChannel):
            
            checkChannelResponse = checkChannel(channel.id)
            if checkChannelResponse == False:
                return
                
            channelsmirrored = 0
            controlUrl = "https://admin.mocean.info/api/bot/channels/control"
            controlJson = {
                "channel": channel.id
            }
            deleteControlChannel = requests.delete(controlUrl, data=controlJson)

            
            if checkChannelResponse["channel_type"] != "1":
                return

            for response_data in checkChannelResponse["channel_data"]:
                if response_data != channel.id:
                    synced_channel_id = response_data["channelId"]
                    channelfound = client.get_channel(int(synced_channel_id))
                    if channelfound is None:
                        logger.error("Sync Channel ID:%s does not exist or the bot is not allowed.", synced_channel_id)
                        await self.send_error_message("Channel Delete Error", ("Sync Channel ID:%s does not exist or the bot is not allowed." % (synced_channel_id)))
                    else:
                        deletedchannel = await channelfound.delete()
                        channelsmirrored += 1

            logger.info("Channel ID:%s / %s deleted %s channels", channel.id, channel.name, channelsmirrored)
            await self.send_success_message("Channel Delete", ("Channel ID:%s deleted in %s was broadcasted to : %s servers" % 
        (       channel.id, channel.guild.name, channelsmirrored)))

    async def send_success_message(self, title, message):
        channel = client.get_channel(config["success_channel"])

        embed = discord.Embed(title=title, colour=0xacff91, description=message)
        await channel.send(embed=embed)
            
    async def send_error_message(self, title, message):
        channel = client.get_channel(config["error_channel"])

        embed = discord.Embed(title=title, colour=0xf27280, description=message)
        await channel.send(embed=embed)
            



intents = discord.Intents.default()
intents.message_content = True

client = MyClient(intents=intents)
client.run(config["token"])
