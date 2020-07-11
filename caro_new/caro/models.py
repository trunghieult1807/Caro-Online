from django.contrib.auth.models import User
from asgiref.sync import async_to_sync
from channels.layers import get_channel_layer
from django.db import models
import json

# Create your models here.
# Game model----------------------------------------------------------------------------
class Game(models.Model):
    """
    Represents a Caro game for two players.
    """
    creator = models.ForeignKey(User, related_name='creator',
                                null=True, blank=True, on_delete=models.CASCADE)
    opponent = models.ForeignKey(User, related_name='opponent',
                                null=True, blank=True, on_delete=models.CASCADE)
    winner = models.ForeignKey(User, related_name='winner',
                                null=True, blank=True, on_delete=models.CASCADE)
    rows = models.IntegerField(default=16)
    cols = models.IntegerField(default=16)
    current_turn = models.ForeignKey(User, related_name='current_turn',
                                null=True, blank=True, on_delete=models.CASCADE)
    completed = models.BooleanField(default=False)

    def __str__(self):
        return f'Game #{self.pk}: Winner is {self.winner}'

    def clear(self):
        """
        Reset original state
        """
        self.creator = None
        self.opponent = None
        self.winner = None
        self.current_turn = None
        self.completed = False
        self.save()

    @staticmethod
    def get_available_game():
        return Game.objects.filter(creator=None, opponent=None, completed=False).first()

    @staticmethod
    def created_count(user):
        return Game.objects.filter(creator=user).count()

    @staticmethod
    def get_games_for_player(user):
        from django.db.models import Q
        return Game.objects.filter(Q(opponent=user) | Q(creator=user))

    @staticmethod
    def get_by_id(id):
        try:
            return Game.objects.get(pk=id)
        except Game.DoesNotExist:
            # TODO: Handle this exception
            return None

    @staticmethod
    def create_new(creator=None, opponent=None):
        """
        Create a new game and game cells
        :param user: the user that created the game
        :return: a new game object
        """
        # Create new game with user as creator
        new_game = Game(creator=creator, opponent=opponent, current_turn=creator)
        new_game.save()

        # Initialize cells
        for row in range(new_game.rows):
            for col in range(new_game.cols):
                new_cell = GameCell(
                    game = new_game,
                    row = row,
                    col = col
                )
                new_cell.save()

        # Put first log into GameLog
        new_game.add_log(f'Game created by {new_game.creator}')
        return new_game

    def send_game_update(self):
        """
        Send to client when game is created
        """
        winner_name = self.winner.username if self.winner else None
        content = {
            'type': 'send.game.update',
            'action': 'game_update',
            'winner': winner_name,
            'current_turn': self.current_turn.username,
            'completed': self.completed
        }

        room = Room.get_by_game(game=self)
        if room is None:
            print("Game not in a room")
            return None
        room_name = f'room_{room.pk}'
        channel_layer = get_channel_layer()
        async_to_sync(channel_layer.group_send)(room_name, content)
        if self.is_over():
            room.delete_game()

    def is_over(self):
        return self.completed

    def add_log(self, text, user=None):
        """
        Add a text log associated with this game
        """
        entry = GameLog(game=self, text=text, player=user).save()
        return entry

    def get_all_game_cells(self):
        """
        Get all of the cells for this game
        """
        return GameCell.objects.filter(game=self)

    def get_game_cell(self, row, col):
        """
        Get a cell of the board by its row and col index
        """
        try:
            return GameCell.objects.get(game=self, row=row, col=col)
        except GameCell.DoesNotExist:
            return None

    def get_cell_by_coords(self, coords):
        """
        Retrieve the cell based on its 2D-coords (x, y) or (row, col)
        """
        try:
            cell = GameCell.objects.get(row=coords[0], col=coords[1], game=self)
            return cell
        except GameCell.DoesNotExist:
            return None

    def get_game_log(self):
        """
        Get the entire log of the game
        """
        return GameLog.objects.filter(game=self)

    def next_player_turn(self):
        """
        Set the next player's turn
        """
        if self.completed is not None:
            self.current_turn = self.creator if self.current_turn != self.creator else self.opponent
            self.save()

    def mark_complete(self, winner):
        """
        Set a game to completed status and record the winner
        """
        # print("Run mark_complete")
        # Game.objects.get(pk=self.pk).update(winner=winner, completed=True)
        self.winner = winner
        self.completed = True
        self.save(update_fields=['winner', 'completed'])
        if (winner == self.creator):
            self.creator.profile.add_win_match()
            self.opponent.profile.add_lose_match()
        else:
            self.opponent.profile.add_win_match()
            self.creator.profile.add_lose_match()

    def check_win(self, cell):
        """
        Check winning condition
        :param cell: The latest move which has just been made
        :return: True if win, else otherwise
        """
        ########### Check horizontal win condition
        isBounded = False
        isBoundedOneSide = False
        horizontal = 1

        # Check left branch
        j = cell.col - 1
        while j >= 0:
            near_cell = self.get_game_cell(cell.row, j)
            if near_cell.owner == cell.owner:
                horizontal += 1
            elif near_cell.status == 'EMPTY':
                break
            else:
                isBoundedOneSide = True
                break
            j -= 1

        # Check right branch
        j = cell.col + 1
        while j < self.cols:
            near_cell = self.get_game_cell(cell.row, j)
            if near_cell.owner == cell.owner:
                horizontal += 1
            elif near_cell.status == 'EMPTY':
                break
            else:
                # Bound 2 side
                isBounded = True if isBoundedOneSide == True else False
                break
            j += 1

        if horizontal == 5 and not isBounded:
            return True

        ############ Check vertical win condition
        isBounded = False
        isBoundedOneSide = False
        vertical = 1

        # Check above branch
        i = cell.row - 1
        while i >= 0:
            near_cell = self.get_game_cell(i, cell.col)
            if near_cell.owner == cell.owner:
                vertical += 1
            elif near_cell.status == 'EMPTY':
                break
            else:
                isBoundedOneSide = True
                break
            i -= 1

        # Check below branch
        i = cell.row + 1
        while i < self.rows:
            near_cell = self.get_game_cell(i, cell.col)
            if near_cell.owner == cell.owner:
                vertical += 1
            elif near_cell.status == 'EMPTY':
                break
            else:
                # Bound 2 side
                isBounded = True if isBoundedOneSide == True else False
                break
            i += 1

        if vertical == 5 and not isBounded:
            return True

        ############ Check diagonal win condition
        ### Diagonal 1
        isBounded = False
        isBoundedOneSide = False
        diagonal1 = 1

        # Check upper branch of diagonal 1
        i = cell.row - 1
        j = cell.col - 1
        while i >= 0 and j >= 0:
            near_cell = self.get_game_cell(i, j)
            if near_cell.owner == cell.owner:
                diagonal1 += 1
            elif near_cell.status == 'EMPTY':
                break
            else:
                isBoundedOneSide = True
                break
            i -= 1
            j -= 1

        # Check lower branch of diagonal 1
        i = cell.row + 1
        j = cell.col + 1
        while i < self.rows and j < self.cols:
            near_cell = self.get_game_cell(i, j)
            if near_cell.owner == cell.owner:
                diagonal1 += 1
            elif near_cell.status == 'EMPTY':
                break
            else:
                # Bound 2 side
                isBounded = True if isBoundedOneSide == True else False
                break
            i += 1
            j += 1

        if diagonal1 == 5 and not isBounded:
            return True

        ### Diagonal 2
        isBounded = False
        isBoundedOneSide = False
        diagonal2 = 1

        # Check upper branch of diagonal 2
        i = cell.row - 1
        j = cell.col + 1
        while i >= 0 and j < self.cols:
            near_cell = self.get_game_cell(i, j)
            if near_cell.owner == cell.owner:
                diagonal2 += 1
            elif near_cell.status == 'EMPTY':
                break
            else:
                isBoundedOneSide = True
                break
            i -= 1
            j += 1

        # Check lower branch of diagonal 2
        i = cell.row + 1
        j = cell.col - 1
        while i < self.rows and j >= 0:
            near_cell = self.get_game_cell(i, j)
            if near_cell.owner == cell.owner:
                diagonal2 += 1
            elif near_cell.status == 'EMPTY':
                break
            else:
                # Bound 2 side
                isBounded = True if isBoundedOneSide == True else False
                break
            i += 1
            j -= 1

        if diagonal2 == 5 and not isBounded:
            return True

        # No winner
        return False

    def print(self):
        """
        Print the caro board
        """
        for i in range(self.rows):
            print("--" * self.cols + "-")
            for j in range(self.cols):
                cell = self.get_game_cell(i, j)
                if cell is None:
                    print(f'({i} - {j}): failed')
                    return None
                if cell.status == 'EMPTY':
                    print("| ", end="")
                else:
                    print(f"|{cell.status}", end="")
            print("|")
        print("--" * self.cols + "-")
        print(f"Completed({self.completed}) - {self.winner}")

