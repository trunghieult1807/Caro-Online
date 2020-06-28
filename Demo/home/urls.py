from django.urls import path
from . import views

urlpatterns = [
	path('homepage', views.index, name='index'),
	path('news', views.newsPage, name='news'),
	path('play', views.playPage, name='play'),
]