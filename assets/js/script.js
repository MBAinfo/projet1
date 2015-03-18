

$(function(){
	
	// durée d'un interval entre 2 recherches de nouveaux messages
	var interval = 15000;

	window.setInterval(function(){
		location.reload();
	}, interval);

});