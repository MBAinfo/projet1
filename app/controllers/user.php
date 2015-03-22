<?php 

	// si on a des variables en POST, c'est qu'un message est envoyé
	// on va alors le traiter et l'inserer dans la db
	if (isset($_POST['message']))
	{
		postMessage($_POST['message']);
	}

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

	$list_msg = array();
	// recuperation des lignes de resultat qu'on pass à la vue via le tableau $list_msg
	while($row = $result->fetch_assoc()) { 
		// la variable $list_msg sera passée à la vue pour etre affichée
		$list_msg[] = $row;
	}

	$params = compact('user', 'list_msg');
	render('user', $params);