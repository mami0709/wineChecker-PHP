<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // OPTIONS メソッドのリクエストに対しては適切なレスポンスを返す
    header("HTTP/1.1 200 OK");
    die();
}

// データベース接続
$dsn = "mysql:dbname=test_db;host=mysql8-1;port=3306";
$user = "test_user";
$password = "test_password";
$db = new PDO($dsn, $user, $password);

// リクエストからトークンを取得
$data = json_decode(file_get_contents('php://input'), true);
$token = $data['token'];

// tokensテーブルから該当のトークンを削除
$stmt = $db->prepare('DELETE FROM tokens WHERE token = ?');
$stmt->execute([$token]);

echo json_encode(['message' => 'Logged out successfully.']);
?>
