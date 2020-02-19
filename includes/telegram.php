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

    if ($_SERVER['REMOTE_ADDR'] == TELEGRAM_SERVER_IP) { // $_SERVER['HTTP_HOST']
      header('HTTP/1.0 403 Forbidden');
      throw new Exception('Unfamiliar host tried to gain access.');
      die;
    }

    $rawData = stripslashes(file_get_contents('php://input'));
    $json = json_decode($rawData);
    if (!is_object($json)) {
      throw new Exception('Could not read input.');
      die;
    }
    return $json;
  }

  function antiSpam($chat_id = 0) {
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

  function getLocation() {
    $data = $this->getMessage();
    $loc = array(
      'longitude' => $data->{'location'}->{'longitude'},
  		'latitude' => $data->{'location'}->{'latitude'});
    return $loc;
  }

  function getMessage() {
		return $this->update->{'message'};
	}
}
?>
