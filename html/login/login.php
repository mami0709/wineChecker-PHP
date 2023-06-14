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

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //エラーモードの設定

try {
    // テーブル存在確認
    $result = $db->query("SHOW TABLES LIKE 'user'");
    $tableExists = ($result->rowCount() > 0);

    // テーブルが存在しない場合、テーブルを作成
    if (!$tableExists) {
        $sql = "CREATE TABLE `user` (
                `id` int unsigned NOT NULL AUTO_INCREMENT,
                `mail_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'sample@example.com',
                `user_password` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '" . password_hash('defaultpassword', PASSWORD_DEFAULT) . "',
                `created_at` datetime NOT NULL,
                `token` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                `user_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'サンプル',
                `user_name_hiragana` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'さんぷる',
                `telephone_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '000-0000-0000',
                `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'nickname',
                PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
        $db->exec($sql);

        // テーブルが存在しなかった場合、サンプルデータを挿入
        $stmt = $db->prepare('INSERT INTO user (mail_address, user_password, created_at, token, user_name, user_name_hiragana, telephone_number, nickname) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $token = bin2hex(random_bytes(16));
        $hashed_password = password_hash('defaultpassword', PASSWORD_DEFAULT);
        // サンプルデータを挿入
        $stmt->execute([
            'sample@example.com',
            $hashed_password,
            date("Y-m-d H:i:s"),
            $token,
            'サンプル',
            'さんぷる',
            '000-0000-0000',
            'nickname'
        ]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => $e->getMessage()]);
    exit;
}

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

// ユーザ情報が正しい場合、新しいトークンを生成
$token = bin2hex(random_bytes(16));

// 生成されたトークンで既存のトークンを更新
$stmt = $db->prepare('UPDATE user SET token = ? WHERE id = ?');
$stmt->execute([$token, $user['id']]);

echo json_encode(['token' => $token]);
