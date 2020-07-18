const MARK = 1, EMPTY = 0;
const OHtml = '<img src="../../static/caro/img/o.png">';
const XHtml = '<img src="../../static/caro/img/x.png">';

function game(noOfRow, noOfCol) {
	this.noOfRow = noOfRow, this.noOfCol = noOfCol;
	this.Turn = 1;
	this.isGamming = true; //caro_game.isGamming or Not.
	this.noOfPiece = 0; //number of Pieces on the table -> to check draw
	this.sq = new Array(); /* define an array storing XO position */
	for (var i = 0; i < this.noOfRow; i++) {
		this.sq[i] = new Array();
		for (var j = 0; j < this.noOfCol; j++) {
			this.sq[i][j] = EMPTY;
		}
	}

	// Moving option
	this.xMove = function(i,j){
		var mes = `X move: (${i}, ${j})`;
		console.log(mes);
		caro_game.sq[i][j] = MARK;
		board.sqUpdate(i, j);
		caro_game.noOfPiece++;
		caro_game.Turn = 2;
	};
	this.oMove = function(i,j){
		var mes = `O move: (${i}, ${j})`;
		console.log(mes);
		caro_game.sq[i][j] = MARK;
		board.sqUpdate(i, j);
		caro_game.noOfPiece++;
		caro_game.Turn = 1;
	};

	this.xMoveDisplay = function(i,j){
		var mes = `X move: (${i}, ${j})`;
		console.log(mes);
		board.sqUpdateDisplay(i, j);
	};
	this.oMoveDisplay = function(i,j){
		var mes = `O move: (${i}, ${j})`;
		console.log(mes);
		board.sqUpdateDisplay(i, j);
	};
}

var board = {
	clearTimer: function() {
		timer.clearTimer();
	},
	closeWinBox: function() {
		button = document.getElementById('win-box');
		button.style.visibility = "hidden";
		board.clearTimer();
	},
	closeLoseBox: function() {
		button = document.getElementById('lose-box');
		button.style.visibility = "hidden";
		board.clearTimer();
	},
	readyClick: function() {
		button = document.getElementById('readyButton');
		button.style.visibility = 'hidden';
	},
	tryAgainClick: function() {
		button = document.getElementById('readyButton');
		button.style.visibility = 'visible';
	},

	drawBoard: function() {
		timer.setTimer(300, 300);
		var st = '';
		st = '<table id="board-table"><tbody>';
		for(var i=0; i < caro_game.noOfRow; i++){
			st += '<tr>';
			for(var j=0; j < caro_game.noOfCol; j++){
				var n = j + caro_game.noOfCol*i;
				st += '<td class="square" id="' + n + '" onclick="board.sqClickTwoPlayer(' + n + ')"></td>';
			};
			st += '</tr>';
		}
		st+= '</tbody></table>';
		document.getElementById('board').innerHTML = st;
		for(var i = 0; i < caro_game.noOfRow; i++){
			for(var j = 0; j < caro_game.noOfCol; j++){
				caro_game.sq[i][j] = 0;
				board.sqUpdate(i,j);
			}
		}
		caro_game.Turn = 1;
	},
	sqUpdate: function(i,j) {
		if (caro_game.sq[i][j] == MARK && caro_game.Turn == 2){
			document.getElementById(String(j + caro_game.noOfCol*i)).innerHTML = OHtml;
		}
		else if (caro_game.sq[i][j] == MARK && caro_game.Turn == 1){
			document.getElementById(String(j + caro_game.noOfCol*i)).innerHTML = XHtml;
			caro_game.sq[i][j] = MARK;
		}
		else {
			document.getElementById(String(j + caro_game.noOfCol*i)).innerHTML = '';
		}
	},
	sqUpdateDisplay: function(i,j) {
		if (caro_game.Turn == 2){
			document.getElementById(String(j + caro_game.noOfCol*i)).innerHTML = OHtml;
		}
		else if (caro_game.Turn == 1){
			document.getElementById(String(j + caro_game.noOfCol*i)).innerHTML = XHtml;
		}
		else {
			document.getElementById(String(j + caro_game.noOfCol*i)).innerHTML = '';
		}
	},

	sqClickTwoPlayer: function(n) {
		var row = Math.floor(n / caro_game.noOfCol);
		var col = n % caro_game.noOfCol;

		// Check move condition
		if (caro_game.sq[row][col] == MARK) {
			return null;
		}
		if (current_turn != username) {
			console.log(`Not your turn ${username}`);
			return null;
		}

		// Make move
		current_turn = null;
		if (caro_game.Turn == 1) {
			caro_game.xMoveDisplay(row, col);
		}
		else if (caro_game.Turn == 2) {
			caro_game.oMoveDisplay(row, col);
		}

		console.log("Square click");
		socket.send(JSON.stringify({
			'action': 'make_move',
			'user': username,
			'room_id': roomId,
			'row': row,
			'col': col
		}));
	},
};


var caro_game = new game(16, 16);
board.drawBoard();
