<?php
if (basename($_SERVER['PHP_SELF']) == 'config.php') { header('HTTP/1.0 403 Forbidden'); die; }

define('TIMEZONE', 'Asia/Jerusalem');
define('AUTH_TOKEN', '865461164:AAG6F9tl0ewhfO41mmW0bP0pVPnyiV4r29g');
define('BASE_REQUEST_URI', 'start_bot');

define('DB_HOST', 'localhost');
define('DB_USER', 'YOUR_DB_USERNAME');
define('DB_PASS', 'YOUR_DB_PASSWORD');
define('DB_NAME', 'YOUR_DB_NAME');

define('TELEGRAM_SERVER_IP', '149.154.167.220');

?>
