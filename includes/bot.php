<?php

class Bot {
  protected $tg = null;
  protected $db = null;

  function __construct() {
    try {
      $db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      $tg = new Telegram(new Request(AUTH_TOKEN), $db);

      $msg = $tg->getMessage(); // The whole packet from the user.

      if (!is_null($msg))
        $this->onCommand($msg);

    } catch (Exception $e) {
      throw $e;
    }
    $this->db->close();
  }

  protected function onCommand($cmd = '')
  {
    return false;
  }

}

 ?>
