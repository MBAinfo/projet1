<?php

	// si on a des variables en POST, c'est qu'un message est envoyé
	// on va alors le traiter et l'inserer dans la db
	if (isset($_POST['message']))
	{
		postMessage($_POST['message']);
	}
	

	// Dans tous les cas, on recupère les messages en base de données pour les afficher dans la page
	$sql = "SELECT message, created_at
			FROM gfs_msg 
			ORDER BY id DESC";

	// Execution de la requette
	$result = mysqli_query($db, $sql)
		or errorLog('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($db));

	// recuperation des lignes de resultat qu'on pass à la vue via le tableau $list_msg
	$list_msg = array();
	while($row = mysqli_fetch_array($result)) { 
		$list_msg[] = $row;
	}


	$params = compact('list_msg');
	render('general', $params);