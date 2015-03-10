<?php 

	$allowed_pages = array(
		'login',
		'register',
	);

	/**
	 * A chaque page (autre que celles définies dans le tableau $allowed_pages),
	 * on teste si l'utilisateur est bien connecté.
	 * Si oui: on le laisse afficher la page qu'il souhaite
	 * Si non: on le redirige vers la page ou il doit s'identifier
	 */
	if (isset($_GET['action'])) {
		$page = $_GET['action'];
	}
	else {
		$page = 'user';
	}

	if ( !in_array($page, $allowed_pages) && !isLogged() ) {
		redirect('login');
	}

	$username = (isset($_SESSION['user']['login'])) ? $_SESSION['user']['login'] : 'Anonymous' ; 
