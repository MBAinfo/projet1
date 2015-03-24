<?php

	class ListMessageDAO
	{
		private $listMessage;
		private $db;

		public ListMessage($db, $listMessage) {
			$this->listMessage = $listMessage;
			$this->db = $db;
		}

		public read() {

			$sql = "SELECT *
					FROM gfs_msg
					WHERE id IN (
						SELECT id 
						FROM gfs_hashtag
						WHERE 1=1 
			";

			foreach ($listMessage as $key => $value) {
				$sql += "AND tag = '{$value}' "
			}

			$sql += ")";

		}
	}