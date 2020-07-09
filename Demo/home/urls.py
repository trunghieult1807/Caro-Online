from django.urls import path
from . import views

urlpatterns = [
	# path('', views.index, name='home'),
	path('', views.index, name='index'),
	path('news/', views.newsPage, name='news'),
	path('play/', views.playPage, name='play'),
	path('profile/', views.profilePage, name='profile'),
	path('editprofile/', views.editProfile, name='editprofile')
]
