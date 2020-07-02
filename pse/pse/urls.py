"""pse URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/3.0/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.contrib.auth import views as auth_views
from django.urls import path, include
from users import views as user_views
from users.forms import RegistrationForm, LoginForm
from django.contrib.auth.forms import UserCreationForm, AuthenticationForm

urlpatterns = [
    path('admin/', admin.site.urls),
    path('', user_views.login),
    path('register/', user_views.register_view, name='register'),
    
    path('login/', user_views.login_view, name='login'),
    path('logout/', auth_views.LogoutView.as_view(), name='logout'),
    path('home/', user_views.home, name='users-home'),
    path('profile/', user_views.profile, name='users-profile'),
    path('password-reset/', auth_views.PasswordResetView.as_view(template_name='users/password_reset.html'), name='password_reset'),
    # path('index/',user_views.index, name='index')
    # path('^activate/(?P<uidb64>[0-9A-Za-z_\-]+)/(?P<token>[0-9A-Za-z]{1,13}-[0-9A-Za-z]{1,20})/$', user_views.activate, name='activate'),
    # path('login/', auth_views.LoginView.as_view(form_class=LoginForm, template_name='users/index.html', redirect_authenticated_user=True), name='login'),
]
