const MARKED = 1, EMPTY = 0;

function game(noOfRow, noOfCol) {
	this.height = noOfRow;
	this.width = noOfCol;
	this.isGamming = true;

	this.sq = new Array(); /* define an array storing XO position */
	for (var i = 0; i < this.height; i++) {
		this.sq[i] = new Array();
		for (var j = 0; j < this.width; j++) {
			// Initialize with empty cell
			this.sq[i][j] = EMPTY;
		}
	}
}

var board = {
	drawBoard: function(){
		var st = '';
		st = '<table id="board-table"><tbody>';
		for(var i=0; i < caro_game.no; i++){
			st += '<tr>';
			for(var j=0; j < 16; j++){
				st += '<td class="square" id="s' +String('00' + i).slice(-2) + String('00' + j).slice(-2) + '" onclick="board.pushToServer(' + String(i) + ',' + String(j) + ');"></td>';
			};
			st += '</tr>';
		}
		st+= '</tbody></table>';
		document.getElementById('board').innerHTML = st;
	},

	sqUpdate: function(i,j){
		var OHtml='<img src="./static/caro/img/o.png">';
		var XHtml='<img src="./static/caro/img/x.png">';
		if (caro_game.sq[i][j] == O){
			document.getElementById('s'+String('00' + i).slice(-2)+String('00' + j).slice(-2)+'').innerHTML = OHtml;
		} else if (caro_game.sq[i][j] == X){
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
		if (caro_game.isGamming && caro_game.sq[row][col] == 0) {
			caro_game.sq[row][col] = MARKED;
		}
	},
};

var caro_game = new game(16, 16);
board.drawBoard();
