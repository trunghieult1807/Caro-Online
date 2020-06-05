const X = 1, O = 2, Empty = 0;

var currGame = new game(16, 16);
board.writeBoardTwoPlayer();

function game(noOfRow, noOfCol) {
	this.noOfRow = noOfRow, this.noOfCol = noOfCol;
	this.Turn = X;
	this.isGamming = true; //currGame.isGamming or Not.
	this.noOfPiece = 0; //number of Pieces on the table -> to check draw
	this.sq = new Array(); /* define an array storing XO position */
	for (var i = 0; i < this.noOfRow; i++) {
		this.sq[i] = new Array();
		for (var j = 0; j < this.noOfCol; j++) {
			this.sq[i][j]=0;
		}
	}


	//timer.setTimer(300, 300);

	//With AI
	this.xMove = function(i,j){
		currGame.sq[i][j] = X;
		board.sqUpdate(i, j);
		currGame.noOfPiece++;
		currGame.Turn = O;
		referee.checkWin()
		if (currGame.isGamming == false){
			return;
		}
		var bestMove = {row:0, col:0};
		AIthink(O, bestMove);
		currGame.sq[bestMove.row][bestMove.col] = O;
		board.sqUpdate(bestMove.row, bestMove.col);
		currGame.Turn = X;
		currGame.noOfPiece++;
		referee.checkWin()
	};

	//With player
	this.xMoveTwoPlayer = function(i,j){
		currGame.sq[i][j] = X;
		board.sqUpdate(i, j);
		currGame.noOfPiece++;
		currGame.Turn = O;
		referee.checkWin()
		if (currGame.isGamming == false){
			return;
		}
	};

	this.oMoveTwoPlayer = function(i,j){
		currGame.sq[i][j] = O;
		board.sqUpdate(i, j);
		currGame.noOfPiece++;
		currGame.Turn = X;
		referee.checkWin()
		if (currGame.isGamming == false){
			return;
		}
	};

}
