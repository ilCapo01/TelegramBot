<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

ob_start();
include(ABSPATH . 'includes/config.php');
include(ABSPATH . 'includes/request.php');
include(ABSPATH . 'includes/telegram.php');
include(ABSPATH . 'includes/database.php');
ob_end_flush();

date_default_timezone_set(TIMEZONE);

ini_set("log_errors", 1);
ini_set("error_log", ABSPATH . 'php-error.log');

$db = null;

try {

	$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  $tg = new Telegram(AUTH_TOKEN, $db);

	// https://core.telegram.org/bots/api/#message
  $message = $tg->getMessage();

  $chat_id = $message->{'chat'}->{'id'};
  $user_id = $message->{'from'}->{'id'};
  $user_name = '@'.$message->{'from'}->{'username'};
  $text = $message->{'text'};

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

} catch (Exception $e) {
  error_log($e->getMessage());
}
$db->close();

?>
