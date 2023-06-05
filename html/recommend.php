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
    // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $path = ltrim($_SERVER['REQUEST_URI'], '/');
    // $elements = explode('/', $path);

    // if($elements[0] == "/recommend.php") {
    //     $stmt = $dbh->query("SELECT * FROM recommend_wines");
    //     $wines = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     header('Content-Type: application/json');
    //     echo json_encode([
    //         'result' => 'SUCCESS',
    //         'data' => $wines
    //     ], JSON_UNESCAPED_UNICODE);
    // } 

    // 初期データ
    $sampleData = [
        [
            'comment' => '最高級ワインの産地として知られる、フランスのメドック地区で造られたフルボディ赤ワインです。世界的に有名な「シャトー ラフィット・ロートシルト」を運営する、ロスチャイルド家が醸造しています。カベルネ・ソーヴィニヨンとメルローがブレンドされ、力強い飲み口と、きめ細やかでしっかりとした果実味が特徴です。使われているブドウの一部は、第1級の格付けのラフィット・ロートシルトで収穫されたモノ。エレガントで高級感のある味わいの赤ワインが5000円以下で楽しめる、コストパフォーマンスの高さもポイントです。',
            'wine_name' => 'ドメーヌ バロン ド ロートシルト ポーイヤック レゼルブ スペシアル',
            'winery' => 'ブルゴーニュ',
            'wine_type' => '赤ワイン',
            'wine_image' => 'images/01.webp',
            'wine_country' => 'フランス',
            'wine_url' => 'https://www.amazon.co.jp/dp/B00ISJ9DVC?ots=1&tag=s02a3-22&th=1',
            'one_word' => '力強い飲み口ときめ細やかでしっかりとした果実味',
            'english_wine_name' => 'Domane Barons de Rothschild',
            'years' => '2020',
            'producer' => 'ロスチャイルド家',
            'breed' => 'カベルネ・ソーヴィニヨン、メルロー',
            'capacity' => 750
        ],
        [
            'comment' => '名門ブテイエ家が所有し、お値打ちなボルドーワインとして確固たる地位を築くシャトー。ワイン評論家ロバート・パーカー氏も「メドックのワイン格付けをやり直せば、おそらく格付け第五級の地位が真剣に検討されるワインである」と大絶賛しています。凝縮した果実味と滑らかなタンニンが調和した味わいです。',
            'wine_name' => 'シャトー・ラネッサン',
            'winery' => 'ブルゴーニュ',
            'wine_type' => '赤ワイン',
            'wine_image' => 'images/02.webp',
            'wine_country' => 'フランス',
            'wine_url' => 'https://www.enoteca.co.jp/item/detail/010050861',
            'one_word' => '力強い飲み口ときめ細やかでしっかりとした果実味',
            'english_wine_name' => 'CH.LANESSAN',
            'years' => '2013',
            'producer' => 'CH.LANESSAN シャトー・ラネッサン',
            'breed' => 'カベルネ・ソーヴィニヨン、メルロー、プティ・ヴェルド',
            'capacity' => 750
        ],
        [
            'comment' => '最高級ワインの産地として知られる、フランスのメドック地区で造られたフルボディ赤ワインです。世界的に有名な「シャトー ラフィット・ロートシルト」を運営する、ロスチャイルド家が醸造しています。カベルネ・ソーヴィニヨンとメルローがブレンドされ、力強い飲み口と、きめ細やかでしっかりとした果実味が特徴です。使われているブドウの一部は、第1級の格付けのラフィット・ロートシルトで収穫されたモノ。エレガントで高級感のある味わいの赤ワインが5000円以下で楽しめる、コストパフォーマンスの高さもポイントです。',
            'wine_name' => 'ドメーヌ バロン ド ロートシルト ポーイヤック レゼルブ スペシアル',
            'winery' => 'ブルゴーニュ',
            'wine_type' => '赤ワイン',
            'wine_image' => 'images/03.jpg',
            'wine_country' => 'フランス',
            'wine_url' => 'https://www.amazon.co.jp/dp/B00ISJ9DVC?ots=1&tag=s02a3-22&th=1',
            'one_word' => '力強い飲み口ときめ細やかでしっかりとした果実味',
            'english_wine_name' => 'Domane Barons de Rothschild',
            'years' => '2020',
            'producer' => 'ロスチャイルド家',
            'breed' => 'カベルネ・ソーヴィニヨン、メルロー',
            'capacity' => 750
        ],
        [
            'comment' => '名門ブテイエ家が所有し、お値打ちなボルドーワインとして確固たる地位を築くシャトー。ワイン評論家ロバート・パーカー氏も「メドックのワイン格付けをやり直せば、おそらく格付け第五級の地位が真剣に検討されるワインである」と大絶賛しています。凝縮した果実味と滑らかなタンニンが調和した味わいです。',
            'wine_name' => 'シャトー・ラネッサン',
            'winery' => 'ブルゴーニュ',
            'wine_type' => '赤ワイン',
            'wine_image' => 'public/images/04.jpg',
            'wine_country' => 'フランス',
            'wine_url' => 'https://www.enoteca.co.jp/item/detail/010050861',
            'one_word' => '力強い飲み口ときめ細やかでしっかりとした果実味',
            'english_wine_name' => 'CH.LANESSAN',
            'years' => '2013',
            'producer' => 'CH.LANESSAN シャトー・ラネッサン',
            'breed' => 'カベルネ・ソーヴィニヨン、メルロー、プティ・ヴェルド',
            'capacity' => 750
        ],
        // ... 他のサンプルデータ
    ];

    // テーブルの存在確認
    $sql = "SHOW TABLES LIKE 'recommend_wines'";
    $result = $dbh->query($sql)->fetchAll();

    // テーブルが存在しない場合、テーブルを作成
    if (empty($result)) {
        $sql = "CREATE TABLE recommend_wines (
            id INT AUTO_INCREMENT PRIMARY KEY,
            comment TEXT,
            wine_name VARCHAR(255),
            winery VARCHAR(255),
            wine_type VARCHAR(255),
            wine_image VARCHAR(255),
            wine_country VARCHAR(255),
            wine_url VARCHAR(255),
            one_word VARCHAR(255),
            english_wine_name VARCHAR(255),
            years VARCHAR(255),
            producer VARCHAR(255),
            breed VARCHAR(255),
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
