<?php
if (basename($_SERVER['PHP_SELF']) == 'telegram.php') die;

//include('database.php');
include ABSPATH . 'request.php';

// Documentation:
// https://core.telegram.org/bots/api/
// Exmple: YT/watch?v=gYQ0OmkVFSk
class Telegram {
  var $authToken;
  var $update;
  private $base_url = 'start_bot';
  var $db;

  function __construct($authToken, $db) {
    $this->authToken = $authToken;
    $this->update = $this->handle();
    $this->db = $db;
  }

  private function handle() {
    if ($_SERVER['REQUEST_URI'] == $this->base_url) {
      $json = json_decode(file_get_contents('php://input'));
      if (!is_object($json))
        throw new Exception('Couldn\'t read input.');
      return $json;
    }
    throw new Exception('Bad request.');
  }

  function requestLimiter($chat_id = 0) {
    $time = time();
    // Limit each chat \ user for X commands a minute.
  }

  function setCommand($command) {
    if (!isset($this->update) || is_null($this->update))
      return false;
    $text = strtolower($this->getMessage()->{'text'});

    return (substr($text, strpos($text, $command)) == $command);
  }

  function sendKeyboardMarkup($userID, $msg, $options = array()) {
	if (empty($msg))
	  throw new Exception('Text cannot remain empty.');
    global $request;
    $request->sendKeyboardMarkup($this->authToken, $userID, $msg, $options);
  }

  function sendMessage($userID, $msg) {
	if (empty($msg))
	  throw new Exception('Text cannot remain empty.');
    global $request;
    $request->sendMessage($this->authToken, $userID, $msg);
  }

  function sendPhoto($userID, $imagePath = '') {
	if (!file_exists($imagePath))
		throw new Exception($imagePath . ' doesn\'t exist.');
    global $request;
    $request->sendPhoto($this->authToken, $userID, $imagePath);
  }

  function getMessage() {
		return $this->update->{'message'};
	}
}


?>
