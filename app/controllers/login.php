<?php 

	if(isset($_POST['login'], $_POST['mdp'])) 
	{
		$login = $_POST['login'];
		$mdp = $_POST['mdp'];

		if( login($login, $mdp) ) {
			flash('success', 'Vous êtes maintenant connecté');
			redirect('user');
		} else {
			flash('danger', 'Identifiant ou Mot de passe incorrect');
		}
	}

	render('login', array(), true, false);
