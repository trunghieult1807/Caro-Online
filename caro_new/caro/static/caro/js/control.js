// Send message to server when clicks ready button
document.querySelector('#readyButton').onclick = function() {
	if (document.querySelector("#waitingStatus").value == "READY") {
		document.querySelector("#waitingStatus").value = "WAITING...";
	}
	else {
		return false;
	}

	console.log("Ready clicked");
	console.log(username);

	socket.send(JSON.stringify({
		'action': 'create_game',
		'user': username,
		'room_id': roomId
	}));
};

// Leave room button
document.querySelector('#return-box').onclick = function() {
	socket.send(JSON.stringify({
		'action': 'leave_room',
		'user': username,
		'room_id': roomId
	}))

	// Redirect
	window.location.pathname = '/';
};

var ctrl = {
	newGame : function() {
		// board.writeBoard();
		// board.drawBoard();
	},
	rewind : function() {

	},
	surrender : function() {
		// alert(':D');
		// currGame.isGamming = false;
	},
	quit : function() {

	},
	twoPlayer : function() {
		board.drawBoard();
	}
};
