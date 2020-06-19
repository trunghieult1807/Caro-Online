from django.test import TestCase
from django.contrib.auth.models import User
from .models import *

# Create your tests here.
class GameTestCase(TestCase):
    def setUp(self):
        # Create players
        player1 = User.objects.create_user(username='caitlyn', password='1')
        player2 = User.objects.create_user(username='shen', password='1')
        game = Game.create_new(player1)

        available_game = Game.get_available_games().first()
        available_game.opponent = player2
        available_game.save()

        # Make some moves
        cell1 = GameCell.objects.get(game=game, status='EMPTY', row=3, col=5)
        cell2 = GameCell.objects.get(game=game, status='EMPTY', row=4, col=7)
        cell3 = GameCell.objects.get(game=game, status='EMPTY', row=3, col=1)
        cell4 = GameCell.objects.get(game=game, status='EMPTY', row=4, col=1)
        cell5 = GameCell.objects.get(game=game, status='EMPTY', row=5, col=1)
        cell6 = GameCell.objects.get(game=game, status='EMPTY', row=4, col=3)
        cell7 = GameCell.objects.get(game=game, status='EMPTY', row=3, col=4)

        cell1.make_move(game.current_turn)
        print(game.current_turn)
        cell2.make_move(game.current_turn)
        cell3.make_move(game.current_turn)
        cell4.make_move(game.current_turn)
        cell5.make_move(game.current_turn)
        cell6.make_move(game.current_turn)
        cell7.make_move(game.current_turn)


    def test_create_game(self):
        all_games = Game.objects.all()
        for game in all_games:
            print(game)
            print(f'{game.creator} vs {game.opponent}')
            game.print()

        self.assertEqual(all_games.count(), 1)

    def test_create_game_log(self):
        game = Game.objects.get(pk=1)
        for log in game.get_game_log():
            print(log.text)
