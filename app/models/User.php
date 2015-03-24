<?php

class User
{
  //Attributs
  private $id;
  private $login;
  private $email;
  private $password;
  private $role;

  //Getters
  public function getLogin() {
    return $this->login;
  }

  public function getPassword() {
    return $this->password;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getRole() {
    return $this->role;
  }

  //Setters
  public function setLogin($login) {
    $this->login = $login;
  }

  public function setPassword($password) {
    $this->password = $password;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  public function setRole($role) {
    $this->role = $role;
  }

}