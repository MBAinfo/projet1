<?php 

	/**
	 * Fonction qui permet d'afficher une notification pour l'utilisateur
	 * Ex: lors d'une identification ratée
	 * Type : "success", "warning", "danger", "info"
	 */
	function flash($type, $message)
	{
		$_SESSION['flashes'][] = array(
			'type' => $type,
			'message' => $message
		);
	}


	/**
	 * Retourne les flash en attente d'affichage et vide le conteneur
	 */
	function getFlashes() {
		$flashes = (isset($_SESSION['flashes'])) ? $_SESSION['flashes'] : array() ;
		unset($_SESSION['flashes']);
		return $flashes;
	}


	/**
	 * Fonction pour simplifier l'ecriture d'une redirection
	 */
	function redirect($page)
	{
		header('Location:' . url($page));
		die();
	}


	/**
	 * Fonction qui crée un chemin pour une action
	 * @param $action : le nom du controleur à vers lequel pointera l'URL
	 * @param $params : sert à rajouter des parametres à une url 
	 * (accepte uniquement un tableau du type ['argument' => 'valeur'])
	 * Si aucun paramètre n'est passé, on retourne l'URL de la page courante
	 */
	function url($action = null, $params = null) {

		/* traitement de la base de l'url
		 * On obtient une URL du type: "mba.olek.fr/action" */
		if ( isset($action) )
		{
			if ( WEBROOT == '/' )
				$url = '/'.$action;
			else
				$url = WEBROOT.'/'.$action;
		}
		else {
			$url = $_SERVER['REQUEST_URI'];
		}

		/* Ajout des parametres s'il y en a. 
		 * On obtient une URL du type: "mba.olek.fr/action?arg1=val1&arg2=val2&arg2=val2" */
		if ( isset($params) ) {

			$url .= "?";
			
			foreach ($params as $key => $value) {
				$url .= $key .'='. $value . '&';
			}
			$url = rtrim($url, "&");
		}
		return $url;
	}


	/**
	 * Fonction qui crée le chemin vers une ressource (ex: une image, un css...)
	 */
	function asset($asset) {
		return (WEBROOT == '/') ? WEBROOT.'/assets/'.$asset : WEBROOT.'/assets/'.$asset;
	}


	/**
	 * Fonction pour s'authentififier en tant qu'utilisateur (initialise $_SESSION['user'])
	 */
	function login($login, $mdp)
	{
		global $db;

		$mdp = sha1($mdp);
		// Requette SQL sur la table user des éléments sélectionnés
		$sql = "SELECT `login`, `email`, `password`, `role`
				FROM `gfs_users`
				WHERE login = '{$login}'
				AND password = '{$mdp}'
		";

		// Execution de la requête, sauf dans le cas où elle échoue : on affiche l'erreur
		$result = mysqli_query($db, $sql) 
			or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($result));


		if(mysqli_num_rows($result) === 1)
		{
			$user = mysqli_fetch_assoc($result);
			$_SESSION['user'] = array(
				'login' => $user['login'] ,
				'password' => $user['password'],
				'email' => $user['email'],
				'role' => $user['role']
			);
			return true;
		}
		return false;
	}


	/**
	 * Fonction pour vérifier si un utilisateur est connecté (retourne true ou false)
	 */
	function isLogged()
	{
		global $db;

		// Vérifie que si une session est initialisée
		if (isset($_SESSION['user']['login'], $_SESSION['user']['password'])) {
			// Recupère les données en session
			$login = $_SESSION['user']['login'];
			$mdp = $_SESSION['user']['password'];
			// Requette SQL sur la table user des éléments sélectionnés
			$sql = "SELECT `login`, `password`
					FROM `gfs_users`
					WHERE login = '".$login."'
					AND password = '".$mdp."'";

			// on lance la requête (mysql_query) et on impose un message d'erreur si la requête ne se passe pas bien (or die);
			$result = mysqli_query($db, $sql) 
				or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($result));

			// on va scanner tous les tuples un par un
			if(mysqli_num_rows($result) > 0) {
				return true;
			}
		}
		return false;
	}

	

	/**
	 * Fonction qui permet de déconnecter un user en vidant la variable de session 'user'
	 */
	function logout()
	{
		unset($_SESSION['user']);
	}



	/**
	 * Fonction qui parse le message et en extrait les hashtag
	 * @return un tableau contenant:
	 * 		'keywords' => un tableau contenant les hashtags
	 *		'message' => le message sans les hashtags
	 */
	function parseMessage($message)
	{
		// on enlève les caractères spéciaux pouvant amener une faille de sécurité
		$message = htmlspecialchars($message, ENT_QUOTES);

		// on trouve les mots clés défini par @ et #
		// Note: on autorise les lettres, les chiffres et les caractères spéciaux suivants: - et _
		preg_match_all('/@[a-z0-9\-\_]*/i', $message, $users);
		preg_match_all('/#[a-z0-9\-\_]*/i', $message, $hashtags);

		// on les rassemble dans un tableau commun
		$keywords = array_merge($users[0], $hashtags[0]);

		// on supprime tous les mots clé du message pour avoir juste le contenu
		foreach ($keywords as $value) {
			$message = str_replace($value, '', $message);
		}

		// on enlève les espaces de début et fin de chaine
		$message = trim($message);

		$ret = array(
			'keywords' => $keywords,
			'message'  => $message,
		);

		return $ret;
	}


	/**
	 * Fonction qui insère le message posté dans la bdd
	 */
	function postMessage($message)
	{
		global $db;
		// permet de sécuriser la chaine de caractere en enlevant les caracteres spéciaux
		$message = mysqli_real_escape_string($db, $message);

		// on ajoute le pseudo du user au début du message
		$message = '@'.$_SESSION['user']['login'].' : '.$message;

		// on ajoute le hashtag du projet dans lequel on poste le message (si il y en a un)
		if ( isset($_GET['action']) && isset($_GET['hashtag']) && $_GET['action'] == 'project') {
			$message .= ' #'.$_GET['hashtag'];
		}
		
		$sql = "INSERT INTO gfs_msg (message, created_at)
				VALUES('" . $message . "', '" . date('Y-m-d H:i:s') . "')";

		$result = mysqli_query($db, $sql)
			or errorLog('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($db));

		$last_id = mysqli_insert_id($db);
		
		$message = parseMessage($message);

		// on insere les hashtags dans la table 'hashtags'
		foreach ($message['keywords'] as $keyword) {
			$sql = "INSERT INTO gfs_hashtag (tag, id_message)
					VALUES('" . $keyword . "', '" . $last_id . "')";

			$result = mysqli_query($db, $sql)
				or errorLog('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($db));
		}
	}



	/**
	 * Gère les erreurs pour éviter de les afficher à l'utilisateur en mode production
	 */
	function errorLog($msg)
	{
		global $config;

		if ($config['app']['debug_mode']) {
			echo "<pre>";
			echo $msg;
			echo "</pre>";
			die();
		}
		else {
			$error_log = fopen('error.log', 'a+');
			fputs($error_log, $msg);
			fclose($error_log);
			redirect('error404');
		}
	}



	/**
	 * Récupère le titre du document dans un message de type #document
	 */
	function extractDocTitle($message)
	{
		$result = preg_match("/#document[\s]*([\S]+)/", $message, $matches);

		if($result)
			return $matches[1];
		else
			return 'error';
	}


	/**
	 * Rendu de la vue
	 * @param $view le nom de la vue à inclure
	 * @param $params array indexé contenant les variables à passer à la vue
	 * @param $layout détermine si le layout doit etre affiché
	 * @param $sidebar détermine si la sidebar doit etre affichée
	 */
	function render($view, $params = array(), $layout = true, $sidebar = true)
	{
		global $username;
		// on extrait les variable en parametre de leur tableau pour pouvoir y acceder directement
		extract($params);

		if (file_exists("app/views/{$view}.html")) 
		{
			if ($layout) {
?>

				<?php require_once "app/views/partials/header.html"; ?>
				
				<div id="content" class="<?= ($sidebar) ? 'col-xs-9' : 'col-xs-12' ; ?>">
					<?php require_once "app/views/{$view}.html"; ?>
				</div>
			
				<?php if ($sidebar): ?>
					<?php require_once "include/sidebar.php" ?>
					<div id="sidebar" class="col-xs-3">

						<?php require_once "app/views/partials/sidebar.html"; ?>
					
					</div>
				<?php endif ?>

				<?php require_once "app/views/partials/footer.html"; ?>

<?php
			}
			else {
				require_once "app/views/{$view}.html";
			}
		}
		else {
			$error_log = "La vue {$view} n'existe pas";
			require_once"app/views/error404.html";
		}
	}


	/**
	 * Fonction qui permet de transformer une chaine de caractère en slug
	 * Ex: "nom de fichié.txt" -> "nom-de-fichie.txt"
	 */
	function slugify($text)
	{
		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d\.]+~u', '-', $text);

		// trim
		$text = trim($text, '-');

		// transliterate
		if (function_exists('iconv')) {
		    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		}

		// lowercase
		$text = strtolower($text);

		// remove unwanted characters
		// $text = preg_replace('~[^-\w]+~', '', $text);

		if (empty($text)) {
		    return 'n-a';
		}

		return $text;
	}