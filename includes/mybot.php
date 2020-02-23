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
    // https://core.telegram.org/bots/api#message
    $chat_id = $this->msg->{'chat'}->{'id'};

    // Start command.
	  if (parent::onCommand('/start'))
	  {
			// Send the keyboard.
		  $tg->sendKeyboardMarkup($chat_id, 'Hello, ' .
			$message->{'from'}->{'first_name'} . ' ' .
			$message->{'from'}->{'last_name'} . '.', array(
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
