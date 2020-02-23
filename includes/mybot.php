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
    // File: includes\telegram.php. Line: 49.
    $msg = $this->getMessage();
    // File: includes\telegram.php
    $tg = $this->getTelegram();

    $chat_id = $msg->{'chat'}->{'id'};

    // Start command.
	  if (parent::onCommand('/start'))
	  {
			// Send the keyboard.
		  $tg->sendKeyboardMarkup($chat_id, 'Hello, ' .
			$msg->{'from'}->{'first_name'} . ' ' .
			$msg->{'from'}->{'last_name'} . '.', array(
				'Option #1', 'Option #2', 'Option #3'
		  ));
      return true;
	  }
		else if (parent::onCommand('Option #1'))
		{
			$tg->sendMessage($chat_id, 'You picked Option #1');
      return true;
		}
		else if (parent::onCommand('Option #2'))
		{
			$tg->sendMessage($chat_id, 'You picked Option #2');
      return true;
		}
		else if (parent::onCommand('Option #3'))
		{
			$tg->sendMessage($chat_id, 'You picked Option #3');
      return true;
		}
    return false;
  }
}

 ?>
