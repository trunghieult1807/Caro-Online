var ctrl = {
	newGame : function() {
		currGame = new game(16, 16);
		// board.writeBoard();
		board.writeBoard();
	},
	rewind : function() {

	},
	surrender : function() {
		// alert(':D');
		// currGame.isGamming = false;
	},
	quit : function() {
	// 	if (currGame.Turn == X) {
	// 		var bestMove = {row: 0, col:0};
	// 		AIthink(X, bestMove);
	// 		currGame.sq[bestMove.row][bestMove.col] = X;
	// 		board.sqUpdate(bestMove.row, bestMove.col);
	// 		referee.checkWin();
	// 		currGame.Turn = O;
	// 		currGame.noOfPiece++;
	// 	} else {
	// 		var bestMove = {row:0, col:0};
	// 		AIthink(O, bestMove);
	// 		currGame.sq[bestMove.row][bestMove.col] = O;
	// 		board.sqUpdate(bestMove.row, bestMove.col);
	// 		referee.checkWin();
	// 		currGame.Turn = X;
	// 		currGame.noOfPiece++;
	// 	}
	},
	twoPlayer : function() {
		currGame = new game(16, 16);
		board.writeBoardTwoPlayer();
	}
};
