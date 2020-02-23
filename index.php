<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

ob_start();
include(ABSPATH . 'includes/config.php');
include(ABSPATH . 'includes/request.php');
include(ABSPATH . 'includes/telegram.php');
include(ABSPATH . 'includes/database.php');
include(ABSPATH . 'includes/bot.php');
// Your bot is loaded down here.
include(ABSPATH . 'includes/mybot.php');
ob_end_flush();

date_default_timezone_set(TIMEZONE);

ini_set("log_errors", 1);
ini_set("error_log", ERROR_LOG);

try {
	// Your bot is initialized down here.
	$bot = new MyBot();
} catch (Exception $e) {
  error_log($e->getMessage());
}

?>
