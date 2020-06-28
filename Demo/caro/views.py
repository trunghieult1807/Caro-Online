# caro/views.py

from django.http import HttpResponse
from django.shortcuts import render
from . import caro

# Create your views here.

# Create caro game
caro = caro.Caro()

# Access room
def room(request, room_name):
	return render(request, 'caro/index.html', {
			'room_name': room_name 
	})