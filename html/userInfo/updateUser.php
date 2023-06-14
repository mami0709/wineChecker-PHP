<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: http://localhost:3000");  // ReactアプリのURL
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");  // 必要なHTTPメソッドを追加
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	// OPTIONS メソッドのリクエストに対しては適切なレスポンスを返す
	header("HTTP/1.1 200 OK");
	die();
}

$dsn = "mysql:dbname=test_db;host=mysql8-1;port=3306";
$user = "test_user";
$password = "test_password";
$db = new PDO($dsn, $user, $password);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
	$data = json_decode(file_get_contents('php://input'), true);
	$id = $data['id'] ?? null;
	$mail_address = $data['mail_address'] ?? null;
	$user_name = $data['user_name'] ?? null;
	$user_name_hiragana = $data['user_name_hiragana'] ?? null;
	$telephone_number = $data['telephone_number'] ?? null;
	$nickname = $data['nickname'] ?? null;


	if (!$id) {
		http_response_code(400);
		echo json_encode(['message' => 'User ID is missing.']);
		exit;
	}

	$stmt = $db->prepare('UPDATE user SET mail_address = ?, user_name = ?, user_name_hiragana = ?, telephone_number = ?, nickname = ? WHERE id = ?');
	$execution_result = $stmt->execute([
		$mail_address,
		$user_name,
		$user_name_hiragana,
		$telephone_number,
		$nickname,
		$id
	]);

	if (!$execution_result) {
		http_response_code(500);
		echo json_encode(['message' => 'Failed to update user.']);
		exit;
	}

	echo json_encode(['message' => 'ユーザー情報が更新されました！']);
	http_response_code(200);
} catch (PDOException $e) {
	http_response_code(500);
	echo json_encode(['message' => $e->getMessage()]);
}
