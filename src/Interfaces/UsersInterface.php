<?php

interface UsersInterface {
  public function login();
  public function logout();
  public function isLoggedIn();
  public function addUser();
}
