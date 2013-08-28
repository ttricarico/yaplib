<?php

interface CookieInterface {
  public function set($name, $value, $expiretime = 0);
  public function delete($name);
  public function get($name);
  public function deleteAll();
}
