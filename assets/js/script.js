
// durée d'un interval entre 2 recherches de nouveaux messages
var interval = 2000;

$(function(){

	$('#chat-form').on('submit', function() {
		event.preventDefault();
		var message = $("#message").val();
		postMessage(message);
	})


	// lance la fonction de récupération des nouveaux messages toutes les "interval" secondes
	// window.setInterval(getMessages, interval);

});