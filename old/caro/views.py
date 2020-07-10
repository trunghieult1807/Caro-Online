# caro/views.py

from django.http import HttpResponse, HttpResponseRedirect, Http404
from django.shortcuts import render
from django.views.generic import TemplateView
from django.urls import reverse

from caro.models import User, Room
from django.contrib.auth import authenticate, login, get_user
from django.contrib.auth.decorators import login_required
from django.utils.decorators import method_decorator
import json

# Create your views here.

# Main page
@login_required
def caro_room(request, room_id):
    try:
        room = Room.get_by_id(room_id)
    except Room.DoesNotExist:
        raise Http404("Room does not exist")
    # Request user
    user = get_user(request)

    if room.enter_room(user) is None:
        return HttpResponseRedirect(reverse('play'))

    return render(request, "caro/room.html", {
        'room_id': room_id
    })
