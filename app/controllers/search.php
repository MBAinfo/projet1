<?php 

	/**
	 * CONTROLLEUR DE RECHERCHE DE HASTAG
	 */

	// si on tente d'accéder directement à cette page, on redirige sur l'accueil
	if ( !isset($_POST['search']) ) { redirect('accueil'); }


	$search = $_POST['search'];

	$sql = "SELECT id, tag
			FROM gfs_hashtag
			WHERE tag LIKE '%{$search}%'
			GROUP BY tag
	";

	// Execution de la requette
	$result = $db->query($sql)
		or errorLog('Erreur SQL !<br />'.$sql.'<br />'.$db->error);

	// recuperation des lignes de resultat qu'on passe à la vue via le tableau $list_msg
	$list_hashtags = array();
	while($row = $result->fetch_assoc()) { 
		// la variable $list_msg sera passée à la vue pour etre affichée
		$list_hashtags[] = $row;
	}

	// si aucun résultat n'est trouvé, on affiche un message d'erreur
	if (empty($list_hashtags)) {
		flash('warning', "Aucun résultat pour la recherche '{$search}'");
	}

	$params = compact('list_hashtags');
	render('search', $params);