<?php

require_once 'env.php';

// エラーの内容が出てくる
ini_set('display_errors', true);

function connect()
{
	$host = DB_HOST;
	$db = DB_NAME;
	$user = DB_USER;
	$pass = DB_PASS;

	// data source name
	$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";


	try {
		$pdo = new PDO($dsn, $user, $pass, [
			// オプション
			// エラーのモードを決める
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			// 配列をキーとバリューで必ず返す
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		]);
		// echo '接続成功です！';
		return $pdo;
	} catch (PDOException $e) {
		echo '接続失敗です！' . $e->getMessage();
		exit();
	}
}

// echo connect();
