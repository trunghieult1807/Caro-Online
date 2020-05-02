function AIthink(player, move){ // AI will think for a player.
	var XX,YY;
	if (player == O){
		alphabeta(O, -Infinity, Infinity, 2);
	} else {
		alphabeta(X, -Infinity, Infinity, 2);
	}
	move.row = XX; move.col=YY;
	function cval(){  // evaluate the board
		var cval_value = 0;
		var val = function(XO){
			var mArray = []; //Match [^1][01][01][01][01][01]0
			var value = 0;
			var count = 0 // count the number of pieces
			var regexp = (XO == X) ? /[^1][01][01][01][01][01]0/g : /[^2][02][02][02][02][02]0/g;
			var regexp2 = (XO == X) ? /0[01][01][01][01][01][^1]/g : /0[02][02][02][02][02][^2]/g;
			var	regexp3 = (XO == X) ? /1/g : /2/g;
			mArray = valStr.match(regexp).concat(valStr.match(regexp2));
			for (var x in mArray) {
				count = (mArray[x].match(regexp3) || []).length; //number of XO;
				switch (count) {
					case 5: value += 9999999; break;
					case 4: value += 1000; break;
					case 3: value += 10; break;
					case 2: value += 1; break;
				}
			}
			return value;
		}
		// horizontally eval (col +-)
		var valStr = ''; //1:X, 2: O, 0: Empty or Out of Board, 3: concat two line
		for (var i = 0; i < currGame.noOfRow; i++) {
			valStr += '0' + currGame.sq[i].join('') + '03';
		}

		// vertically eval (row +-)
		//1:X, 2: O, 0: Empty or Out of Board, 3: concat two line
		for (var j = 0; j < currGame.noOfCol; j++) {
			valStr += '0';
			for (var i = 0; i < currGame.noOfRow; i++) {
				valStr += currGame.sq[i][j];
			}
			valStr += '03';	
		}
		// dia from top
		 //1:X, 2: O, 0: Empty or Out of Board, 3: concat two line
		for (var k = 0; k < currGame.noOfCol; k++) {
			valStr += '0';
				i=0; j=k;
				while (i < currGame.noOfRow && j < currGame.noOfCol){
					valStr += currGame.sq[i][j];
					i++; j++;
				}
			valStr += '03';	
		}
		for (var k = 0; k < currGame.noOfCol; k++) {
			valStr += '0';
				i=0; j=k;
				while (i < currGame.noOfRow && j >= 0){
					valStr += currGame.sq[i][j];
					i++; j--;
				}
			valStr += '03';	
		}
		// dia from bottom
		for (var k = 0; k < currGame.noOfCol; k++) {
			valStr += '0';
				i=currGame.noOfRow-1; j=k;
				while (i >= 0 && j >= 0){
					valStr += currGame.sq[i][j];
					i--; j--;
				}
			valStr += '03';	
		}
		for (var k = 0; k < currGame.noOfCol; k++) {
			valStr += '0';
				i=currGame.noOfRow-1; j=k;
				while (i >= 0 && j < currGame.noOfCol){
					valStr += currGame.sq[i][j];
					i--; j++;
				}
			valStr += '03';	
		}
		cval_value = val(O) - val(X);
		return cval_value;
	};
	function alphabeta(XO,alpha,beta, depth){
	if (referee.isWin() == X){
		return -999999999;
	}
	if (referee.isWin() == O){
		return 999999999;
	}
	if (depth==0){
		return cval();
	}
	var moveGen = function (XO){
		this.moveRow = new Array();
		this.moveCol = new Array();
		this.noOfMove = 0;
		var possi = new Array(); /* define an array storing possible position */
		for (var i = 0; i < currGame.noOfRow; i++) {
			possi[i] = new Array();
			for (var j = 0; j < currGame.noOfCol; j++) {
				possi[i][j]=false;
			}
		}
		for (var i = 0; i < currGame.noOfRow; i++) {
			for (var j = 0; j < currGame.noOfCol; j++) {
				if ((currGame.sq[i][j] == Empty) && (!possi[i][j])){
					for (var stepI = -1; stepI <= 1; stepI++) {
						for (var stepJ = -1; stepJ <= 1; stepJ++) {
							if (i+stepI>=0 && i+stepI<currGame.noOfRow && j+stepJ>=0 && j+stepJ<currGame.noOfCol){
								if (currGame.sq[i+stepI][j+stepJ] != Empty){
									possi[i][j] = true;
								} 
							}
						}
					}
				}
			}
		}
		for (var i = 0; i < currGame.noOfRow; i++) {
			for (var j = 0; j < currGame.noOfCol; j++) {
				if (possi[i][j]){
					this.noOfMove++;
					this.moveRow[this.noOfMove]=i;
					this.moveCol[this.noOfMove]=j;
					
				}
			}
		}
	}
	var makeMove = function(moveBoard, movePointer, XO){
		currGame.sq[moveBoard.moveRow[movePointer]][moveBoard.moveCol[movePointer]] = XO;
	}
	var undoMove = function(moveBoard, movePointer){
		currGame.sq[moveBoard.moveRow[movePointer]][moveBoard.moveCol[movePointer]] = Empty;
	}
	var gen = new moveGen(XO);
	var movePointer = 1;
	var score;
    if(XO == O){ //Max's currGame.Turn
    	while(movePointer <= gen.noOfMove){
    		makeMove(gen, movePointer, XO);
    		score = alphabeta(X, alpha, beta, depth-1);
    		undoMove(gen, movePointer);
    		if (score > alpha){
    			XX = gen.moveRow[movePointer];
    			YY = gen.moveCol[movePointer];
    			alpha = score; //(we have found a better best move)
    		}
    		if (alpha >= beta){
    			return alpha //(cut off);
    		}
    		movePointer++;
    	}
    	return alpha; //best move
    } else { //Min's currGame.Turn
    	while(movePointer <= gen.noOfMove){
    		makeMove(gen, movePointer, XO);
    		score = alphabeta(O, alpha, beta, depth-1);
    		undoMove(gen, movePointer);
    		if (score < beta){
    			beta = score; //(opponent has found a better worse move)
    		}
    		if (alpha >= beta) return beta //(cut off);
    		movePointer++;
    	}
    	return beta; //(this is the opponent's best move)
    }
	}
}



