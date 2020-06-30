from django.urls import path
from .views import *
from . import views

urlpatterns = [
    path('<str:room_id>/', views.caro_room, name='room'),
]
