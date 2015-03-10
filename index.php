<?php 

	// on defini une constante qui stocke la racine de l'URL pour s'en resservir dans l'application
	// notamment dans les vues pour afficher des liens (ici 'http://mba.olek.fr/projet')
	define('WEBROOT', dirname($_SERVER['SCRIPT_NAME']));
	define('ROOT', dirname(__FILE__));

	// on inclu les fichiers dont on aura besoin dans toutes les pages
	require_once 'include/config.php';
	require_once 'include/db_connect.php';
	require_once 'include/session.php';
	
	require_once 'include/functions.php';
	require_once 'include/auth.php';


	/**
	 * Dispatcher
	 * Mécanisme qui inclu le controlleur correspondant à l'URL demandée
	 */
	if (isset($_GET['action'])) {
		
		$ctrl = $_GET['action'];

		if (file_exists('app/controllers/'.$ctrl.'.php')) {
			$view = $ctrl;
			require_once'app/controllers/'.$ctrl.'.php';
		}
		else {
			$view = 'error404';
			require_once'app/controllers/error404.php';
		}
	}
	else {
		$view = 'user';
		require_once'app/controllers/user.php';
	}


	/** 
	 * Le code qui gère le rendu de la vue a été déplacé dans la fonction render()
	 * pour faciliter la gestion du rendu en ajax (= sans le layout)
	 * il faudra donc maintenant appeler cette fonction à la fin de chacuns de nos controlleurs
	 **/