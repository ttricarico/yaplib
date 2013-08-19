<?php 
class YapEnv {

  const DEVELOPMENT = 1;
  const PRODUCTION = 2;

  private $mode;

  public function __construct()  {}

  public function set($mode = 2)  {
    $this->mode = $mode;
    switch($this->mode) {
      case self::DEVELOPMENT:
        $this->development();
        break;

      case self::PRODUCTION:
        $this->production();
        break;

      default:
        set(self::PRODUCTION);
        break;
    }
  }

  public function getMode() {
    switch($this->mode) {
      case self::DEVELOPMENT:
        return "Development";
      case self::PRODUCTION:
        return "Production";
      default:
        return "Server Default";
    }
  }

  public function setDev()  {
    $this->set(self::DEVELOPMENT);
  }

  public function setPro()  {
    $this->set(self::PRODUCTION);
  }

  /* todo: also add catches for other kinds of errors like database */

  private function development()  {
    error_reporting(-1);
  }

  private function production() {
    error_reporting(0);
  }

}