# Room model----------------------------------------------------------------------------
class Room(models.Model):
    user1 = models.ForeignKey(User, related_name='user1',
                                null=True, blank=True, on_delete=models.CASCADE)
    user2 = models.ForeignKey(User, related_name='user2',
                                null=True, blank=True, on_delete=models.CASCADE)
    game = models.ForeignKey(Game, related_name='game',
                             null=True, blank=True, on_delete=models.CASCADE)
    count_ready = models.IntegerField(default=0)
    def __str__(self):
        return f'Room {self.pk}: {self.user1} vs {self.user2}'

    def clear(self):
        """
        Reset original state
        """
        self.user1 = None
        self.user2 = None
        self.game = None
        self.save()

    def increase_count_ready(self):
        self.count_ready += 1
        self.save()

    @staticmethod
    def get_by_id(id):
        try:
            return Room.objects.get(pk=id)
        except Room.DoesNotExist:
            # TODO: Handle this exception
            print("Room not found by id")
            return None

    @staticmethod
    def get_by_game(game):
        try:
            return Room.objects.get(game=game)
        except Room.DoesNotExist:
            print("Room not found by game")
            return None

    def is_available(self):
        return self.user1 is None or self.user2 is None

    def count_user(self):
        count = 0
        if self.user1 is not None:
            count += 1
        if self.user2 is not None:
            count += 1
        return count

    def enter_room(self, user):
        """
        Update user in room, if room is full -> return None
        """
        if self.user1 is None and self.user2 != user:
            self.user1 = user
        elif self.user1 != user and self.user2 is None:
            self.user2 = user
        else:
            return None
        self.save()
        return True

    def leave_room(self, user):
        if self.user1 == user:
            self.user1 =  None
        elif self.user2 == user:
            self.user2 = None
        else:
            return None
        self.save()

    def create_game(self):
        if not self.is_available() and self.count_ready == 2:
            print("Run create_game")
            self.game = Game.get_available_game()
            self.game.creator = self.user1
            self.game.opponent = self.user2
            self.game.current_turn = self.game.creator
            self.game.save(update_fields=['creator', 'opponent', 'current_turn'])
            self.save(update_fields=['game'])
            # Send game update message about "game created" only after saved
            self.game.send_game_update()
        return self.game

    def delete_game(self):
        self.game = None
        self.count_ready = 0
        self.save(update_fields=['game', 'count_ready'])

    def get_current_game(self):
        return self.game


