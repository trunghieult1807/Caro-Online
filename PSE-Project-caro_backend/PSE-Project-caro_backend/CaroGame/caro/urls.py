from django.urls import path
from .views import *

urlpatterns = [
    # path('<str:room_id>/', RoomView.as_view(), name='room'),
    path('<str:room_id>/', caro_room, name='room'),
]
