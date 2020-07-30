// Send message to server when clicks ready button
document.querySelector('#readyButton').onclick = function() {
	let action = '';
	if (document.querySelector("#waitingStatus").value == "READY") {
		document.querySelector("#waitingStatus").value = "WAITING...";
		action = 'ready';
	}
	else {
		document.querySelector("#waitingStatus").value = "READY";
		action = 'unready';
	}

	console.log("Ready clicked");
	console.log(`${username}: ${action}`);

	socket.send(JSON.stringify({
		'action': action,
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
};

var ctrl = {
	newGame : function() {
		// board.writeBoard();
		//board.drawBoard();
	},
	rewind : function() {

	},
	surrender : function() {
		// alert(':D');
		// currGame.isGamming = false;
	},
	quit : function() {
		// Quit the game
	},
	twoPlayer : function() {
		board.drawBoard();
	}
};

// var wasSubmitted = false;
//     function checkBeforeSubmit(){
//       if(!wasSubmitted) {
//         wasSubmitted = true;
//         return wasSubmitted;
//       }
//       return false;
//     }
