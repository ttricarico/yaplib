<?php
class Yap {
  const MANIFEST = "manifest.json";
  private $path;
  public static $availible_modules = array();
  public static $loaded_modules = array();

  public function __construct($path=null)  {
    if($path) {
      $this->path = $path;
    }
    else  {
      $this->path = dirname(__FILE__) . '/';
    }
    $this->readInterfaces();
    $this->readManifests();
  }

  public function getPath() {
    return $this->path;
  }

  /* this might be a cool way to load yap modules
      and other php files.  providing a minimal 
      manifest/dependency framework of some kind for yap
      and other php files might be nice
  */
  public function load()  {
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
}

function yap($module=null) {
  static $yap;
  static $mods;
  if ($yap === null)  {
    $yap = new Yap();
  }
  if ($mods === null) {
    $mods = array();
  }
  if ($module === null) {
    return $yap;
  }
  // autoload module
  if(!in_array($module, Yap::$loaded_modules)) {
    if (array_key_exists($module, Yap::$availible_modules)) {
      $yap->load($module);
    }
  }
  // create a module object
  if(!array_key_exists($module, $mods))  {
      $mods["$module"] = new $module();
  }
  return $mods["$module"];
}
