from django.shortcuts import render
from django.http import HttpResponse
from django.contrib.auth.decorators import login_required

# Create your views here.

@login_required
def index(request):
	return render(request, 'pages/home.html')

@login_required
def newsPage(request):
	return render(request, 'pages/news.html')

@login_required
def playPage(request):
	return render(request, 'pages/play.html')
