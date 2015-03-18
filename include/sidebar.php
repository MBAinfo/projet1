<?php 

	// traitement à effectuer pour afficher les projets, les tâches, les documents... dans la sidebar

	global $db;
	global $config;



	$username = $_SESSION['user']['login'];
	
	/**
	 * PROJETS
	 */
	$sql = "SELECT h2.id, h2.tag
			FROM gfs_hashtag h1
			INNER JOIN gfs_hashtag h2 ON h1.id_message = h2.id_message
			WHERE h1.tag = '@{$username}'
			AND h2.tag LIKE '#%'
			AND h2.tag NOT IN ('".implode("','", $config['app']['keywords'])."')
			GROUP BY h2.tag
	";

	// Execution de la requette
	$result = mysqli_query($db, $sql)
		or errorLog('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($db));

	$projects = array();
	// recuperation des lignes de resultat qu'on pass à la vue via le tableau $list_msg
	while($row = mysqli_fetch_assoc($result)) { 
		$projects[] = $row;
	}

	

	/**
	 * TACHES
	 */	
	// $sql = "

	// ";

	// // Execution de la requette
	// $result = $db->query($sql)
	// 	or flash("danger", "Erreur SQL : {$db->error}");

	// $tasks = array();
	// // recuperation des lignes de resultat qu'on pass à la vue via le tableau $list_msg
	// while($row = $result->fetch_assoc()) { 
	// 	$tasks[] = $row;
	// }


	
	/**
	 * DOCUMENTS
	 */
	$sql = "SELECT id, message
			FROM gfs_msg
			WHERE id IN (
				SELECT h1.id_message
				FROM gfs_hashtag h1
				INNER JOIN gfs_hashtag h2 ON h1.id_message = h2.id_message
				WHERE 1 = 1
				-- AND h1.tag = '@{$username}'
				AND h2.tag = '#document'
			)
	";

	// Execution de la requette
	$result = $db->query($sql)
		or flash("danger", "Erreur SQL : {$db->error}");

	$documents = array();
	// recuperation des lignes de resultat qu'on passe à la vue via le tableau $list_msg
	while($row = $result->fetch_assoc()) { 
		$row['message'] = extractDocTitle($row['message']);
		$documents[] = $row;
	}