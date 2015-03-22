<?php

	// on verifie qu'on a bien un projet en argument de l'url
	if ( !isset($_GET['hashtag']) ) {
		flash('warning', "Aucun projet sélectionné");
		redirect('user');
	}

	/**
	 * Gestion des uploads de documents
	 */

	if (isset($_FILES['file']))
	{
		if ($_FILES['file']['error'])
		{
			switch ($_FILES['file']['error'] != 0)
			{
	            case 1: // UPLOAD_ERR_INI_SIZE
		            flash("warning", "Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !");
		            break;
	            case 2: // UPLOAD_ERR_FORM_SIZE
		            flash("warning", "Le fichier dépasse la limite autorisée dans le formulaire HTML !");
		            break;
	            case 3: // UPLOAD_ERR_PARTIAL
		            flash("warning", "L'envoi du fichier a été interrompu pendant le transfert !");
		            break;
	            case 4: // UPLOAD_ERR_NO_FILE
		            flash("warning", "Le fichier que vous avez envoyé a une taille nulle !");
		            break;
			}
		}
		else 
	    {
			if ((isset($_FILES['file']['tmp_name']) && ($_FILES['file']['error'] == 0)))
			{
				$upload_path = ROOT."\uploads";
				$filename = slugify($_FILES['file']['name']);
				move_uploaded_file($_FILES['file']['tmp_name'], $upload_path . "\\" . $filename);
				postMessage("#document ".$filename);
			}   
		}
	}
	

	/**
	 * Traitement du message posté
	 */
	
	if (isset($_POST['message']))
	{
		postMessage($_POST['message']);
	}
	
	$project = $_GET['hashtag'];

	$sql = "SELECT message, created_at
			FROM gfs_msg 
			WHERE id IN (
				SELECT id_message
				FROM gfs_hashtag 
				WHERE tag = '#{$project}'
			)
			ORDER BY id DESC
	";

	$result = $db->query($sql)
		or errorLog('Erreur SQL !<br />'.$sql.'<br />'.$db->error);

	// on verifie qu'on a bien un resultat (= le projet existe)
	if ($result->num_rows > 0) {
		// recuperation des lignes de resultat qu'on passe à la vue via le tableau $list_msg
		while($row = $result->fetch_assoc()) { 
			$list_msg[] = $row;
		}
	}
	else {
		flash('warning', "Le projet '{$tag}' n'existe pas");
		redirect('user');
	}

	$params = compact('project', 'list_msg');
	render('project', $params);