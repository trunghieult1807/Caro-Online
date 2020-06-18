# caro/routing.py

from django.urls import re_path

from . import consumers

websocket_urlpatterns = [
    re_path('caro/', consumers.CaroConsumer),
]
