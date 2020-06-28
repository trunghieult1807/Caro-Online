
const Mark = 1, Empty = 0;

function game(noOfRow, noOfCol) {
	this.noOfRow = noOfRow, this.noOfCol = noOfCol;
	this.Turn = 1;
	this.isGamming = true; //caro_game.isGamming or Not.
	this.noOfPiece = 0; //number of Pieces on the table -> to check draw
	this.sq = new Array(); /* define an array storing XO position */
	for (var i = 0; i < this.noOfRow; i++) {
		this.sq[i] = new Array();
		for (var j = 0; j < this.noOfCol; j++) {
			this.sq[i][j] = Empty;
		}
	}

	//With player
	this.xMove = function(i,j){
		var mes = "This is x move: " + Mark;
		console.log(mes);
		caro_game.sq[i][j] = Mark;
		board.sqUpdate(i, j);
		caro_game.noOfPiece++;
		caro_game.Turn = 2;
	};

	this.oMove = function(i,j){
		var mes = "This is y move: " + Mark;
		console.log(mes);
		caro_game.sq[i][j] = Mark;
		board.sqUpdate(i, j);
		caro_game.noOfPiece++;
		caro_game.Turn = 1;
	};
}



var board = {
	drawBoard: function(){
		timer.setTimer(300, 300);
		var st = '';
		st = '<table id="board-table"><tbody>';
		for(var i=0; i < caro_game.noOfRow; i++){
			st += '<tr>';
			for(var j=0; j < caro_game.noOfCol; j++){
				st += '<td class="square" id="s' +String('00' + i).slice(-2) + String('00' + j).slice(-2) + '" onclick="board.sqClickTwoPlayer(' + String(i) + ',' + String(j) + ')"></td>';
			};
			st += '</tr>';
		}
		st+= '</tbody></table>';
		document.getElementById('board').innerHTML = st;
		for(var i = 0; i < caro_game.noOfRow; i++){
			for(var j = 0; j < caro_game.noOfCol; j++){
				board.sqUpdate(i,j);
			}
		}
	},
	sqUpdate: function(i,j){
		var OHtml='<img src="../static/caro/img/o.png">';
		var XHtml='<img src="../static/caro/img/x.png">';

		if (caro_game.sq[i][j] == Mark && caro_game.Turn == 2){
			document.getElementById('s'+String('00' + i).slice(-2)+String('00' + j).slice(-2)+'').innerHTML = OHtml;
		}
		else if (caro_game.sq[i][j] == Mark && caro_game.Turn == 1){
			document.getElementById('s'+String('00' + i).slice(-2)+String('00' + j).slice(-2)+'').innerHTML = XHtml;
		}
		else {
			document.getElementById('s'+String('00' + i).slice(-2)+String('00' + j).slice(-2)+'').innerHTML = '';
		}
	},

	sqClickTwoPlayer: function(row, col) {
		if (caro_game.isGamming && caro_game.sq[row][col] == Empty && caro_game.Turn == 1) {
			caro_game.xMove(row, col);
		}
		if (caro_game.isGamming && caro_game.sq[row][col] == Empty && caro_game.Turn == 2) {
			caro_game.oMove(row, col);
		}
		// 
		// var message = {
		// 	'row': row,
		// 	'col': col,
		// }
		// socket.send(JSON.stringify(message));
	},
};


var caro_game = new game(16, 16);
board.drawBoard();
