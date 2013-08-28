<?php
interface RouterInterface {
  public function get($path, $callback, $json);
  public function post($path, $callback, $json);
  public function put($path, $callback, $json);
  public function delete($path, $callback, $json);
  public function run($path, $httpMethod);
}
