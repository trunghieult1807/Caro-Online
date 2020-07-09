from django.urls import path
from . import views
from users import views as user_views

urlpatterns = [
	# path('', views.index, name='home'),
	path('', views.index, name='index'),
	path('news/', views.newsPage, name='news'),
	path('play/', views.playPage, name='play'),
	path('profile/', views.profilePage, name='profile'),
	path('update_profile/', user_views.update_profile, name='update_profile')
]
