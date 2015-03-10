<?php

	// si on a des variables en POST, c'est qu'un message est envoyé
	// on va alors le traiter et l'inserer dans la db
	if (isset($_POST['message']))
	{
		postMessage($_POST['message']);
	}
	var_dump($_FILES);
	

       
      if ($_FILES['nom_du_fichier']['error']) {
            switch ($_FILES['nom_du_fichier']['error']){
            case 1: // UPLOAD_ERR_INI_SIZE
            echo"Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !";
            break;
            case 2: // UPLOAD_ERR_FORM_SIZE
            echo "Le fichier dépasse la limite autorisée dans le formulaire HTML !";
            break;
            case 3: // UPLOAD_ERR_PARTIAL
            echo "L'envoi du fichier a été interrompu pendant le transfert !";
            break;
            case 4: // UPLOAD_ERR_NO_FILE
            echo "Le fichier que vous avez envoyé a une taille nulle !";
            break;
            }
	}
	else 
    {
	       if ((isset($_FILES['nom_du_fichier']['tmp_name'])&&($_FILES['nom_du_fichier']['error'] == 0))) {  
         		   
                $chemin_destination = ROOT."\assets\\files\\";     
                move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], $chemin_destination.$_FILES['nom_du_fichier']['name']);  
				   postMessage("#document  ".$_FILES['nom_du_fichier']['name']);
				   $_FILES['nom_du_fichier']['error']=2;
				   var_dump($_FILES);
                }   
	}
    
    

      

	

	
	if (isset($_POST['document']))
	{
		postMessage($_POST['document']);
	}

	// on verifie qu'on a bien un projet en argument
	if ( !isset($_GET['hashtag']) ) {
		flash('warning', "Aucun projet sélectionné");
		redirect('user');
	}
	
	$tag = $_GET['hashtag'];

	$sql = "SELECT message, created_at
			FROM gfs_msg 
			WHERE id IN (
				SELECT id_message
				FROM gfs_hashtag 
				WHERE tag = '#{$tag}'
			)
			ORDER BY id DESC
	";

	$result = mysqli_query($db, $sql)
		or errorLog('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($db));

	// on verifie qu'on a bien un resultat (= le projet existe)
	if (mysqli_num_rows ( $result ) > 0) {
		// recuperation des lignes de resultat qu'on passe à la vue via le tableau $list_msg
		while($row = mysqli_fetch_array($result)) { 
			$list_msg[] = $row;
		}
	}
	else {
		flash('warning', "Le projet '{$tag}' n'existe pas");
		redirect('user');
	}

	$params = compact('tag', 'list_msg');
	render('project', $params);