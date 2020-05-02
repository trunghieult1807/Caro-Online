const X = 1, O = 2, Empty = 0;


var currGame = new game(16, 16);
board.writeBoard();


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
			// if(i<10)
			// this.sq[i][j]=2;
			//
			// else {
			// 	this.sq[i][j]=1;
			// }
		}
	}

	// this.sq[3][1] = X;
	// this.sq[3][2] = X;
	// this.sq[3][3] = X;
	// this.sq[3][4] = X;
	// this.sq[4][1] = X;
	// this.sq[5][1] = X;
	// this.sq[6][1] = X;
	// this.sq[6][2] = X;
	// this.sq[6][3] = X;
	// this.sq[6][4] = X;
	// this.sq[3][1] = X;
	// this.sq[3][7] = X;
	// this.sq[3][8] = X;
	// this.sq[4][6] = X;
	// this.sq[4][9] = X;
	// this.sq[5][6] = X;//
	// this.sq[5][7] = X;
	// this.sq[5][8] = X;
	// this.sq[5][9] = X;
	// this.sq[6][6] = X;
	// this.sq[6][9] = X;
	// this.sq[3][11] = X;
	// this.sq[3][12] = X;
	// this.sq[3][13] = X;
	// this.sq[3][14] = X;
	// this.sq[4][11] = X;
	// this.sq[4][14] = X;
	// this.sq[5][11] = X;
	// this.sq[5][12] = X;
	// this.sq[5][13] = X;
	// this.sq[6][11] = X;
	// this.sq[6][14] = X;
	// this.sq[3][16] = X;
	// this.sq[3][17] = X;
	// this.sq[3][18] = X;
	// this.sq[3][19] = X;
	// this.sq[4][16] = X;
	// this.sq[4][19] = X;
	// this.sq[5][16] = X;
	// this.sq[5][19] = X;
	// this.sq[6][16] = X;
	// this.sq[6][17] = X;
	// this.sq[6][18] = X;
	// this.sq[6][19] = X;
	//
	// this.sq[13][1] = O;
	// this.sq[13][2] = O;
	// this.sq[13][3] = O;
	// this.sq[13][4] = O;
	// this.sq[14][1] = O;
	// this.sq[15][1] = O;
	// this.sq[16][1] = O;
	// this.sq[16][2] = O;
	// this.sq[16][3] = O;
	// this.sq[16][4] = O;
	// this.sq[13][1] = O;
	// this.sq[13][7] = O;
	// this.sq[13][8] = O;
	// this.sq[14][6] = O;
	// this.sq[14][9] = O;
	// this.sq[15][6] = O;
	// this.sq[15][7] = O;
	// this.sq[15][8] = O;
	// this.sq[15][9] = O;
	// this.sq[16][6] = O;
	// this.sq[16][9] = O;
	// this.sq[13][11] = O;
	// this.sq[13][12] = O;
	// this.sq[13][13] = O;
	// this.sq[13][14] = O;
	// this.sq[14][11] = O;
	// this.sq[14][14] = O;
	// this.sq[15][11] = O;
	// this.sq[15][12] = O;
	// this.sq[15][13] = O;
	// this.sq[16][11] = O;
	// this.sq[16][14] = O;
	// this.sq[13][16] = O;
	// this.sq[13][17] = O;
	// this.sq[13][18] = O;
	// this.sq[13][19] = O;
	// this.sq[14][16] = O;
	// this.sq[14][19] = O;
	// this.sq[15][16] = O;
	// this.sq[15][19] = O;
	// this.sq[16][16] = O;
	// this.sq[16][17] = O;
	// this.sq[16][18] = O;
	// this.sq[16][19] = O;


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
