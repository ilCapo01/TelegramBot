<?php
if (basename($_SERVER['PHP_SELF']) == 'mybot.php') { header('HTTP/1.0 403 Forbidden'); die; }

/**
 * TG BOT API:
 * https://core.telegram.org/bots/api
 */
class MyBot extends Bot {

  function __construct()
  {
    parent::__construct();
  }

  function onCommand()
  {
    return parent::onCommand($this, array(
      '/start' => 'onStart',
      'example' => 'onExampleCommand'
    ));
  }

  function onStart() {
    $this->getTelegram()->sendMessage($this->getUserID(), 'Hello !');
  }

  function onExampleCommand() {
    $this->getTelegram()->sendMessage($this->getUserID(), 'Command for example.');
  }
}

 ?>
