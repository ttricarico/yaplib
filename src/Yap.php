<?php
class Yap {
  const MANIFEST = "manifest.json";
  private $path;
  private static $modules = array();

  public function __construct($path)  {
    $this->path = $path;
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
        if(array_key_exists($a, self::$modules))  {
          $sources = self::$modules[$a];
          foreach ($sources as $s)  {
            require_once($s);
          }
        }
      }
    }
  }

  private function readManifests()  {
    $dirs = self::getDirs($this->path);
    foreach($dirs as $d)  {
      $manifest = json_decode(file_get_contents($d .'/'. self::MANIFEST),true);
      $modname = $manifest["name"];
      self::$modules[$modname] = $manifest["src"];
      foreach(self::$modules[$modname] as &$s) {
        $s = $d . '/' . $s;
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
