<?php
class Yap {
  private $path;
  private static $modules = array('Router');

  public function __construct($path)  {
    $this->path = $path;
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
        $file = $a;
        if(in_array($a, self::$modules))  {
          $file = $this->path . $a . ".php";
        }
        require_once($file);
      }
    }
  }

}
