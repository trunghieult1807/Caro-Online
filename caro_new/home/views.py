from django.shortcuts import render
from django.http import HttpResponse
from django.contrib.auth.decorators import login_required
from django.contrib.auth.models import User
from caro.models import Room
from django.views.generic.detail import DetailView
from users.models import Profile

# Create your views here.
@login_required
def homePage(request):
	# lists = Profile.objects.values('rank')
	lists = list(Profile.objects.values_list('user', 'rank'))

	for i in range(len(lists)):
		lists[i] = list(lists[i])
		user = User.objects.get(pk=lists[i][0])
		lists[i][0] = user.username

	lists = sorted(lists,key=lambda l:l[1], reverse=True)

	return render(request, 'pages/home.html', {'lists': lists})

@login_required
def newsPage(request):
	return render(request, 'pages/news.html')

@login_required
def playPage(request):
	rooms = Room.objects.all()
	return render(request, 'pages/play.html', {
		'room_list': rooms
	})

@login_required
def profilePage(request):
	return render(request, 'pages/profile.html')
