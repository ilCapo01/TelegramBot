<?php

class MyBot extends Bot {

  function __construct()
  {
    parent::__construct();
  }

  protected function onCommand($cmd = '')
  {
    $tg = $this->tg;

    $chat_id = $tg->getChatID();
    $text = $tg->getText();

    // Start command.
	  if ($tg->setCommand('/start'))
	  {
			// Send the keyboard.
		  $tg->sendKeyboardMarkup($chat_id, 'Hello, ' .
			$message->{'from'}->{'first_name'} . ' ' .
			$message->{'from'}->{'last_name'} . '.', array(
				'Option #1', 'Option #2', 'Option #3'
		  ));
	  }
		else if ($tg->setCommand('Option #1'))
		{
			$tg->sendMessage($chat_id, 'You picked Option #1');
		}
		else if ($tg->setCommand('Option #2'))
		{
			$tg->sendMessage($chat_id, 'You picked Option #2');
		}
		else if ($tg->setCommand('Option #3'))
		{
			$tg->sendMessage($chat_id, 'You picked Option #3');
		}

    return parent::onCommand($cmd);
  }

}

 ?>
