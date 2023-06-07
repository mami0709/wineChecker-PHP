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
    $sampleData = [
        [
            'comment' => '最高級ワインの産地として知られる、フランスのメドック地区で造られたフルボディ赤ワインです。世界的に有名な「シャトー ラフィット・ロートシルト」を運営する、ロスチャイルド家が醸造しています。カベルネ・ソーヴィニヨンとメルローがブレンドされ、力強い飲み口と、きめ細やかでしっかりとした果実味が特徴です。使われているブドウの一部は、第1級の格付けのラフィット・ロートシルトで収穫されたモノ。エレガントで高級感のある味わいの赤ワインが5000円以下で楽しめる、コストパフォーマンスの高さもポイントです。',
            'wine_name' => 'ドメーヌ バロン ド ロートシルト ポーイヤック レゼルブ',
            'winery' => 'ブルゴーニュ',
            'wine_type' => '赤ワイン',
            'wine_image' => 'https://m.media-amazon.com/images/I/51oIGuJ2aFL.__AC_SX342_SY445_QL70_ML2_.jpg',
            'wine_country' => '🇫🇷 フランス',
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
            'wine_image' => 'https://enoteca.imagewave.pictures/R7c7J1v7R/bottle-500',
            'wine_country' => '🇫🇷 フランス',
            'wine_url' => 'https://www.enoteca.co.jp/item/detail/010050861',
            'one_word' => 'あのロバート・パーカー氏のお気に入りシャトー。格付けシャトーに匹敵するクオリティを備えた、お値打ちボルドーワイン。',
            'english_wine_name' => 'CH.LANESSAN',
            'years' => '2013',
            'producer' => 'CH.LANESSAN シャトー・ラネッサン',
            'breed' => 'カベルネ・ソーヴィニヨン、メルロー、プティ・ヴェルド',
            'capacity' => 750
        ],
        [
            'comment' => 'このワインは、「コート・ドール」と「コート・シャロネーズ」のヴィラージュ級の畑の選ばれたブドウから造られています。ジャド・スタイルを反映して、ふくよかなフルーツらしさと絹のような舌触りと優しいタンニンを持った、穏やかで調和の取れた香味に仕上がっています。若いときには赤い果実のフルーティさを発揮し、時間とともに、森の枯れ葉の香りや、スパイシーさなど、より熟成した香りで楽しませてくれます。ブレンドに用いられるコート・ド・ニュイのワインは深みのあるタンニンをもたらし、コート・ド・ボーヌのワインは果実味を与えます。ピノ・ノワール品種の個性を非常に良くあらわしたワインです。',
            'wine_name' => 'ルイ・ジャド ブルゴーニュ ピノ・ノワール',
            'winery' => 'ブルゴーニュ',
            'wine_type' => '赤ワイン',
            'wine_image' => 'https://m.media-amazon.com/images/I/61BRhtCmYqL.__AC_SX342_SY445_QL70_ML2_.jpg',
            'wine_country' => '🇫🇷 フランス',
            'wine_url' => 'https://www.amazon.co.jp/dp/B002JN2US6?tag=greatwine-22&linkCode=ogi&th=1&psc=1',
            'one_word' => 'ラズベリーのような果実味とシルクのような舌触りが心地よいワイン',
            'english_wine_name' => 'LOUIS JADOT',
            'years' => '2020',
            'producer' => 'ルイ・ジャド社',
            'breed' => 'ピノ・ノワール100',
            'capacity' => 750
        ],
        [
            'comment' => 'ブラウン・ブラザーズは、1889年オーストラリアのビクトリア州に創立した国内で最も古い家族経営のワイナリーの1つです。原料となっているタランゴ種は、オーストラリアのCSIRO(科学産業研究機構)の科学者が1965年に開発したブドウ品種です。ブラウン・ブラザーズ社は1980年にタランゴ品種からワインを造り始めましたが、近年フランスのボージョレと同様のマセラシオン・カルボニック製法を導入しています。生き生きとしたフレッシュな果実、ジャムや砂糖付けの赤果実のような香り。まろやかでキメの細かい控えめなタンニン分(渋味)。酸味と甘味のバランスも良く、ジューシーな味わい。少し冷やしていただいても楽しめます。',
            'wine_name' => 'ブラウンブラザース タランゴ',
            'winery' => 'ビクトリア',
            'wine_type' => '赤ワイン',
            'wine_image' => 'https://m.media-amazon.com/images/I/71GlnsAM1VL.__AC_SX342_SY445_QL70_ML2_.jpg',
            'wine_country' => '🇦🇺 オーストラリア',
            'wine_url' => 'https://www.amazon.co.jp/%E3%83%96%E3%83%A9%E3%82%A6%E3%83%B3%E3%83%96%E3%83%A9%E3%82%B6%E3%83%BC%E3%82%BA-%E3%82%BF%E3%83%A9%E3%83%B3%E3%82%B4-%E3%83%A9%E3%82%A4%E3%83%88%E3%83%9C%E3%83%87%E3%82%A3-%E3%82%AA%E3%83%BC%E3%82%B9%E3%83%88%E3%83%A9%E3%83%AA%E3%82%A2-750ml/dp/B005YTGF3I/ref=sr_1_2?__mk_ja_JP=%E3%82%AB%E3%82%BF%E3%82%AB%E3%83%8A&keywords=%E3%83%96%E3%83%A9%E3%82%A6%E3%83%B3%E3%83%96%E3%83%A9%E3%82%B6%E3%83%BC%E3%82%BA+%E3%82%BF%E3%83%A9%E3%82%B4&linkCode=ll2&qid=1665470721&qu=eyJxc2MiOiIwLjU5IiwicXNhIjoiMC4wMCIsInFzcCI6IjAuMDAifQ%3D%3D&sr=8-2',
            'one_word' => 'ボジョレーヌーボーのような、酸味が柔らかくてフルーティな香りのライトボディ',
            'english_wine_name' => '',
            'years' => '',
            'producer' => '',
            'breed' => 'タランゴ90%、メルロー10%',
            'capacity' => 750
        ],
        [
            'comment' => 'オバマ元大統領もお気に入りのワインとしてその名前を挙げる、カリフォルニア屈指のワイナリー。グランド・リザーヴは、所有する様々な畑を厳格に区分して栽培したブドウを、ブレンドして仕立てる上級シリーズ。トロピカルフルーツの濃厚なアロマ、バターやナッツのコクとほのかなミネラルが感じられるリッチな味わいです。',
            'wine_name' => 'ケンダル・ジャクソン グランド・リザーヴ シャルドネ',
            'winery' => 'カリフォルニア',
            'wine_type' => '白ワイン',
            'wine_image' => 'https://m.media-amazon.com/images/I/61B2F4S0WfL._AC_SX679_.jpg',
            'wine_country' => '🇺🇸 アメリカ合衆国',
            'wine_url' => 'https://www.amazon.co.jp/%E3%82%B1%E3%83%B3%E3%83%80%E3%83%AB%E3%82%B8%E3%83%A3%E3%82%AF%E3%82%BD%E3%83%B3-081584013082-%E3%82%B1%E3%83%B3%E3%83%80%E3%83%AB%E3%83%BB%E3%82%B8%E3%83%A3%E3%82%AF%E3%82%BD%E3%83%B3-%E3%82%B0%E3%83%A9%E3%83%B3%E3%83%89%E3%83%BB%E3%83%AA%E3%82%B6%E3%83%BC%E3%83%B4-%E3%82%B7%E3%83%A3%E3%83%AB%E3%83%89%E3%83%8D/dp/B0016H3A3U',
            'one_word' => 'アメリカ屈指のワイナリーが造る、まさにコクが感じられるシャルドネです。まるでバターやオイルのようなリッチな口当たり',
            'english_wine_name' => '',
            'years' => '2020',
            'producer' => 'エノテカ',
            'breed' => 'シャルドネ, ピノ・ムニエ',
            'capacity' => 750
        ],
        [
            'comment' => '南フランスのローヌ全域で圧巻のコレクションを手掛ける「ローヌで最も優れたネゴシアン」タルデュー・ローラン。こちらは、当主のミッシェル・ダルデュー氏の父ギィと叔父ルイへのオマージュワイン。タルデュー氏曰く、「非常に高いレベルのバランスを備えており、熟成が可能」とのこと。クリームシチューのような濃い味付けの料理はもちろん、しっかり冷やしてスパイシーなエスニック料理と一緒に愉しむのもおススメです。',
            'wine_name' => 'コート・デュ・ローヌ ギィ・ルイ・ブラン',
            'winery' => 'コート・デュ・ローヌ',
            'wine_type' => '白ワイン',
            'wine_image' => 'https://m.media-amazon.com/images/I/31YdGDgSHaL.__AC_SX342_SY445_QL70_ML2_.jpg',
            'wine_country' => '🇫🇷 フランス',
            'wine_url' => 'https://www.amazon.co.jp/Cotes-Rhone-Blanc-%E3%82%A2%E3%83%B3%E3%83%89%E3%83%AC%E3%83%BB%E3%83%96%E3%83%AB%E3%83%8D%E3%83%AB-750ml/dp/B01M5DR5GB/ref=sr_1_1_sspa?adgrpid=68107259489&gclid=CjwKCAjwqJSaBhBUEiwAg5W9p14VeHLxEu8J7kx24_P-vTeP8GqvAcLefz7O-xbK9d6NMHgPxPxfrhoCoyAQAvD_BwE&hvadid=618688899329&hvdev=c&hvlocphy=1009637&hvnetw=g&hvqmt=b&hvrand=9018288264539753818&hvtargid=kwd-300396788321&hydadcr=1941_13539232&jp-ad-ap=0&keywords=%E3%82%B3%E3%83%BC%E3%83%88+%E3%83%87%E3%83%A5+%E3%83%AD%E3%83%BC%E3%83%8C+%E3%83%96%E3%83%A9%E3%83%B3&qid=1665478029&qu=eyJxc2MiOiIwLjAwIiwicXNhIjoiMC4wMCIsInFzcCI6IjAuMDAifQ%3D%3D&sr=8-1-spons&psc=1&spLa=ZW5jcnlwdGVkUXVhbGlmaWVyPUExSDJDNE5US0FXSzlRJmVuY3J5cHRlZElkPUEwNDg4NDkxV1g5UDFUMFUxSUU3JmVuY3J5cHRlZEFkSWQ9QTEyQ0hQRlRGUkNXTVcmd2lkZ2V0TmFtZT1zcF9hdGYmYWN0aW9uPWNsaWNrUmVkaXJlY3QmZG9Ob3RMb2dDbGljaz10cnVl',
            'one_word' => '南北ローヌのブドウをブレンドして造られる、南仏らしい豊かなアロマと果実味が溢れた白ワイン',
            'english_wine_name' => 'Cotes du Rhone Blanc la Becassonne',
            'years' => '2018',
            'producer' => 'アンドレ ブルネル',
            'breed' => 'ルーサンヌ50％、グルナッシュ ブラン30％、クレレット20％',
            'capacity' => 750
        ],
        [
            'comment' => '多くの評論家・評価誌から高評価を獲得し、見つけたらすぐに買うべき造り手と評される生産者。赤ワインのイメージが強い彼らですが、白ワインも非常に高品質。こちらはアリゴテならではの酸を表現しつつ、心地よいボリューム感のある仕上がりです',
            'wine_name' => 'ブルゴーニュ・アリゴテ',
            'winery' => 'ブルゴーニュ',
            'wine_type' => '白ワイン',
            'wine_image' => 'https://m.media-amazon.com/images/I/51+-AjtNzVL._AC_SX342_SY445_.jpg',
            'wine_country' => '🇫🇷 フランス',
            'wine_url' => 'https://www.amazon.co.jp/%E3%83%96%E3%83%AB%E3%82%B4%E3%83%BC%E3%83%8B%E3%83%A5-%E3%82%A2%E3%83%AA%E3%82%B4%E3%83%86-750ml-%E3%82%AA%E3%83%BC%E3%82%AC%E3%83%8B%E3%83%83%E3%82%AF-%E3%83%AF%E3%82%A4%E3%83%B3/dp/B007X3OGD4',
            'one_word' => '柑橘系果実を思わせる酸味を伴ったフレッシュかつ爽やかな果実味と、ミネラル感が魅力',
            'english_wine_name' => '',
            'years' => '2020',
            'producer' => 'ペルチエ家',
            'breed' => 'アリゴテ',
            'capacity' => 750
        ],
        [
            'comment' => 'プルノットは、イタリア屈指のワイン産地、ピエモンテ州で100 年以上続く老舗ワイナリー。こちらは、ピエモンテを代表する白ワインの土着品種アルネイスで造られています。徹底して低温を保つことで引き出す、フレッシュなアロマとコクのある味わいが特徴で、様々なお食事と合わせて頂ける仕上がりです。',
            'wine_name' => 'ロエロ・アルネイス',
            'winery' => 'ブルゴーニュ',
            'wine_type' => '白ワイン',
            'wine_image' => 'https://m.media-amazon.com/images/I/31LtvgchMpL.__AC_SY445_SX342_QL70_ML2_.jpg',
            'wine_country' => '🇮🇹 イタリア',
            'wine_url' => 'https://www.amazon.co.jp/%E3%83%AD%E3%82%A8%E3%83%AD%E3%83%BB%E3%82%A2%E3%83%AB%E3%83%8D%E3%82%A4%E3%82%B9%E3%83%BB%E3%83%B4%E3%82%A3%E3%83%83%E3%83%A9%E3%83%BC%E3%82%BF-%E3%83%B4%E3%82%A3%E3%83%BC%E3%83%86%E3%83%BB%E3%82%B3%E3%83%AB%E3%83%86-2020%E5%B9%B4-%E3%83%94%E3%82%A8%E3%83%A2%E3%83%B3%E3%83%86-750ml/dp/B09QCLFQCF',
            'one_word' => 'バローロ、バルバレスコの名門が手掛けるピエモンテ最上級の辛口白ワイン。華やかさとコクを兼備した上質な1本',
            'english_wine_name' => 'ROERO ARNEIS VILLATA',
            'years' => '2020',
            'producer' => 'ヴィーテ・コルテ',
            'breed' => 'アルネイス',
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
            wine_url VARCHAR(1000),
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
