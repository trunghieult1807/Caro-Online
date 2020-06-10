from django.urls import path, re_path
from . import views
import json
app_name = 'chat'

urlpatterns = [
    path('',views.index, name='index'),
    path('<str:room_name>/', views.room, name='room'),
]