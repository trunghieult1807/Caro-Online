# caro/routing.py

from django.urls import re_path
from . import consumers

websocket_urlpatterns = [
    re_path(r'ws/caro/(?P<room_id>\w+)/$', consumers.CaroConsumer),
]
