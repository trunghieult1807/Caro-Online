document.querySelectorAll(".room-id").forEach(room => {
	room.addEventListener('click', () => {
		var roomId = room.name;
		window.location.pathname = `/caro/${roomId}/`;
	});
});
