var board = {
	writeBoard: function(){
		var st = '';
		st = '<table id="board-table"><tbody>';
		for(var i=0; i < currGame.noOfRow; i++){
			st += '<tr>';
			for(var j=0; j < currGame.noOfCol; j++){
				st += '<td class="square" id="s' +String('00' + i).slice(-2) + String('00' + j).slice(-2) + '" onclick="board.sqClick(' + String(i) + ',' + String(j) + ')"></td>';
			};
			st += '</tr>';
		}
		st+= '</tbody></table>';
		document.getElementById('board').innerHTML = st;
		for(var i=0; i < currGame.noOfRow; i++){
			for(var j=0; j < currGame.noOfCol; j++){
				board.sqUpdate(i,j);
			}
		}
	},
	writeBoardTwoPlayer: function(){
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
		for(var i=0; i < currGame.noOfRow; i++){
			for(var j=0; j < currGame.noOfCol; j++){
				board.sqUpdate(i,j);
			}
		}
	},
	sqUpdate: function(i,j){
		var OHtml='<img src="img/o.png">';
		var XHtml='<img src="img/x.png">';
		if (currGame.sq[i][j] == O){
			document.getElementById('s'+String('00' + i).slice(-2)+String('00' + j).slice(-2)+'').innerHTML = OHtml;
		} else if (currGame.sq[i][j] == X){
			document.getElementById('s'+String('00' + i).slice(-2)+String('00' + j).slice(-2)+'').innerHTML = XHtml;
		} else {
			document.getElementById('s'+String('00' + i).slice(-2)+String('00' + j).slice(-2)+'').innerHTML = '';
		}
	},
	/* when click a currGame.square */
	sqClick: function(row, col) {
		if (currGame.isGamming && currGame.sq[row][col] == 0 && currGame.Turn == X) {
			currGame.xMove(row, col);
		}
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
