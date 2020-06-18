# caro/consumers.py
import json
from channels.generic.websocket import WebsocketConsumer

class CaroConsumer(WebsocketConsumer):
    def connect(self):
        self.accept()

    def disconnect(self, close_code):
        pass

    def receive(self, text_data):
        text_data_json = json.loads(text_data)
        print("Hello from server")

        self.send(text_data = json.dumps({
            'message': "Hello",
        }))
