"""
Caro game controller
"""

X = "X"
O = "O"
EMPTY = None

class Caro():
    def __init__(self, height=16, width=16):
        # Set initial height / width of the caro board
        self.height = height
        self.width = width

        # Default: X is first player
        self.turn = X

        # Set state to currently playing
        self.playing = True

        # Move history
        self.move_history = {}
        self.move_history[X] = []
        self.move_history[O] = []
        self.move_made = 0

        # Create a board with empty cells
        self.board = []
        for i in range(self.height):
            row = []
            for j in range(self.width):
                row.append(EMPTY)
            self.board.append(row)

    def get_board_size(self):
        """
        Return board size as a tuple (height, width)
        """
        return (self.height, self.width)

    def is_playing(self):
        """
        Return True if game is over, False otherwise
        """
        if self.move_made == self.height * self.width:
            # No more move to make
            self.playing = False

        return self.playing

    def player(self):
        """
        Return the player in turn
        """
        if not self.is_playing():
            print("Game is over")
            return None

        return self.turn


    def switch_turn(self):
        """
        Switch player's turn
        """
        self.turn = O if self.turn == X else X
        return None


    def make_move(self, row, col):
        """
        Make a new move in the board
        """
        if not self.is_playing():
            print("Game is over")
            return None

        if self.board[row][col] == EMPTY:
            player = self.player()
            self.board[row][col] = player

            # Update history
            self.move_history[player].append([row, col])

            # Switch player turn
            self.switch_turn()

            # Check winning condition
            winner = self.winner()
            if winner is not None:
                # Terminate the game
                self.playing = False
                print(f"{winner} is the winner!!!!!!!!!!")

            self.move_made += 1
            # Return the move made successfully
            return (row, col)

        # Cannot make new move
        return None


    def winner(self):
        """
        Check win condition
        Input the latest move
        """
        # Which player making the last move
        player = O if self.player() == X else X
        if len(self.move_history[player]) == 0:
            return None

        latest_move = self.move_history[player][-1]
        row = latest_move[0]
        col = latest_move[1]

        ########### Check horizontal win condition
        isBounded = False
        isBoundedOneSide = False
        horizontal = 0

        # Check left branch
        j = col
        while j >= 0:
            if self.board[row][j] == player:
                horizontal += 1
            elif self.board[row][j] == EMPTY:
                break
            else:
                isBoundedOneSide = True
                break
            j -= 1

        # Check right branch
        j = col + 1
        while j < self.width:
            if self.board[row][j] == player:
                horizontal += 1
            elif self.board[row][j] == EMPTY:
                break
            else:
                # Bound 2 side
                isBounded = True if isBoundedOneSide == True else False
                break
            j += 1

        if horizontal == 5 and not isBounded:
            return player

        ############ Check vertical win condition
        isBounded = False
        isBoundedOneSide = False
        vertical = 0

        # Check above branch
        i = row
        while i >= 0:
            if self.board[i][col] == player:
                vertical += 1
            elif self.board[i][col] == EMPTY:
                break
            else:
                isBoundedOneSide = True
                break
            i -= 1

        # Check below branch
        i = row + 1
        while i < self.height:
            if self.board[i][col] == player:
                vertical += 1
            elif self.board[i][col] == EMPTY:
                break
            else:
                # Bound 2 side
                isBounded = True if isBoundedOneSide == True else False
                break
            i += 1

        if vertical == 5 and not isBounded:
            return player

        ############ Check diagonal win condition
        ### Diagonal 1
        isBounded = False
        isBoundedOneSide = False
        diagonal1 = 0

        # Check upper branch of diagonal 1
        i = row
        j = col
        while i >= 0 and j >= 0:
            if self.board[i][j] == player:
                diagonal1 += 1
            elif self.board[i][j] == EMPTY:
                break
            else:
                isBoundedOneSide = True
                break
            i -= 1
            j -= 1

        # Check lower branch of diagonal 1
        i = row + 1
        j = col + 1
        while i < self.height and j < self.width:
            if self.board[i][j] == player:
                diagonal1 += 1
            elif self.board[i][j] == EMPTY:
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
        i = row
        j = col
        while i >= 0 and j < self.width:
            if self.board[i][j] == player:
                diagonal2 += 1
            elif self.board[i][j] == EMPTY:
                break
            else:
                isBoundedOneSide = True
                break
            i -= 1
            j += 1

        # Check lower branch of diagonal 2
        i = row + 1
        j = col - 1
        while i < self.height and j >= 0:
            if self.board[i][j] == player:
                diagonal2 += 1
            elif self.board[i][j] == EMPTY:
                break
            else:
                # Bound 2 side
                isBounded = True if isBoundedOneSide == True else False
                break
            i += 1
            j -= 1

        if diagonal2 == 5 and not isBounded:
            return player

        # No winner
        return None


    def print(self):
        """
        Print the caro board
        """
        for i in range(self.height):
            print("--" * self.width + "-")
            for j in range(self.width):
                if self.board[i][j]:
                    print(f"|{self.board[i][j]}", end="")
                else:
                    print("| ", end="")
            print("|")
        print("--" * self.width + "-")


    def print_history(self):
        """
        Print history of move made by players
        """
        print(f"{X} move:")
        for e in self.move_history[X]:
            print(f"({e[0]}, {e[1]})  ", end="")
        print()
        print(f"{O} move:")
        for e in self.move_history[O]:
            print(f"({e[0]}, {e[1]})  ", end="")
        print()
