<?php
$dsn = "mysql:dbname=test_db;host=mysql;port=3306";
$user = "test_user";
$password = "test_password";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");


try {
    // DB接続
    $dbh = new PDO($dsn, $user, $password);

    // 初期データ
    $sampleData = require 'sampleData.php';

    // テーブルの存在確認
    $sql = "SHOW TABLES LIKE 'recommend_wines'";
    $result = $dbh->query($sql)->fetchAll();

    // テーブルが存在しない場合、テーブルを作成
    if (empty($result)) {
        $sql = "CREATE TABLE recommend_wines (
            id INT AUTO_INCREMENT PRIMARY KEY,
            comment TEXT,
            wine_name VARCHAR(255) NOT NULL,
            winery VARCHAR(255) NOT NULL,
            wine_type VARCHAR(255) NOT NULL,
            wine_image VARCHAR(255) NOT NULL,
            wine_country VARCHAR(255) NOT NULL,
            wine_url VARCHAR(1000) NOT NULL,
            one_word VARCHAR(255),
            english_wine_name VARCHAR(255),
            years VARCHAR(255),
            producer VARCHAR(255),
            breed VARCHAR(255) NOT NULL,
            capacity INT
        )";

        $dbh->exec($sql);
    }

    // テーブルが空かどうか確認
    $sql = "SELECT COUNT(*) FROM recommend_wines";
    $count = $dbh->query($sql)->fetchColumn();

    // テーブルが空ならサンプルデータを挿入
    if ($count == 0) {
        $sql = "INSERT INTO recommend_wines (comment, wine_name, winery, wine_type, wine_image, wine_country, wine_url, one_word, english_wine_name, years, producer, breed, capacity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dbh->prepare($sql);
        foreach ($sampleData as $data) {
            $stmt->execute([$data['comment'], $data['wine_name'], $data['winery'], $data['wine_type'], $data['wine_image'], $data['wine_country'], $data['wine_url'], $data['one_word'], $data['english_wine_name'], $data['years'], $data['producer'], $data['breed'], $data['capacity']]);
        }
    }

    // データの取得
    $sql = "SELECT id, comment, wine_name, winery, wine_type, wine_image, wine_country, wine_url, one_word, english_wine_name, years, producer, breed, capacity FROM recommend_wines";
    $wineData = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    // JSON形式で出力
    header('Content-Type: application/json');
    echo json_encode([
        'result' => 'SUCCESS',
        'data' => $wineData
    ], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    die();
}
