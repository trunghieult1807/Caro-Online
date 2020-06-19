from django.conf.urls import url
from . import views

urlpatterns = [
	url('home', views.index, name='index'),
	url('news', views.newsPage, name='news'),
	url('play', views.playPage, name='play'),
]