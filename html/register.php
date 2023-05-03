<?php
	if($_POST) {
		$wine_name = $_POST['wine-name'];
		$winery = $_POST['winery'];
		$wine_country = $_POST['wine-country'];
		$comment = $_POST['comment'];
		$wine_image = $_POST['wine-image'] ? $_POST['wine-image'] : "";
		$wine_type = $_POST['wine-country'] ? $_POST['wine-country'] : "";
		$wine_url = $_POST['wine-url'] ? $_POST['wine-url'] : "";

		var_dump($_POST);
	} 


?>

<html>
	<head>

	</head>
	<body>
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
			<input type="submit" value="送信" />
		</form>
	</body>
</html>
