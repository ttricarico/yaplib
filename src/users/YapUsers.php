<?php
/**
 * This is a very simple class to manage users. It should really only be used
 * for a temporary or non-secure user login.
 *
 * @requires YapSession
**/
class YapUsers implements UsersInterface {

  private $session;
  private $users = array();
  private $hash = 'sha512';

  public function __construct() {
    $this->session = yap('YapSession');
  }

  public function login($user, $password) {
    foreach($this->users as $u) {
      if($u[0] == $user && $u[1] == hash($this->hash, $password)) {
        $this->session->set('loggedin', true);
        return true;
      }
      else {
        return false;
      }
    }
  }

  public function logout() {
    $this->session->delete('loggedin');
  }
  public function isLoggedIn() {
    if($this->session->get('loggedin')) {
      return true;
    }
    else {
      return false;
    }
  }

  public function addUser($user, $password) {
    //honestly, we don't care if the password is already hashed. It's going to be hashed again.
    $this->users[] = array($user, hash($this->hash, $password));

  }
  public function addUsersByFile($filepath) {

  }
  public function listUsers() {
    $users = array();
    foreach($this->users as $u) {
      $users[] = $u[0]; //remove the passwords
    }
    return $users;
  }
}
