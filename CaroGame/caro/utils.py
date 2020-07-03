from caro.models import *
from django.contrib.auth.models import User

def createRooms():
    for i in range(10):
        room = Room(user1=None, user2=None, game=None)
        room.save()

def clearSquares():
    user = User.objects.get(pk=2)
    GameSquare.objects.all().update(owner=None, status="Free")
    Game.objects.filter(pk=6).update(current_turn=user, completed=None)
    GameLog.objects.filter(game__id=6).delete()

def clearAll():
    Room.objects.all().update(user1=None, user2=None, game=None)
    Game.objects.all().delete()
    GameCell.objects.all().delete()
    GameLog.objects.all().delete()
