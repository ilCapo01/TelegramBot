<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

define('SRC_PATH', ABSPATH . '/includes/src/');

ob_start();
include(ABSPATH . 'includes/config.php');
include(ABSPATH . 'includes/request.php');
include(ABSPATH . 'includes/telegram.php');
include(ABSPATH . 'includes/database.php');
include(ABSPATH . 'includes/bot.php');
// Your bot is loaded down here.
include(ABSPATH . 'includes/src/mybot.php');
ob_end_flush();

date_default_timezone_set(TIMEZONE);

ini_set("log_errors", 1);
ini_set("error_log", ERROR_LOG);

$bot = null;

try {
	// Your bot is initialized down here.
	$bot = new MyBot();
	$bot->onCommand(); // Returns boolean.
} catch (Exception $e) {
  error_log($e->getMessage());
}
$bot->db->close();

?>
