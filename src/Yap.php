<?php
class Yap {
  const MANIFEST = "manifest.json";
  private $path;
  public static $availible_modules = array();
  public static $loaded_modules = array();
  public $registered_modules;
  
  public function __construct($path=null)  {
    if($path) {
      $this->path = $path;
    }
    else  {
      $this->path = dirname(__FILE__) . '/';
    }
    $this->readInterfaces();
    $this->readManifests();
    $this->registered_modules = array();
  }

  public function getPath() {
    return $this->path;
  }

  // load the files specified by the manifest
  public function load(/*named modules*/)  {
    $args = func_get_args();
    if (!empty($args))  {
      foreach($args as $a)  {
        // load if availible and not already loaded
        if((array_key_exists($a, self::$availible_modules)) and (!in_array($a,self::$loaded_modules)))  {
          $sources = self::$availible_modules[$a];
          self::$loaded_modules[] = $a;
          foreach ($sources as $s)  {
            require_once($s);
          }
        }
      }
    }
  }

  private function readInterfaces() {
    $interfaceDir = $this->path . "Interfaces/";
    $files = glob($interfaceDir . '*.php');
    foreach($files as $i) {
      require_once($i);
    }
  }

  private function readManifests()  {
    $dirs = self::getDirs($this->path);
    foreach($dirs as $d)  {
      $manfile = $d . '/' . self::MANIFEST;
      if (file_exists($manfile) === true)  {
        $manifest = json_decode(file_get_contents($d .'/'. self::MANIFEST),true);
        $modname = $manifest["name"];
        self::$availible_modules[$modname] = $manifest["src"];
        foreach(self::$availible_modules[$modname] as &$s) {
          $s = $d . '/' . $s;
        }
      }
    }
  }

  private static function getDirs($path)  {
    $files = scandir($path);
    $dirs = array();
    foreach($files as $f) {
      $np = $path . $f;
      if ($f === "." or $f === "..") continue;
      if (is_dir($np)) {
        $dirs[] = $np;
      }
    }
    return $dirs;
  }
  
  public function getInstance($name)  {
    if(!array_key_exists($name, $this->registered_modules)) {
      return null;
    }
    return $this->registered_modules[$name];
  }

  public function register($instance_name, $object) {
    if(!array_key_exists($instance_name, $this->registered_modules))
      $this->registered_modules[$instance_name] = $object;
    return $object;
  }
  
  public function unregister($instance_name) {
    if(!array_key_exists($instance_name, $this->registered_modules))
      return false;
    
    unset($this->registered_modules[$instance_name]);
    return true;
  }

  /**
    destruct should be called implictly at the end of the request
  */
  public function __destruct()  {
    $this->end();
  }

  /** 
    if you want to explicitly unset all registered_modules, you can 
    call yap()->end().
    implement __destruct in your module, and it will be called from here.
  */
  public function end() {
    //echo count($this->registered_modules);
    foreach ($this->registered_modules as $k=>&$o) { 
      //print_r($k  . "=>"); print_r($o);
      unset($o);
    }
    unset($this->registered_modules);
    $this->registered_modules = array();
  }
  
}

function yap($module=null, $name=null) {
  static $yap;
  
  if ($yap === null)  {
    $yap = new Yap();
  }

  // if just yap() was called, just give yap.
  if ($module === null) {
    return $yap;
  }

  // autoload module
  if(!in_array($module, Yap::$loaded_modules)) {
    if (array_key_exists($module, Yap::$availible_modules)) {
      $yap->load($module);
    }
  }
  
  // if we are naming a new instance
  if($name !== null) {
    $yap->register($name, new $module());
    return $yap->getInstance($name);
  }

  // we are not naming the instance,
  // so we are getting a 'singleton' instance
  // we'll just name it by the class name
  $object = $yap->getInstance($module);
  if ($object === null) {
    $object = $yap->register($module, new $module());
  } 
 
  return $object;
}
