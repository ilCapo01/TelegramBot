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
    parent::onCommand($this, array(
      'hello' => 'onHelloMessage'
    ));
    return false;
  }

  function onHelloMessage() {
    
  }
}

 ?>
