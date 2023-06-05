<?php
// エラーの表示
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// データベース接続
$dsn = "mysql:dbname=test_db;host=mysql8-1;port=3306";
$user = "test_user";
$password = "test_password";
$db = new PDO($dsn, $user, $password);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // 追加：エラーモードの設定

try {
	// リクエストから新規登録情報を取得
	$data = json_decode(file_get_contents('php://input'), true);
	$email = $data['email'];
	$password = $data['password'];

	// メールアドレスのバリデーション
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		http_response_code(400);
		echo json_encode(['message' => 'メールアドレスの形式が正しくありません']);
		exit;
	}

	// パスワードのバリデーション
	if (strlen($password) < 8) {
		http_response_code(400);
		echo json_encode(['message' => 'パスワードは8文字以上にしてください']);
		exit;
	}

	// パスワードをハッシュ化
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	// ユーザ情報の登録
	$stmt = $db->prepare('INSERT INTO user (mail_address, user_password, created_at) VALUES (?, ?, ?)');
	$execution_result = $stmt->execute([$email, $hashed_password, date("Y-m-d H:i:s")]);  // 追加：現在の日時をINSERT

	if (!$execution_result) {
		// SQLの実行結果がfalseのとき
		http_response_code(500);
		echo json_encode(['message' => 'Failed to create user.']);
		exit;
	}

	// ユーザ情報の登録が成功したとき
	http_response_code(200);
	echo json_encode(['message' => 'ユーザー登録が完了しました！']);
} catch (PDOException $e) {  // 追加：PDOExceptionをcatchする
	http_response_code(500);
	echo json_encode(['message' => $e->getMessage()]);  // 追加：PDOExceptionのメッセージを表示する
}