# GameCell model-------------------------------------------------------------------------------
class GameCell(models.Model):
    STATUS_TYPES = (
        ('EMPTY', 'EMPTY'),
        ('X', 'X'),
        ('O', 'O')
    )
    game = models.ForeignKey(Game, on_delete=models.CASCADE)
    owner = models.ForeignKey(User, null=True, blank=True, on_delete=models.CASCADE)
    status = models.CharField(choices=STATUS_TYPES, max_length=10, default='EMPTY')

    row = models.IntegerField()
    col = models.IntegerField()

    def __str__(self):
        return f'{self.game} - ({self.row}, {self.col})'

    def clear(self):
        """
        Reset original state
        """
        self.owner = None
        self.status = 'EMPTY'
        self.save()

    @staticmethod
    def get_by_id(id):
        try:
            return Game.objects.get(pk=id)
        except GameCell.DoesNotExist:
            return None

    def make_move(self):
        """
        Make move on this cell for user
        """
        self.owner = self.game.current_turn
        self.status = 'X' if self.owner == self.game.creator else 'O'
        ####
        #Random turn??
        ####
        self.save(update_fields=['status', 'owner'])

        # Add log entry for move
        self.game.add_log(f'cell made at ({self.row}, {self.col}) by {self.owner}')

        # Set the current turn for the other player if game is not over
        # Check if find winner
        if self.game.check_win(cell=self) or\
            self.game.get_all_game_cells().filter(status='EMPTY').count() == 0:
            print("Winnnnnnnn")
            self.game.mark_complete(winner=self.owner)

        # Switch player turn
        self.game.next_player_turn()

        # Let the game know about the move and result
        self.send_game_update()

    def send_game_update(self):
        """
        Send to client when made a new move
        """
        content = {
            'type': 'send.game.update',
            'action': 'make_move',
            'owner': self.owner.username,
            'status': self.status,
            'row': self.row,
            'col': self.col,
            'current_turn': self.game.current_turn.username,
            'completed': self.game.completed
        }

        room = Room.get_by_game(game=self.game)
        if room is None:
            print("Game not in a room aslkdfjsldf")
            return None
        room_name = f'room_{room.pk}'
        channel_layer = get_channel_layer()
        async_to_sync(channel_layer.group_send)(room_name, content)

        if self.game.is_over():
            room.delete_game()


# GameLog model---------------------------------------------------------------------------------
class GameLog(models.Model):
    game = models.ForeignKey(Game, on_delete=models.CASCADE)
    text = models.CharField(max_length=300)
    player = models.ForeignKey(User, null=True, blank=True, on_delete=models.CASCADE)

    def __str__(self):
        return f'Game #{self.game.id} Log'

    def clear(self):
        """
        Reset original state
        """
        self.text = ""
        self.player = None
        self.save()
