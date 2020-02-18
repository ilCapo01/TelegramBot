<?php
if (basename($_SERVER['PHP_SELF']) == 'telegram.php') { header('HTTP/1.0 403 Forbidden'); die; }

// /watch?v=gYQ0OmkVFSk
class Telegram {
  var $request = null;
  var $update;
  var $db;

  function __construct($request, $db) {
    $this->request = $request;
    $this->update = $this->handle();
    $this->db = $db;
  }

  // https://core.telegram.org/bots/api/#message
  private function handle() {
    if ($_SERVER['REQUEST_URI'] != BASE_REQUEST_URI) {
      throw new Exception('Bad request.');
    }
    if ($_SERVER['HTTP_HOST'] == TELEGRAM_SERVER_IP) {
      header('HTTP/1.0 403 Forbidden');
      throw new Exception('Unfamiliar host tried to gain access.');
      die;
    }

    $json = json_decode(file_get_contents('php://input'));
    if (!is_object($json)) {
      throw new Exception('Could not read input.');
      die;
    }
    return $json;
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
    $request->sendKeyboardMarkup($userID, $msg, $options);
  }

  function sendMessage($userID, $msg) {
	if (empty($msg))
	  throw new Exception('Text cannot remain empty.');
    $request->sendMessage($userID, $msg);
  }

  function sendPhoto($userID, $imagePath = '') {
	if (!file_exists($imagePath))
		throw new Exception($imagePath . ' doesn\'t exist.');
    $request->sendPhoto($userID, $imagePath);
  }

  function getMessage() {
		return $this->update->{'message'};
	}
}
?>
