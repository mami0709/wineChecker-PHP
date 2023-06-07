<?php
$dsn = "mysql:dbname=test_db;host=mysql;port=3306";
$user = "test_user";
$password = "test_password";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

try {
    $dbh = new PDO($dsn, $user, $password);

    // ワインIDを取得する
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if (!$id) {
        throw new Exception("Invalid wine id");
    }

    // 指定されたIDのワイン情報を取得する
    $sql = "SELECT id, comment, wine_name, winery, wine_type, wine_image, wine_country, wine_url, one_word, english_wine_name, years, producer, breed, capacity FROM recommend_wines WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);
    $wineData = $stmt->fetch(PDO::FETCH_ASSOC);

    // 結果をJSON形式で出力
    header('Content-Type: application/json');
    echo json_encode([
        'result' => $wineData ? 'SUCCESS' : 'FAIL',
        'data' => $wineData ? [$wineData] : [],
    ], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    die();
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'result' => 'FAIL',
        'data' => [],
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
    die();
}
