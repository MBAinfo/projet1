<?php

	if (!isset($_POST['action'])) {
		die("erreur dans ajax.php");
	}

	switch ( $_POST['action'] ) {
		case 'getMessages':
			ajax_getMessages();
			break;

		case 'postMessage':
			ajax_postMessage();
			break;
		
		default:
			error();
			break;
	}


	function ajax_getMessages()
	{
		echo "coucou";
	}


	function ajax_postMessage()
	{
		global $db;
		
		postMessage($_POST['message']);

		// Dans tous les cas, on recupère les messages qui comprennent le hashtag du user
		// en base de données pour les afficher dans la page
		$username = $_SESSION['user']['login'];

		$sql = "SELECT created_at, message
				FROM gfs_msg
				WHERE id IN (
					SELECT id_message
					FROM gfs_hashtag
					WHERE tag = '@{$username}'
				)
				ORDER BY created_at DESC";

		// Execution de la requette
		$result = $db->query($sql)
			or errorLog('Erreur SQL !<br />'.$sql.'<br />'.$db->error);

		// recuperation des lignes de resultat qu'on pass à la vue via le tableau $list_msg
		while($row = $result->fetch_assoc()) { 
			// la variable $list_msg sera passée à la vue pour etre affichée
			$list_msg[] = $row;
		}

		$params = compact('list_msg');
		render('ajax', $params, false);
	}


	function error()
	{
		echo "error";
	}
