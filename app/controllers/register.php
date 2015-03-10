<?php

function addUserInDB($login,$email,$password,$role) {
	global $db;

	$date = date('Y-m-d');

	$sql = "INSERT INTO gfs_users (login, password, email, role, created_at)
			VALUES ('{$login}', '{$password}', '{$email}', '{$role}', '{$date}')";

	// Execution de la requette
	$result = mysqli_query($db, $sql)
		or errorLog('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($db));
}

/**
* Vérifie que les champs du formulaire contienne une information
**/

if(isset($_POST['email'], $_POST['email'], $_POST['email'])){
	if(!empty($_POST['email']) && !empty($_POST['login']) && !empty($_POST['password'])){

var_dump($_POST);

		$email = $_POST['email'];
		$login = $_POST['login'];
		$password = sha1($_POST['password']);
		$role = $_POST['role'];

		// Requette pour vérifier que l'utilisateur ou l'email n'est pas déjà présent en base de données
		$sql = "SELECT login, email
				FROM gfs_users
				WHERE 1=1
				AND login = '{$login}'
				OR email = '{$email}'";

		// Execute la requette
		$result = mysqli_query($db, $sql)
			or errorLog('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($db));

		// Recupère les lignes de resultat qu'on passe à la vue via le tableau $list_user
		$list_user = array();
		while($row = mysqli_fetch_assoc($result)) {
			$list_user[] = $row;
		}

		// Compte le nombre de ligne que retourne la requette SQL
		$num_result = mysqli_num_rows($result);
		if($num_result > 0) {
			var_dump($list_user);
			// Test si l'email existe en bdd
			foreach ($list_user as $user) {
				foreach ($user as $k => $v) {
					if($v == $email){
						flash('warning', "L'adresse email ".$v." existe déjà en base de données !");
					}
				}
			}
			// Test si le login existe en bdd
			foreach ($list_user as $user) {
				foreach ($user as $k => $v) {
					if($v == $login){
						flash('warning', "Le login ".$v." est déjà existe déjà en base de données !");
					}
				}
			}
			redirect('register');	
		} else {
			addUserInDB($login,$email,$password,$role);
			flash('success', "L'enregistrement du nouvel utilisateur a réussi !");
			redirect('register');
		}

		// Auto login
		//login($login,$password);
			
	} else {
		flash('warning', "Un champ ou plus n'est pas rempli !");
	}
}

render('register', array(), true, false);
