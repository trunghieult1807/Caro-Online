from caro.models import *
from django.contrib.auth.models import User

number_of_games = 10
number_of_rooms = 10

def createGames(n=number_of_games):
    for i in range(n):
        game = Game.create_new()
        game.save()

def createRooms(n=number_of_rooms):
    for i in range(n):
        room = Room(user1=None, user2=None, game=None)
        room.save()

def initialize():
    print(f"Create {number_of_games} ghost games...")
    createGames()
    print("Finish.")

    print("Create 10 ghost rooms...")
    createRooms()
    print("Finish.")

def clear():
    Room.objects.all().update(user1=None, user2=None, game=None)
    Game.objects.all().update(creator=None, opponent=None, winner=None,
                              current_turn=None, completed=False)
    GameCell.objects.all().update(owner=None, status='EMPTY')

def deleteGameLog():
    GameLog.objects.all().delete()

def delete():
    Room.objects.all().delete()
    Game.objects.all().delete()
    GameCell.objects.all().delete()
    GameLog.objects.all().delete()
