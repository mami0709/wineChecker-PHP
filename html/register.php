<?php
	// DB接続
	$dsn = "mysql:dbname=test_db;host=mysql8-1;port=3306";
	$user = "test_user";
	$password = "test_password";

		
	if(isset($_POST['send'])) {
		$comment = $_POST['comment'];
		$wine_name = $_POST['wine-name'];
		$winery = $_POST['winery'];
		$wine_type = $_POST['wine-country'] ? $_POST['wine-country'] : "登録されていません";
		$wine_image = $_POST['wine-image'] ? $_POST['wine-image'] : "登録されていません";
		$wine_country = $_POST['wine-country'];
		$wine_url = $_POST['wine-url'] ? $_POST['wine-url'] : "登録されていません";
		// $created_at = time();

		try {
			$dbh = new PDO($dsn, $user, $password);
			
			$sql = "INSERT INTO 
					recommend_wines 
					(comment, wine_name, winery, wine_type, wine_image, wine_country, wine_url)
					values (
						'{$comment}', 
						'{$wine_name}', 
						'{$winery}',
						'{$wine_type}', 
						'{$wine_image}',
						'{$wine_country}',
						'{$wine_url}'
						)
					";
			$stmt = $dbh->query($sql);


			if($stmt) {
				echo '投稿が完了しました！';
			}else {
				var_dump($stmt);
				echo '投稿に失敗しました。';
				
			}

		} catch (PDOException $e) {
			print('Error'.$e->getMessage());
			die();
		}
	}



	try {
		$dbh = new PDO($dsn, $user, $password);
		
		$sql = "select * from recommend_wines";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
	}catch(PDOException $e) {
		print('Error'.$e->getMessage());
		die();
	}


?>

<html>
	<head>

	</head>
	<body>
		<?php 
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			if($result) {
				forEach($result as $value) {
					echo $value;	
				}
			}
		?>
		<form method="POST" action="/register.php">
			<label>ワイン名*</label>
			<input type="text" name="wine-name" placeholder="ワイン名" required/><br/>
			<label>ワイナリー*</label>
			<input type="text" name="winery" placeholder="ワイナリー" required/><br/>
			<label>原産地*</label>
			<input type="text" name="wine-country" placeholder="原産地" required/><br/>
			<label>ワインタイプ</label>
			<input type="text" name="wine-type" placeholder="ワインタイプ"/><br/>
			<label>コメント*</label>
			<input type="text" name="comment" placeholder="コメント" required/><br/>
			<label>URL</label>
			<input type="text" name="wine-url" placeholder="URL"/><br/>
			<label>画像</label>
			<input type="text" name="wine-image" placeholder="画像"/><br/>
			<input type="submit" name="send" value="送信" />
		</form>
	</body>
</html>
