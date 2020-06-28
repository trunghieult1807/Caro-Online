# caro/consumers.py
import re
import logging
import json
from channels.generic.websocket import AsyncJsonWebsocketConsumer
from .models import Game, GameCell

logger = logging.getLogger(__name__)

class CaroConsumer(AsyncJsonWebsocketConsumer):
    # Set to True to automatically port users from HTTP cookies
    # (you don't need channel_session_user, this implies it)
    http_user = True

    async def connect(self):
        """
        Perform things on connection start
        """
        await self.accept()

        self.room_id = self.scope['url_route']['kwargs']['room_id']
        self.room = f'room_{self.room_id}'

        # Join room group
        await self.channel_layer.group_add(self.room, self.channel_name)
        logger.info(f"Added {self.channel_name} channel to workflow")


    async def disconnect(self, close_code):
        """
        Perform things on connection close
        """
        # Leave room channel
        await self.channel_layer.group_discard(self.room, self.channel_name)
        logger.info(f"Removed {self.channel_name} channel from workflow")

    async def receive(self, text_data):
        """
        Receive message from WebSocket
        """
        http_user = True
        
        text_data_json = json.loads(text_data)
        content = text_data_json['content']
        row = content['row']
        col = content['col']
        message = f"Move ({row}, {col})"

        # Send message to room
        await self.channel_layer.group_send(
            self.room, {
                'type': 'send.game.update',
                'content': message
            }
        )

    async def make_move(self, event):
        await self.send_json(event)
        logger.info(f"Got message {event} at {self.channel_name}")

    async def send_game_update(self, event):
        # Send message to WebSocket
        await self.send_json(event)
        logger.info(f"Got message {event} at {self.channel_name}")
