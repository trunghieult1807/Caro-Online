from django.contrib.auth.models import User
from django.db import models
import json
from datetime import datetime

# Create your models here.

# Game model----------------------------------------------------------------------------
class Game(models.Model):
    """
    Represents a Caro game for two players.
    """

    creator = models.ForeignKey(User, related_name='creator', on_delete=models.CASCADE)
    opponent = models.ForeignKey(User, related_name='opponent',
                                null=True, blank=True, on_delete=models.CASCADE)
    winner = models.ForeignKey(User, related_name='winner',
                                null=True, blank=True, on_delete=models.CASCADE)
    rows = models.IntegerField(default=16)
    cols = models.IntegerField(default=16)
    current_turn = models.ForeignKey(User, related_name='current_turn', on_delete=models.CASCADE)

    # Dates
    completed = models.DateTimeField(null=True, blank=True)
    created = models.DateTimeField(auto_now_add=True)
    modified = models.DateTimeField(auto_now=True)

    def __str__(self):
        return f'Game #{self.pk}'

    @staticmethod
    def get_available_games():
        return Game.objects.filter(opponent=None, completed=None)

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
            pass

    @staticmethod
    def create_new(user):
        """
        Create a new game and game cells
        :param user: the user that created the game
        :return: a new game object
        """
        # Create new game with user as creator
        new_game = Game(creator=user, current_turn=user)
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
        new_game.add_log(f'Game created by {new_game.creator.username}')
        return new_game

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

    def get_game_cell(row, col):
        """
        Get a cell of the board by its row and col index
        """
        try:
            return GameCell.objects.get(game=self, cols=col, rows=row)
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

    def send_game_update(self):
        """
        Send updated game information and cells to the game's channel group
        """
        # Imported here to avoid circular import
        from serializers import GameCellSerializer, GameLogSerializer, GameSerializer

        cells = self.get_all_game_cells()
        cell_serializer = GameCellSerializer(cells, many=True)

        # Get game log
        log = self.get_game_log()
        log_serializer = GameLogSerializer(log, many=True)

        game_serializer = GameSerializer(self)

        message = {
            'game': game_serializer.data,
            'log': log_serializer.data,
            'cells': cell_serializer.data
        }

        game_group = 'game-{0}'.format(self.id)
        Group(game_group).send({'text': json.dumps(message)})

    def next_player_turn(self):
        """
        Set the next player's turn
        """
        self.current_turn = self.creator if self.current_turn != self.creator else self.opponent
        self.save()

    def mark_complete(self, winner):
        """
        Set a game to completed status and record the winner
        """
        self.winner = winner
        self.completed = datetime.now()
        self.save()

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
            return player

        ### Diagonal 2
        isBounded = False
        isBoundedOneSide = False
        diagonal2 = 0

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
                if cell.status == 'EMPTY':
                    print("| ", end="")
                else:
                    print(f"|{cell.status}", end="")
            print("|")
        print("--" * self.cols + "-")

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

    # Dates
    created = models.DateTimeField(auto_now_add=True)
    modified = models.DateTimeField(auto_now=True)

    def __str__(self):
        return f'{self.game} - ({self.row}, {self.col})'

    @staticmethod
    def get_by_id(id):
        try:
            return Game.objects.get(pk=id)
        except GameCell.DoesNotExist:
            return None

    def make_move(self, user):
        """
        Make move on this cell for user
        """
        self.owner = user
        self.status = 'X' if user == self.game.creator else 'O'
        self.save(update_fields=['status', 'owner'])

        # Add log entry for move
        self.game.add_log(f'cell made at ({self.row}, {self.col}) by {self.owner.username}')

        # Set the current turn for the other player if game is not over
        # Check if find winner
        if self.game.check_win(cell=self):
            self.game.mark_complete(winner=user)
        # Switch player turn
        elif self.game.get_all_game_cells().filter(status='EMPTY'):
            self.game.next_player_turn()

        # Let the game know about the move and result
        self.game.send_game_update()


# GameLog model---------------------------------------------------------------------------------
class GameLog(models.Model):
    game = models.ForeignKey(Game, on_delete=models.CASCADE)
    text = models.CharField(max_length=300)
    player = models.ForeignKey(User, null=True, blank=True, on_delete=models.CASCADE)

    created = models.DateTimeField(auto_now_add=True)
    modified = models.DateTimeField(auto_now=True)

    def __str__(self):
        return f'Game #{self.game.id} Log'
