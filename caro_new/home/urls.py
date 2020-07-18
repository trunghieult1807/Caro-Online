from django.urls import path
from . import views
from django.conf.urls.static import static
from django.conf import settings

urlpatterns = [
	path('home/', views.homePage, name='index'),
	path('news/', views.newsPage, name='news'),
	path('news/<slug>/', views.article_detail, name='article_detail'),
	path('', views.playPage, name='play'),
	path('profile/', views.profilePage, name='profile'),
]

# urlpatterns += static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)
