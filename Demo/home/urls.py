from django.urls import path
from . import views

urlpatterns = [
	path('home/', views.index, name='index'),
	path('news/', views.newsPage, name='news'),
	path('play/', views.playPage, name='play'),
	path('profile/', views.profilePage, name='profile'),
]
