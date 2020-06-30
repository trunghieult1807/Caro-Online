# caro/views.py

from django.http import HttpResponse
from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from django.views.generic import TemplateView
import json

# Create your views here.

# Main page
def caro_room(request, room_id):
    return render(request, "caro/room.html", {
        'room_id': room_id
    })

# class RoomView(TemplateView):
#     template_name = 'caro/room.html'

#     @login_required
#     def dispatch(self, request, *args, **kwargs):
#         return super(RoomView, self).dispatch(request, *args, **kwargs)

#     def get_context_data(self, **kwargs):
#         context = super(RoomView, self).get_context_data(**kwargs)

#         # Create a list of games that contains just the id (for the link) and the creator
#         available_games = [{'creator': game.creator.username, 'room_id': game.room_id} for game in Game.get_available_games()]

#         # For the player's games, return a list of games with the opponent and id
#         player_games = Game.get_games_for_player(self.request.user)

#         return context
