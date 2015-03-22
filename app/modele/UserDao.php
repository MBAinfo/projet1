<?php
//**Class UserDao**//

class UserDao {

  public function login($login, $pass) {
    user$ = null;

    // Requette SQL sur la table user des éléments sélectionnés
    $sql = "SELECT `login`, `password`, `role`
        FROM `gfs_users`
        WHERE login = '".$login."'
        AND password = '".sha1($mdp)."'";

    // Execution de la requête, sauf dans le cas où elle échoue : on affiche l'erreur
    $result = $db->query($sql)
      or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($result));

    if($result->num_rows > 0) {
      /*$_SESSION['user'] = array(
        'login' => $login ,
        'password' => sha1($mdp),
        'role' => $role
      );*/
        //$user = new User();
        //$user->setId($result['id'];

    }

}



?>
