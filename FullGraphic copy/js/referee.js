var referee = {
	isWin: function(){
		if (currGame.noOfPiece == currGame.noOfCol*currGame.noOfRow){
			return 3; //Draw
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

		if (valStr.search(/[^1]111110/) != -1 || valStr.search(/011111[^1]/) != -1){
			return 1
		}
		if (valStr.search(/[^2]222220/) != -1 || valStr.search(/022222[^2]/) != -1){
			return 2
		}



	},
	checkWin : function(){
		var result = referee.isWin();
		if ( result == 1){	//check from current currGame.sq: has  the current player won?
			alert('X win!');
			currGame.isGamming = false;
		} else if ( result == 2){
			alert('O win!');
			currGame.isGamming = false;
		} else if (result == 3) {  //check draw
			alert('Draw!');
			currGame.isGamming = false;
		}
	},
};
