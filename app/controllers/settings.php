<?php 

	/**
	  * Modification des informations de l'utilisateur
	  */
	if (!empty($_POST)) {
		$login = $_SESSION['user']['login'] ;
		$email = (!empty($_POST['email'])) ? $_POST['email'] : $_SESSION['user']['email'] ;
		$password = (!empty($_POST['password'])) ? sha1($_POST['password']) : $_SESSION['user']['password'] ;
		$role = (!empty($_POST['role'])) ? $_POST['role'] : $_SESSION['user']['role'] ;

		$sql = "UPDATE gfs_users
				SET 
					password = '{$password}', 
					email = '{$email}', 
					role = '{$role}'
				WHERE login = '{$login}'
		";

		$result = $db->query($sql);

		if (!$result) {
			flash("danger", "Erreur SQL !");
		}
	}


	/**
	 * affichage
	 */
	$sql = "SELECT id, login, password, email, role
			FROM gfs_users
			WHERE login = '{$_SESSION['user']['login']}'
	";

	// Execution de la requette
	$result = $db->query($sql)
		or flash("danger", "Erreur SQL : {$db->error}");

	// recuperation des lignes de resultat qu'on passe à la vue via le tableau $list_msg
	$user_info = $result->fetch_assoc();

	$params = array(
		'login' => $user_info['login'],
		'email' => $user_info['email'],
		'role' => $user_info['role']
	);

	render('settings', $params);
