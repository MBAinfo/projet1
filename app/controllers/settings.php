<?php 

	// modification des informations de l'utilisateur connecté
	if (!empty($_POST)) {
		var_dump($_POST);
		var_dump($_SESSION);
		$login = (isset($_POST['login'])) ? $_POST['login'] : $_SESSION['user']['login'] ;
	}


	/**
	 * affichage
	 */
	$sql = "SELECT id, login, password, email, role
			FROM gfs_users
			WHERE login = '{$_SESSION['user']['login']}'
	";

	// Execution de la requette
	$result = mysqli_query($db, $sql)
		or errorLog('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($db));

	// recuperation des lignes de resultat qu'on passe à la vue via le tableau $list_msg
	$user_info = mysqli_fetch_assoc($result);

	$params = array(
		'login' => $user_info['login'],
		'email' => $user_info['email'],
		'role' => $user_info['role']
	);

	render('settings', $params);
