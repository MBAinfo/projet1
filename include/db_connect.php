<?php

	// Connexion au serveur MySQL
	$db = new mysqli(
		$config['db']['hostname'],
		$config['db']['user'], 
		$config['db']['password'], 
		$config['db']['nom_base_donnees']
	);
	// Vérifie si la connexion à la base de données est effective
	if ($db->connect_errno) {
	    echo "Echec lors de la connexion à MySQL : " . $db->connect_error;
	}
