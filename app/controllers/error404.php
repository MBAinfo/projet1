<?php 

	$error = '@error : la page que vous essayez d\'afficher a démissonnée! <br>#pas_de_bol #essaye_encore';
	
	$params = compact('error');
	render('error404', $params);