from django.urls import path
from . import views

urlpatterns = [
    path('<int:room_id>/', views.caro_room, name='room'),
]
