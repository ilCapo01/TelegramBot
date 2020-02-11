<?php
if (basename($_SERVER['PHP_SELF']) == 'database.php') { header('HTTP/1.0 403 Forbidden'); die; }

class Database {
	private $pdo = null;

	public static $host = 'localhost', $user = 'root', $pword = '', $dbname = '';

	function __construct($host, $user, $pass, $dbname) {
		$this->openConnection(array(
			'db' => $dbname, 'host' => $host, 'user' => $user, 'password' => $pass
		));
	}

	function openConnection($opt = array()) {
		try {
			if (!empty($opt) || count($opt) == 4) {
				if ((is_null($opt['db']) || empty($opt['db'])) ||
				(is_null($opt['host']) || empty($opt['host'])) ||
				(is_null($opt['user']) || empty($opt['user'])) ||
				(is_null($opt['password']) || empty($opt['password']))) {
					throw new Exception('Cannot connect to the database');
				}
				$this->pdo = new PDO('mysql:dbname='.$opt['db'].';host='.$opt['host'], $opt['user'], $opt['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			}else{
				$this->pdo = new PDO('mysql:dbname='.self::db.';host='.self::host, self::user, self::pword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			}
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		} catch (PDOException $e) {
			die ($e->getMessage());
		}
	}

	function close() {
		$this->pdo = null;
	}

	function prepare($sql, $val = array()) {
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($val);
		return $stmt;
	}

	function getTotalRows($table) {
		$stmt = $this->prepare('SELECT COUNT(*) AS count FROM ?');
		$stmt->execute(array($table));
		return $stmt->fetch()['count'];
	}

	function getUserData($userid, $data) {
			$stmt = $this->prepare('SELECT ? FROM users WHERE id=?');
			$stmt->execute(array($data, $userid));
			$row = $stmt->fetch();
			return (!is_null($row) ? ($data == '*' ? $row : $row[$data]) : false);
	}
}

?>
