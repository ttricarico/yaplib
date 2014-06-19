<?php
class YapRouter implements RouterInterface {
  const httpGet = 'GET';
  const httpPost = 'POST';
  const httpPut = 'PUT';
  const httpDelete = 'DELETE';

  private $routeKey = '__route__';
  private $routes = array();
  private $regexes = array();

  public function __construct() {
    if (func_num_args() === 1)  {
      $this->routeKey = func_get_arg(0);
    }
  }

  public function get($path, $callback, $json = false)  {
    $this->addRoute($path, $callback, self::httpGet, $json);
  }

  public function post($path, $callback, $json = false) {
    $this->addRoute($path, $callback, self::httpPost, $json);
  }


  public function put($path, $callback, $json = false) {
    $this->addRoute($path, $callback, self::httpPut, $json);
  }


  public function delete($path, $callback, $json = false) {
    $this->addRoute($path, $callback, self::httpDelete, $json);
  }

  public function run($path = false, $httpMethod = null) {
    if ($path === false) {
      $path = isset($_REQUEST[$this->routeKey]) ? $_REQUEST[$this->routeKey] : '/';
    }
    if ($httpMethod === null) {
      $httpMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : self::httpGet;
    }

    $route = $this->getRoute($path, $httpMethod);
    // anything that echo's will be buffered
    // need to decide a common workflow/model for
    // 'echo' vs. 'return'
    ob_start();
    $response = call_user_func_array($route['callback'], $route['arguments']);
    $data = ob_get_contents();
    ob_end_clean();

    // Could call prepared header functions here before callback output

    if ($route['json'] === true)  {
      $response = json_encode($response);
      if (isset($_GET['callback'])) { // jsonp
        $response = "{$_GET['callback']}($response)";
      }
      header('Content-Length:' . strlen($response));
      echo $response;
    }
    else {
      echo $data;
      return $response;
    }
  }

  public function getRouteTable() {
    $r = $this->routes;
    return $r; // this is a copy
  }

  public function getPath() {
    $path = isset($_REQUEST[$this->routeKey]) ? $_REQUEST[$this->routeKey] : '/';
    foreach($this->regexes as $i=>$regex) {
      if(preg_match($regex, $path, $arguments)) {
        return $arguments[0];
      }
    }
  }

  private function getRoute($path = false, $httpMethod = null) {
    foreach ($this->regexes as $i => $regex) {
      if (preg_match($regex, $path, $arguments)) {
        array_shift($arguments);
        $def = $this->routes[$i];
        if ($httpMethod != $def['httpMethod']) {
          continue;
        }
        // checking Class::Method
        else if(is_array($def['callback']) && method_exists($def['callback'][0], $def['callback'][1]))
        {
          $a = $def; // array is copied
          $a['arguments'] = $arguments;
          return $a;
        }
        // checking Method
        else if(function_exists($def['callback']))
        {
          $a = $def;
          $a['arguments'] = $arguments;
          return $a;
        }
        throw new Exception('Could not call method ' . $def['callback']);
      }
    }
    throw new Exception('Could not find route ' . $path);
  }

  private function addRoute($path, $callback, $method, $json) {
    $this->routes[] = array(  'httpMethod'=>$method,
                              'path'=>$path,
                              'callback'=>$callback,
                              'json'=>$json);
    $this->regexes[] = "#^{$path}\$#";
  }
}
