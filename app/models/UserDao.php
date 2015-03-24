<?php

  global $db;

  class UserDao {

    /**
     * Enregistre un nouvel utilisateur en base
     */
    public function insert(User $user) {

      $login    = $user->getLogin();
      $password = $user->getPassword();
      $email    = $user->getEmail();
      $role     = $user->getRole();
      $date     = date('Y-m-d');

      $sql = "INSERT INTO gfs_users (login, password, email, role, created_at)
              VALUES ('{$login}', '{$password}', '{$email}', '{$role}', '{$date}')";

      $result = $db->query($sql)
        or die('Erreur SQL : '.$db->error);
    }

    /**
     * Modifie les infos d'un User dans la db
     */
    public function update(User $user) {
      // todo..
    }

    /**
     * Supprime un User de la base de donnée
     */
    public function delete(User $user) {

      $sql = "DELETE FROM gfs_users
              WHERE login = " . $user->getLogin();

      $result = $db->query($sql)
        or die('Erreur SQL : '.$db->error);
    }

    /**
     * Récupère les infos d'un User en base à partir de son login
     */
    public function select($login) {

      $sql = "SELECT id, login, password, email, role, created_at FROM gfs_users
              WHERE login = {$login}";

      $resultSet = $db->query($sql)
        or die('Erreur SQL : '.$db->error);

      $user_info = $resultSet->fetch_all(MYSQLI_ASSOC);

      $user = new User();

      $user->setLogin($user_info['login']);
      $user->setEmail($user_info['email']);
      $user->setPassword($user_info['password']);
      $user->setRole($user_info['role']);

      return $user;
    }





    public function login($login, $pass) {

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