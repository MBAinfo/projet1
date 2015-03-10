	
	/**
	 * Envoi le message en ajax
	 **/
	function postMessage(message) {
		var jqxhr = $.ajax({
			// type de requete ajax (ici POST. default = GET)
			type: "POST",
			// url de la page appelée par la requette ajax
			url: "http://localhost/formation/projet/projet/ajax",
			// parametres passés en POST
			data: {
				'action' : 'postMessage',
				'message' : message
			},
			// en cas de succes de la requette ajax...
			success: function(result) {
				var msg = $("#messages");
				msg
					// on cache le chat
					.fadeOut()
					// on utlise une queue pour eviter que le reste ne s'execute avant la fin du fadeOut
					.queue(function () {
						msg
							// on vide la liste de msg
							.empty()
							// on la rerempli avec le nouveau contenu
							.html(result)
							// on la ré-affiche
							.fadeIn()
					// on lance la queue
					.dequeue();
					})
			},
			error: function() {
				alert('erreur ajax');
			}
		});
	}
	


	/**
	 * Envoi le message en ajax
	 **/
	function getMessages() {
		// on va récupérer tous les messages plus récents que le dernier message posté
		var lastId = 10;
		var jqxhr = $.ajax({
			// type de requete ajax (ici POST. default = GET)
			type: "POST",
			// url de la page appelée par la requette ajax
			url: "http://localhost/formation/projet/projet/ajax",
			// parametres passés en POST
			data: {
				'action' : 'getMessages',
				'lastId' : lastId
			},
			// en cas de succes de la requette ajax...
			success: function(result) {
				console.log(result);
			},
			error: function() {
				alert('erreur ajax');
			}
		});		
	}