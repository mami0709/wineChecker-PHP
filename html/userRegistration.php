<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$dsn = "mysql:dbname=test_db;host=mysql8-1;port=3306";
$user = "test_user";
$password = "test_password";
$db = new PDO($dsn, $user, $password);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
	$result = $db->query("SHOW TABLES LIKE 'user'");
	$tableExists = ($result->rowCount() > 0);

	if (!$tableExists) {
		$sql = "CREATE TABLE `user` (
				`id` int unsigned NOT NULL AUTO_INCREMENT,
				`mail_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'sample@example.com',
				`user_password` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '".password_hash('defaultpassword', PASSWORD_DEFAULT)."',
				`created_at` datetime NOT NULL,
				`token` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
				`user_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'サンプル',
				`user_name_hiragana` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'さんぷる',
				`telephone_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '000-0000-0000',
				`nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'nickname',
				PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
		$db->exec($sql);
	}

	$data = json_decode(file_get_contents('php://input'), true);
	$email = $data['email'] ?? 'sample@example.com';
	$password = $data['password'] ?? 'defaultpassword';

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		http_response_code(400);
		echo json_encode(['message' => 'メールアドレスの形式が正しくありません']);
		exit;
	}

	if (strlen($password) < 8) {
		http_response_code(400);
		echo json_encode(['message' => 'パスワードは8文字以上にしてください']);
		exit;
	}

	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	$stmt = $db->prepare('INSERT INTO user (mail_address, user_password,
	created_at, token, user_name, user_name_hiragana, telephone_number, nickname) 
	VALUES (?, ?, ?, ?, ?,	?, ?, ?)');
	$token = bin2hex(random_bytes(16));
	$execution_result = $stmt->execute([
		$email, 
		$hashed_password, 
		date("Y-m-d H:i:s"), 
		$token, 
		$data['user_name'] ?? 'サンプル', 
		$data['user_name_hiragana'] ?? 'さんぷる', 
		$data['telephone_number'] ?? '000-0000-0000', 
		$data['nickname'] ?? 'nickname'
	]);

	if (!$execution_result) {
		http_response_code(500);
		echo json_encode(['message' => 'Failed to create user.']);
		exit;
	}

	http_response_code(200);
	echo json_encode(['message' => 'ユーザー登録が完了しました！']);
} catch (PDOException $e) {
	http_response_code(500);
	echo json_encode(['message' => $e->getMessage()]);
}
