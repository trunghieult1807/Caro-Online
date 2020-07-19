from django.shortcuts import render
from django.http import HttpResponse
from django.contrib.auth.decorators import login_required
from django.contrib.auth.models import User
from caro.models import Room
from django.views.generic.detail import DetailView
from users.models import Profile
from django.core.mail import send_mail
from django.conf import settings
from django.core.paginator import Paginator
from .models import Article

# Create your views here.
@login_required
def homePage(request):
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

	articles = Article.objects.all().order_by('date')

	paginator = Paginator(articles, 4)

	page = request.GET.get('page')

	articles = paginator.get_page(page)

	return render(request, 'pages/news.html', {'articles': articles})


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

	rooms = Room.objects.all()
	return render(request, 'pages/play.html', {
		'room_list': rooms
	})


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

@login_required
def article_detail(request, slug):
	if request.method == 'POST':
		sender = request.POST['sender']
		message = request.POST['sender-message']

		send_mail('Contact Form',
			'From: ' + sender + ', \n' + message,
			settings.EMAIL_HOST_USER,
			['zone2120vn@gmail.com'],
			fail_silently=False)
	article = Article.objects.get(slug=slug)
	return render(request, 'pages/article_detail.html', {'article': article})