# caro/consumers.py
import re
import logging
import json
from channels.generic.websocket import JsonWebsocketConsumer
from asgiref.sync import async_to_sync
from .models import Game, GameCell, Room
from django.contrib.auth.models import User

logger = logging.getLogger(__name__)

class CaroConsumer(JsonWebsocketConsumer):
    # Set to True to automatically port users from HTTP cookies
    # (you don't need channel_session_user, this implies it)
    http_user = True

    def connect(self):
        """
        Perform things on connection start
        """
        self.room_id = self.scope['url_route']['kwargs']['room_id']
        self.room = f'room_{self.room_id}'

        # Join room group
        async_to_sync(self.channel_layer.group_add)(
            self.room,
            self.channel_name
        )
        self.accept()
        logger.info(f"Added {self.channel_name} channel to workflow")

    def disconnect(self, close_code):
        """
        Perform things on connection close
        """
        # Leave room channel
        async_to_sync(self.channel_layer.group_discard)(
            self.room,
            self.channel_name
        )
        logger.info(f"Removed {self.channel_name} channel from workflow")

    def receive(self, text_data):
        """
        Receive message from WebSocket
        """
        http_user = True

        text_data_json = json.loads(text_data)
        action = text_data_json['action']

        if action == 'chat':
            message = text_data_json['message']
            # Send message to room group
            async_to_sync(self.channel_layer.group_send)(
                self.room,
                {
                    'type': 'chat.message',
                    'action': 'chat',
                    'message': message,
                    'username': text_data_json['username']
                }
            )

        if action == 'create_game':
            username = text_data_json['user']
            room_id = int(text_data_json['room_id'])
            room = Room.get_by_id(room_id)
            room.increase_count_ready()

            game = room.create_game()
            if game is not None:
                # game.send_game_update()
                print("Create new game")
            else:
                print("Faileddddd to create game")
                return None

        if action == 'make_move':
            # Extract json message
            username = text_data_json['user']
            room_id = int(text_data_json['room_id'])
            row = int(text_data_json['row'])
            col = int(text_data_json['col'])
            print(f"Move({row}, {col})")
            room = Room.get_by_id(room_id)
            game = room.get_current_game()
            print(game)
            cell = game.get_game_cell(row, col)
            cell.make_move()

        if action == 'leave_room':
            username = text_data_json['user']
            room_id = int(text_data_json['room_id'])

            # Find room by id
            room = Room.get_by_id(room_id)
            if room.user1 is not None and username == room.user1.username:
                room.leave_room(user=room.user1)
                # Send socket message to leave room
                content = {
                    'action': 'leave_room'
                }
                self.send_json(content)
                logger.info(f"Got message {content} at {self.channel_name}")
                # End the game if currently being played
                if room.game is not None and not room.game.is_over():
                    room.game.mark_complete(winner=room.user2)
                    room.game.send_game_update()

            elif room.user2 is not None and username == room.user2.username:
                room.leave_room(user=room.user2)
                # Send socket message to leave room
                content = {
                    'action': 'leave_room'
                }
                self.send_json(content)
                logger.info(f"Got message {content} at {self.channel_name}")
                # End the game if currently being played
                if room.game is not None and not room.game.is_over():
                    room.game.mark_complete(winner=room.user1)
                    room.game.send_game_update()

    def send_game_update(self, event):
        # Send message to WebSocket
        self.send_json(event)
        logger.info(f"Got message {event} at {self.channel_name}")

    def chat_message(self, event):
        # Receive message from room group
        self.send_json(event)
        logger.info(f"Got message {event} at {self.channel_name}")
