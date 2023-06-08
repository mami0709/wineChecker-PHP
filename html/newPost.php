<?php

// エラー表示
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	// サーバーがOPTIONSメソッドのリクエストを受け取った際には、何もせずに正常終了
	exit;
} elseif ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(400);
	echo json_encode(['message' => 'Invalid request method.']);
	exit;
}

// データベース接続
$dsn = "mysql:dbname=test_db;host=mysql8-1;port=3306";
$user = "test_user";
$password = "test_password";
$db = new PDO($dsn, $user, $password);

// リクエストからワインの情報を取得
$rawData = file_get_contents('php://input');
error_log('Raw data: ' . $rawData);
$data = json_decode($rawData, true);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(400);
	echo json_encode(['message' => 'Invalid request method.']);
	exit;
}

if ($data === null) {
	http_response_code(400);
	echo json_encode(['message' => 'リクエストボディが不適切です。']);
	exit;
}

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

$stmt = $db->prepare('INSERT INTO recommend_wines (comment, wine_name, winery, wine_type, wine_image, wine_country, wine_url, one_word, english_wine_name, years, producer, breed, capacity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
$result = $stmt->execute([$comment, $wine_name, $winery, $wine_type, $wine_image, $wine_country, $wine_url, $one_word, $english_wine_name, $years, $producer, $breed, $capacity]);

// 実行結果がfalseの場合はエラーメッセージを返す
if ($result === false) {
	http_response_code(500);
	echo json_encode(['message' => 'データの挿入中にエラーが発生しました。']);
	exit;
}

// 新しいワイン情報が登録された場合、成功メッセージを返す
echo json_encode(['message' => '新しいワインが正常に登録されました。']);
error_log(print_r($data, true));
