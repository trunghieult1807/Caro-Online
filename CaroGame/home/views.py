from django.shortcuts import render
from django.http import HttpResponse
from django.contrib.auth.decorators import login_required
from django.contrib.auth.models import User
from django.views.generic.detail import DetailView
from users.models import Profile
from django.core.mail import send_mail
from django.conf import settings

# Create your views here.
@login_required
def index(request):
	if request.method == 'POST':
		sender = request.POST['sender']
		message = request.POST['sender-message']

		send_mail('Contact Form',
			'From: ' + sender + ', \n' + message,
			settings.EMAIL_HOST_USER,
			['zone2120vn@gmail.com'],
			fail_silently=False)
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
	if request.method == 'POST':
		sender = request.POST['sender']
		message = request.POST['sender-message']

		send_mail('Contact Form',
			'From: ' + sender + ', \n' + message,
			settings.EMAIL_HOST_USER,
			['zone2120vn@gmail.com'],
			fail_silently=False)
	return render(request, 'pages/news.html')

@login_required
def playPage(request):
	if request.method == 'POST':
		sender = request.POST['sender']
		message = request.POST['sender-message']

		send_mail('Contact Form',
			'From: ' + sender + ', \n' + message,
			settings.EMAIL_HOST_USER,
			['zone2120vn@gmail.com'],
			fail_silently=False)
	return render(request, 'pages/play.html')

@login_required
def profilePage(request):
	if request.method == 'POST':
		sender = request.POST['sender']
		message = request.POST['sender-message']

		send_mail('Contact Form',
			'From: ' + sender + ', \n' + message,
			settings.EMAIL_HOST_USER,
			['zone2120vn@gmail.com'],
			fail_silently=False)
	return render(request, 'pages/profile.html')
	
# @login_required
# def contact(request):
# 	if request.method == 'POST':
# 		sender = request.POST['sender']
# 		message = request.POST['sender-message']
		
# 		send_mail('Contact Form',
# 			'From: ' + sender + ', \n' + message,
# 			settings.EMAIL_HOST_USER,
# 			['zone2120vn@gmail.com'],
# 			fail_silently=False)
# 	return render(request, '')