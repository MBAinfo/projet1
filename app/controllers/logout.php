<?php 

	logout();

	flash('info', 'Vous êtes maintenant déconnecté');

	redirect('login');