<?php

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
      'example' => 'exampleCommand'
    ));
  }

  function onStart() {
    $userID = $this->getMessage()->{'from'}->{'id'};
    $this->getTelegram()->sendMessage($userID, 'Hello !');
  }

  function exampleCommand() {
    $userID = $this->getMessage()->{'from'}->{'id'};
    $this->getTelegram()->sendMessage($userID, 'Command for example.');
  }
}

 ?>
