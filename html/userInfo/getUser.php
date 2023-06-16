<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	header("HTTP/1.1 200 OK");
	die();
}

// データベース接続
$dsn = "mysql:dbname=test_db;host=mysql8-1;port=3306";
$user = "test_user";
$password = "test_password";
$db = new PDO($dsn, $user, $password);

// GETパラメータからトークンを取得
$token = $_GET["token"];

if (!$token) {
	http_response_code(401);
	echo json_encode(['message' => 'Token is required.']);
	exit;
}

// トークンからユーザー情報を取得
$stmt = $db->prepare('SELECT * FROM user WHERE token = ?');
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
	http_response_code(401);
	echo json_encode(['message' => 'Invalid token.']);
	exit;
}

echo json_encode($user);
