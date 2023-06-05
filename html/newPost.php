<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

// データベース接続
$dsn = "mysql:dbname=test_db;host=mysql8-1;port=3306";
$user = "test_user";
$password = "test_password";
$db = new PDO($dsn, $user, $password);

// リクエストからワインの情報を取得
$data = json_decode(file_get_contents('php://input'), true);
$comment = $data['comment'];
$wine_name = $data['wine_name'];
$winery = $data['winery'];
$wine_type = $data['wine_type'];
$wine_image = $data['wine_image'];
$wine_country = $data['wine_country'];
$wine_url = $data['wine_url'];
$one_word = $data['one_word'];
$english_wine_name = $data['english_wine_name'];
$years = $data['years'];
$producer = $data['producer'];
$breed = $data['breed'];
$capacity = $data['capacity'];
$created_at = date('Y-m-d H:i:s'); // 現在のタイムスタンプをcreated_atに設定

// 新しいワインの登録
$stmt = $db->prepare('INSERT INTO recommend_wines (comment, wine_name, winery, wine_type, wine_image, wine_country, wine_url, one_word, english_wine_name, years, producer, breed, capacity, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
$result = $stmt->execute([$comment, $wine_name, $winery, $wine_type, $wine_image, $wine_country, $wine_url, $one_word, $english_wine_name, $years, $producer, $breed, $capacity, $created_at]);

// 実行結果がfalseの場合はエラーメッセージを返す
if ($result === false) {
	http_response_code(500);
	echo json_encode(['message' => 'データの挿入中にエラーが発生しました。']);
	exit;
}

// 新しいワイン情報が登録された場合、成功メッセージを返す
echo json_encode(['message' => '新しいワインが正常に登録されました。']);
