var board = {
	writeBoardTwoPlayer: function(){
		var st = '';
		st = '<table id="board-table"><tbody>';
		for(var i=0; i < 16; i++){
			st += '<tr>';
			for(var j=0; j < 16; j++){
				st += '<td class="square" id="s' +String('00' + i).slice(-2) + String('00' + j).slice(-2) + '" onclick="board.sqClickTwoPlayer(' + String(i) + ',' + String(j) + '); board.pushToServer(' + String(i) + ',' + String(j) + ');"></td>';
			};
			st += '</tr>';
		}
		st+= '</tbody></table>';
		document.getElementById('board').innerHTML = st;
	},
	sqUpdate: function(i,j){
		var OHtml='<img src="./static/caro/img/o.png">';
		var XHtml='<img src="./static/caro/img/x.png">';
		if (currGame.sq[i][j] == O){
			document.getElementById('s'+String('00' + i).slice(-2)+String('00' + j).slice(-2)+'').innerHTML = OHtml;
		} else if (currGame.sq[i][j] == X){
			document.getElementById('s'+String('00' + i).slice(-2)+String('00' + j).slice(-2)+'').innerHTML = XHtml;
		} else {
			document.getElementById('s'+String('00' + i).slice(-2)+String('00' + j).slice(-2)+'').innerHTML = '';
		}
	},

	pushToServer: function(row, col) {
  		var xhttp = new XMLHttpRequest();
  		// xhttp.onreadystatechange = function() {
    	// 	if (this.readyState == 4 && this.status == 200) {
				var str1 = "Player clicks at row " + row;
				var str2 = "Player clicks at column " + col;
				console.log(str1);
				console.log(str2);
    	// 	}
  		// };
  		// xhttp.open("GET", "http://127.0.0.1:5000");
  		// xhttp.send();
	},

	sqClickTwoPlayer: function(row, col) {
		if (currGame.isGamming && currGame.sq[row][col] == 0 && currGame.Turn == X) {
			currGame.xMoveTwoPlayer(row, col);

		}
		if (currGame.isGamming && currGame.sq[row][col] == 0 && currGame.Turn == O) {
			currGame.oMoveTwoPlayer(row, col);
		}
	},
};

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


	timer.setTimer(300, 300);

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
