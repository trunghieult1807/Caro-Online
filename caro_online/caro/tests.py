from django.test import TestCase
from django.contrib.auth.models import User
from .models import *
import time

# Create your tests here.
class GameTestCase(TestCase):
    def setUp(self):
        # Create players
        player1 = User.objects.create_user(username='caitlyn', password='1')
        player2 = User.objects.create_user(username='shen', password='1')
        player3 = User.objects.create_user(username='thanh', password='1')

        # Create blank room
        room1 = Room.objects.create(pk=1)
        room2 = Room.objects.create(pk=2)
        room2.enter_room(player1)
        room2.enter_room(player2)

        # Create game
        game1 = Game.create_new()
        game2 = Game.create_new()
        game3 = Game.create_new()

    def test_get_room_by_id(self):
        room = Room.get_by_id(1)
        self.assertNotEqual(room, None)

    def test_enter_room(self):
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        room.enter_room(user1)
        self.assertEqual(room.is_available(), True)

        user2 = User.objects.get(pk=2)
        room.enter_room(user2)
        self.assertEqual(room.is_available(), False)

    def test_get_available_game(self):
        game = Game.get_by_id(1)
        self.assertEqual(Game.get_available_game(), game)

    def test_create_game_not_two_player(self):
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        room.enter_room(user1)
        room.user_ready(user1)

        game = room.create_game()
        self.assertEqual(game, None)

    def test_create_game_two_player(self):
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        room.enter_room(user1)
        user2 = User.objects.get(pk=2)
        room.enter_room(user2)

        room.user_ready(user1)
        room.user_ready(user2)
        new_game = room.create_game()
        game = Game.get_by_id(1)
        self.assertEqual(new_game, game)

    def test_create_game_two_player_unready(self):
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        room.enter_room(user1)
        user2 = User.objects.get(pk=2)
        room.enter_room(user2)

        room.user_ready(user1)
        room.user_ready(user2)
        room.user_unready(user1)
        new_game = room.create_game()
        self.assertEqual(new_game, None)

    def test_leave_room(self):
        # Setup
        room = Room.get_by_id(2)
        user1 = User.objects.get(pk=1)
        user2 = User.objects.get(pk=2)

        # Test
        room.leave_room(user1)
        self.assertEqual(room.user1, None)
        self.assertEqual(room.user2, user2)

    def test_leave_room_and_create_game(self):
        # Setup
        room = Room.get_by_id(2)
        user1 = User.objects.get(pk=1)
        user2 = User.objects.get(pk=2)

        # Test
        room.leave_room(user1)
        game = room.create_game()
        self.assertEqual(game, None)
        self.assertEqual(room.user1, None)
        self.assertEqual(room.user2, user2)

    def test_get_room_by_game(self):
        # Set up
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        user2 = User.objects.get(pk=2)
        room.enter_room(user1)
        room.enter_room(user2)
        room.user_ready(user1)
        room.user_ready(user2)
        new_game = room.create_game()
        # Test
        game = Game.get_by_id(1)
        room_get = Room.get_by_game(game=game)
        self.assertEqual(room_get, room)

    def test_room_delete_game(self):
        # Set up
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        user2 = User.objects.get(pk=2)
        room.enter_room(user1)
        room.enter_room(user2)
        room.user_ready(user1)
        room.user_ready(user2)
        new_game = room.create_game()
        # Test
        room.delete_game()
        self.assertEqual(room.game, None)

    def test_game_is_not_over(self):
        # Set up
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        user2 = User.objects.get(pk=2)
        room.enter_room(user1)
        room.enter_room(user2)
        room.user_ready(user1)
        room.user_ready(user2)
        new_game = room.create_game()
        # Test
        game = Game.get_by_id(1)
        self.assertEqual(game.is_over(), False)

    def test_game_is_over(self):
        # Set up
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        user2 = User.objects.get(pk=2)
        room.enter_room(user1)
        room.enter_room(user2)
        room.user_ready(user1)
        room.user_ready(user2)
        new_game = room.create_game()

        # Test
        game = Game.get_by_id(1)
        game.mark_complete(user2)
        self.assertEqual(game.winner, user2)
        self.assertEqual(game.is_over(), True)

    def test_count_user(self):
        # Set up
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        user2 = User.objects.get(pk=2)
        # Test
        self.assertEqual(room.count_user(), 0)
        room.enter_room(user1)
        self.assertEqual(room.count_user(), 1)
        room.enter_room(user2)
        self.assertEqual(room.count_user(), 2)

    def test_game_flow(self):
        # Set up
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        user2 = User.objects.get(pk=2)
        # Test
        self.assertEqual(room.enter_room(user1), True)
        self.assertEqual(room.enter_room(user2), True)
        room.user_ready(user1)
        room.user_ready(user2)
        new_game = room.create_game()

        game = Game.get_by_id(1)

        # print(game.current_turn)
        self.assertEqual(game.current_turn, user1)

        cell1 = game.get_game_cell(5, 5)
        cell1.make_move()

        self.assertEqual(cell1.game, game)
        # print(cell1.game.current_turn)
        self.assertEqual(cell1.game.current_turn, user2)
        # self.assertEqual(game.current_turn, user2)

    def test_get_current_game(self):
        # Set up
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        user2 = User.objects.get(pk=2)
        # Test
        room.enter_room(user1)
        room.enter_room(user2)
        room.user_ready(user1)
        room.user_ready(user2)
        game = room.create_game()
        self.assertEqual(room.get_current_game(), game)

    def test_number_of_win_game(self):
        # Set up
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        user2 = User.objects.get(pk=2)
        room.enter_room(user1)
        room.enter_room(user2)
        room.user_ready(user1)
        room.user_ready(user2)
        new_game = room.create_game()

        # Test
        new_game.mark_complete(user1)
        self.assertEqual(user1.profile.wins, 1)
        self.assertEqual(user1.profile.loses, 0)
        self.assertEqual(user1.profile.rank, 10)

        self.assertEqual(user2.profile.wins, 0)
        self.assertEqual(user2.profile.loses, 1)
        self.assertEqual(user2.profile.rank, 0)

    def test_swap_two_users(self):
        # Set up
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        user2 = User.objects.get(pk=2)
        room.enter_room(user1)
        room.enter_room(user2)

        # Test
        room.swap_user()
        self.assertEqual(room.count_user(), 2)
        self.assertEqual(room.user1, user2)
        self.assertEqual(room.user2, user1)

    def test_swap_one_user(self):
        # Set up
        room = Room.get_by_id(1)
        user1 = User.objects.get(pk=1)
        user2 = User.objects.get(pk=2)
        room.enter_room(user1)
        room.enter_room(user2)
        room.leave_room(user1)

        # Test
        room.swap_user()
        self.assertEqual(room.count_user(), 1)
        self.assertEqual(room.user1, user2)
        self.assertEqual(room.user2, None)
