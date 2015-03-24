<?php

	class ListMessage 
	{
		private $messages = array();
		private $filtres = array();

		public ListMessage() {

		}

		/**
		 * Ajoute un filtre à la liste de filtres
		 */
		public addFilter($newFiltre) {
			$messages[] = $newFiltre
		}

		/**
		 * Applique les filtres et retourne la liste de messages
		 */
		public getList() {
			return $messages;
		}
	}