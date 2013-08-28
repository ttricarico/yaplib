<?php

interface CSRFInterface {
  public function addToken();
  public function validateForm($formData);
  public function validateToken($tokenName, $tokenValue);
  public function generateToken($tokenName);
}
