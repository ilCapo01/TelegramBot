<?php
if ( !defined('ABSPATH'))
	define('ABSPATH', dirname(__FILE__) . '/');

define('TIMEZONE', 'Asia/Jerusalem');

define('DB_HOST', 'localhost');
define('DB_USER', 'YOUR_DB_USERNAME');
define('DB_PASS', 'YOUR_DB_PASSWORD');
define('DB_NAME', 'YOUR_DB_NAME');

ini_set("log_errors", 1);
ini_set("error_log", ABSPATH . 'php-error.log');

date_default_timezone_set(TIMEZONE);

include(ABSPATH . 'includes/telegram.php');
include(ABSPATH . 'includes/database.php');

$authToken = '865461164:AAG6F9tl0ewhfO41mmW0bP0pVPnyiV4r29g';

try {

	$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  $tg = new Telegram($authToken, $db);
  $message = $tg->getMessage();

  $chat_id = $message->{'chat'}->{'id'};
  $text = $message->{'text'};

  $userName = $message->{'from'}->{'first_name'} . ' ' . $message->{'from'}->{'last_name'};

  // Log the user's request timestamp.
  $chat = $tg->db->insertUser($chat_id);

  if ($tg->setCommand('/start'))
  {
		// TODO: The user doesnt receive the image.
		$tg->sendPhoto($chat_id, 'D4jmpIlU0AAhMY9.png');

		$welcome = 'Hello, ' . $userName . '.';
		// Send the keyboard.
	  $tg->sendKeyboardMarkup($chat_id, $welcome, array(
			'Option #1', 'Option #2', 'Option #3'
	  ));
  }
	else if ($tg->setCommand('Option #1')) {
		$tg->sendMessage($chat_id, 'You picked Option #1');
	}
	else if ($tg->setCommand('Option #2')) {
		$tg->sendMessage($chat_id, 'You picked Option #2');
	}
	else if ($tg->setCommand('Option #3')) {
		$tg->sendMessage($chat_id, 'You picked Option #3');
	}

} catch (Exception $e) {
  error_log($e->getMessage());
}

?>
