<?php
if (basename($_SERVER['PHP_SELF']) == 'request.php') { header('HTTP/1.0 403 Forbidden'); die; }

define('BASE_URL', 'https://api.telegram.org/bot');

// https://core.telegram.org/bots/api/
class Request {

  // https://core.telegram.org/bots/api/#replykeyboardmarkup
  function sendKeyboardMarkup($authToken, $userID, $msg, $options = array()) {
    $url = BASE_URL . $authToken . '/sendMessage';

    $keyboard = '';
    $len = count($options);
    for ($i=0; $i<$len; $i++)
    {
      if ($i < $len-1) {
        $keyboard .= '["'.$options[$i].'"],';
      }else{
        $keyboard .= '["'.$options[$i].'"]';
      }
    }

    return $this->requests($url, 'POST', array(
      'chat_id' => $userID, 'text' => $msg,
      'reply_markup' => '{"keyboard":['.$keyboard.']}'
    ), array(
      'Content-Type: application/x-www-form-urlencoded'
    ));
  }

  // https://core.telegram.org/bots/api/#sendmessage
  function sendMessage($authToken, $userID, $msg) {
    $url = BASE_URL . $authToken . '/sendMessage';

    return $this->requests($url, 'POST', array(
      'chat_id' => $userID, 'text' => $msg
    ), array(
      'Content-Type: application/x-www-form-urlencoded'
    ));
  }

  //https://core.telegram.org/bots/api/#sendphoto
  function sendPhoto($authToken, $userID, $imagePath = '') {
    $url = BASE_URL . $authToken . '/sendPhoto';

    // https://stackoverflow.com/a/32296353
    return $this->requests($url, 'POST', array(
      'chat_id'   => $userID,
      'photo' => new CURLFile(realpath($imagePath)) //$this->encodeFile($imagePath)
    ), array(
      'Content-Type: multipart/form-data'
    ));
  }

  private function encodeFile($file) {
	  $fp = fopen($file, 'rb');
	  if ($fp === false)
		  throw new Exception('Cannot open ' . $file . ' for reading.');
	  $raw = fread($fp, filesize($file));
	  fclose($fp);
	  return $raw; // base64_encode($raw);
  }

  private function requests($url, $method = 'GET', $params = array(), $headers = array()) {
  	$ch = curl_init();

    // Save bandwidth:
    // https://stackoverflow.com/questions/5699020/php-manual-gzip-encoding#5701631

  	curl_setopt($ch, CURLOPT_URL, $url . ($method == 'GET' ? '?' . http_build_query($params) : ''));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  	curl_setopt($ch, CURLOPT_POST, ($method == 'POST' ? 1 : 0));
  	if ($method == 'POST')
  		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  	$server_output = curl_exec($ch);

  	curl_close ($ch);

  	return $server_output;
  }
}
?>
