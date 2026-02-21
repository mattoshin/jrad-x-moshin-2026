import os
from functools import wraps
from quart import Quart, request, abort
from discord.ext.ipc import Client
import asyncio
import json

app = Quart(__name__)
IPC = Client(
    host="127.0.0.1",
    port=2300,
    secret_key=os.getenv('BOT_IPC_SECRET', 'change-me-in-production')
) # These params must be the same as the ones in the client

API_KEY = os.getenv('BOT_API_KEY', '')

def require_api_key(f):
    """Middleware to require API key authentication on bot API endpoints."""
    @wraps(f)
    async def decorated_function(*args, **kwargs):
        if API_KEY:
            auth_header = request.headers.get('Authorization', '')
            if auth_header != f'Bearer {API_KEY}':
                return {"error": "Unauthorized"}, 401
        return await f(*args, **kwargs)
    return decorated_function

@app.route('/server')
@require_api_key
async def grab_server():
    guildid = (await request.get_json())["guild_id"]
    guild = await app.ipc.request("get_server", guild_id=guildid)
    if(guild["guild"] != None):
        return guild
    else:
        return {"error":"Server Not Found"}, 404

@app.route('/create_monitor')
@require_api_key
async def create_monitor():
    requestdata = (await request.get_json())
    if("monitor" not in requestdata):
        return {"error":"Missing Monitor Paramater"}, 400
    monitorid=requestdata["monitor"]
    guild = await app.ipc.request("create_monitor", monitor_id=monitorid)
    if(guild["guild"] != None):
        return guild
    else:
        return {"error":guild}, 404


@app.route('/send_announcement')
@require_api_key
async def send_announcement():
    requestdata = (await request.get_json())
    if("guild_id" not in requestdata):
        return {"error":"Missing Monitor Paramater"}, 400
    guild_id=requestdata["guild_id"]
    announcement=requestdata["message"]
    guild = await app.ipc.request("send_announcement", guild_id=guild_id, announcement=announcement)
    if(guild["guild"] != None):
        return guild
    else:
        return {"error":guild}, 404


@app.route('/send_announcements')
@require_api_key
async def send_announcements():
    requestdata = (await request.get_json())
    if("product" not in requestdata):
        return {"error":"Missing Product Paramater"}, 400
    product=requestdata["product"]
    announcement=requestdata["message"]
    guild = await app.ipc.request("send_announcements", product=product, announcement=announcement)
    if(guild["guild"] != None):
        return guild
    else:
        return {"error":guild}, 404

@app.route('/get_monitor')
@require_api_key
async def get_monitor():
    requestdata = (await request.get_json())
    if("monitor" not in requestdata):
        return {"error":"Missing Monitor Paramater"}, 400
    monitorid=requestdata["monitor"]
    guild = await app.ipc.request("get_monitor", monitor_id=monitorid)
    if(guild["guild"] != None):
        return guild
    else:
        return {"error":guild}, 404

if __name__ == '__main__':
    loop = asyncio.new_event_loop()
    asyncio.set_event_loop(loop)

    try:
        app.ipc = loop.run_until_complete(IPC.start(loop=loop)) # `Client.start()` returns new Client instance or None if it fails to start
        app.run(loop=loop)
    finally:
        loop.run_until_complete(app.ipc.close()) # Closes the session, doesn't close the loop
        loop.close()
