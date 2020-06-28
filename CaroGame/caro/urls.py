from django.urls import path
from .views import *

urlpatterns = [
    path('<str:room_id>/', RoomView.as_view()),
]
