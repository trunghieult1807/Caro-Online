const Mark = 1, Empty = 0;

function game(noOfRow, noOfCol) {
	this.noOfRow = noOfRow, this.noOfCol = noOfCol;
	this.Turn = 1;
	this.isGamming = true; //currGame.isGamming or Not.
	this.noOfPiece = 0; //number of Pieces on the table -> to check draw
	this.sq = new Array(); /* define an array storing XO position */
	for (var i = 0; i < this.noOfRow; i++) {
		this.sq[i] = new Array();
		for (var j = 0; j < this.noOfCol; j++) {
			this.sq[i][j] = Empty;
		}
	}

	//With player
	this.xMoveTwoPlayer = function(i,j){
		var mes = "This is x move: " + Mark;
		console.log(mes);
		currGame.sq[i][j] = Mark;
		board.sqUpdate(i, j);
		currGame.noOfPiece++;
		currGame.Turn = 2;
	};

	this.oMoveTwoPlayer = function(i,j){
		var mes = "This is y move: " + Mark;
		console.log(mes);
		currGame.sq[i][j] = Mark;
		board.sqUpdate(i, j);
		currGame.noOfPiece++;
		currGame.Turn = 1;
	};
}



var board = {
	drawBoard: function(){
		timer.setTimer(300, 300);
		var st = '';
		st = '<table id="board-table"><tbody>';
		for(var i=0; i < currGame.noOfRow; i++){
			st += '<tr>';
			for(var j=0; j < currGame.noOfCol; j++){
				st += '<td class="square" id="s' +String('00' + i).slice(-2) + String('00' + j).slice(-2) + '" onclick="board.sqClickTwoPlayer(' + String(i) + ',' + String(j) + ')"></td>';
			};
			st += '</tr>';
		}
		st+= '</tbody></table>';
		document.getElementById('board').innerHTML = st;
		for(var i = 0; i < currGame.noOfRow; i++){
			for(var j = 0; j < currGame.noOfCol; j++){
				board.sqUpdate(i,j);
			}
		}
	},
	sqUpdate: function(i,j){
		var OHtml='<img src="./img/o.png">';
		var XHtml='<img src="./img/x.png">';

		if (currGame.sq[i][j] == Mark && currGame.Turn == 2){
			document.getElementById('s'+String('00' + i).slice(-2)+String('00' + j).slice(-2)+'').innerHTML = OHtml;
		}
		else if (currGame.sq[i][j] == Mark && currGame.Turn == 1){
			document.getElementById('s'+String('00' + i).slice(-2)+String('00' + j).slice(-2)+'').innerHTML = XHtml;
		}
		else {
			document.getElementById('s'+String('00' + i).slice(-2)+String('00' + j).slice(-2)+'').innerHTML = '';
		}
	},

	sqClickTwoPlayer: function(row, col) {
		if (currGame.isGamming && currGame.sq[row][col] == Empty && currGame.Turn == 1) {
			currGame.xMoveTwoPlayer(row, col);
		}
		if (currGame.isGamming && currGame.sq[row][col] == Empty && currGame.Turn == 2) {
			currGame.oMoveTwoPlayer(row, col);
		}
	},
};


var currGame = new game(16, 16);
board.drawBoard();
