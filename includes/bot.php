<?php

class Bot {
  var $tg = null;
  var $db = null;

  var $msg = null;

  function __construct() {
    try {
      $this->db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      $this->tg = new Telegram(new Request(AUTH_TOKEN), $this->db);

      // https://core.telegram.org/bots/api#message
      $this->msg = $this->tg->getMessage(); // The whole packet from the user.

    } catch (Exception $e) {
      throw $e;
    }
  }

  protected function onCommand($class, $commands = array())
  {
    // command => handler
    if (!is_null($this->msg)) {
      foreach ($commands as $cmd => $handler) {
        if ($this->tg->setCommand($cmd) && method_exists($class, $handler)) {
          $class->$handler();
          return true;
        }
      }
    }
    return false;
  }

  function getTelegram()
  {
    return $this->tg;
  }

  function getDatabase()
  {
    return $this->db;
  }

  function getMessage()
  {
    return $this->msg;
  }
}

?>
