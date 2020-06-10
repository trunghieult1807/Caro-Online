from django.shortcuts import render, redirect
from django.contrib.auth.forms import UserCreationForm, AuthenticationForm
from django.contrib import messages
from .forms import RegistrationForm, LoginForm

def home(request):
    return render(request, 'users/home.html')

def register(request):
    if request.method == 'POST':
        form = RegistrationForm(request.POST)
        if form.is_valid():
            form.save()
            messages.success(request, f'Account created successfully!')
            return redirect('users-login')
    else:
        form = RegistrationForm()
    return render(request, 'users/register.html', {'form': form})

def login(request):
    if request.method == 'POST':
        form = AuthenticationForm(request.POST)
        if form.is_valid():
            messages.success(request, f'Login successfully!')
            return render(request, 'users/home.html')
    else:
        form = AuthenticationForm()
    return render(request, 'users/login.html', {'form': form})