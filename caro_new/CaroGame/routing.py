# CaroGame/routing.py
from channels.auth import AuthMiddlewareStack
from channels.routing import ProtocolTypeRouter, URLRouter
from django.urls import path
import caro.routing

# Routes defined for channel calls
# This is similar to the Django urls, but specifically for Channels

application = ProtocolTypeRouter({
    # (http->django views is added by default)
    'websocket': AuthMiddlewareStack(
        URLRouter(
            caro.routing.websocket_urlpatterns,
        )
    ),
})
