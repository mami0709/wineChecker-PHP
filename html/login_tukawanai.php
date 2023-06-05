<?php

// DB接続
$dsn = "mysql:dbname=test_db;host=mysql8-1;port=3306";
$user = "test_user";
$password = "test_password";

	
if(isset($_POST['send'])) {
    $mail_address = $_POST['mail_address'];
    $user_password = $_POST['user_password'];

	try {
		$dbh = new PDO($dsn, $user, $password);
		$sql = "SELECT * FROM user WHERE mail_address = '$mail_address'";

		$stmt = $dbh->query($sql);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if($result && password_verify($user_password, $result['user_password'])) {
			echo 'ログインに成功しました';
		} else {
			echo 'ログインに失敗しました';
		}


	} catch (PDOException $e) {
		print('Error'.$e->getMessage());
		die();
	}
}


?>

<html>
	<head>

	</head>
	<body>
		<form method="POST" action="/login.php">
			<label>メールアドレス*</label>
			<input type="text" name="mail_address" placeholder="メールアドレスを入力" required/><br/>
			<label>パスワード*</label>
			<input type="text" name="user_password" placeholder="パスワードを入力" required/><br/>
			<input type="submit" name="send" value="ログイン" />
		</form>
	</body>
</html>
