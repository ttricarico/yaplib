<?php

interface HeaderInterface {
  public static function sendHTTPResponse($response);
  public static function sendContentType($type);
  public static function sendCustomHeader($header);
}
