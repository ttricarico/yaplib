<?php

interface UsersInterface {
  public function login($user, $password);
  public function logout();
  public function isLoggedIn();
  public function addUser($user, $password);
}
