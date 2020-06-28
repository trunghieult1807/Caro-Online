from django.shortcuts import render
from django.http import HttpResponse
# Create your views here.
def index(request):
	return render(request, 'pages/home.html')

def newsPage(request):
	return render(request, 'pages/news.html')

def playPage(request):
	return render(request, 'pages/play.html')
