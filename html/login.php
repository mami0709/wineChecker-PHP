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

// リクエストからログイン情報を取得
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$password = $data['password'];

// ユーザ情報の取得
$stmt = $db->prepare('SELECT * FROM user WHERE mail_address = ?');
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// ユーザ情報が存在しない場合、またはパスワードが一致しない場合はエラーを返す
if (!$user || !password_verify($password, $user['user_password'])) {
    http_response_code(401);
    echo json_encode(['message' => 'Email or password is incorrect.']);
    exit;
}

// ユーザ情報が正しい場合、トークンを生成し返す
$token = bin2hex(random_bytes(16));
$stmt = $db->prepare('INSERT INTO tokens (user_id, token) VALUES (?, ?)');
$stmt->execute([$user['id'], $token]);

echo json_encode(['token' => $token]);
?>
