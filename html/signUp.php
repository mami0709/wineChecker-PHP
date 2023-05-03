<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB接続
$dsn = "mysql:dbname=test_db;host=mysql8-1;port=3306";
$user = "test_user";
$password = "test_password";

	
if(isset($_POST['send'])) {
	$mail_address = $_POST['mail_address'];
	$hashed_user_password = crypt($_POST['user_password'], 'CRYPT_SHA256');
	$created_at = new DateTime('now');
	$formatted_created_at = $created_at->format('Y-m-d H:i:s');

	var_dump($created_at);

	try {
			$dbh = new PDO($dsn, $user, $password);

			$sql = "INSERT INTO 
					user 
					(mail_address, user_password, created_at)
					values (
						'{$mail_address}', 
						'{$hashed_user_password}',
						'{$formatted_created_at}'
						)
					";
			print($sql);
			$stmt = $dbh->query($sql);

		if($stmt) {
			echo '登録が完了しました！';
		}else {
			var_dump($stmt);
			echo '登録に失敗しました。';
			// printf("Connect failed: ", mysqli_connect_error());
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
		<form method="POST" action="/signUp.php">
			<label>メールアドレス*</label>
			<input type="text" name="mail_address" placeholder="メールアドレスを入力" required/><br/>
			<label>パスワード*</label>
			<input type="text" name="user_password" placeholder="パスワードを入力" required/><br/>
			<input type="submit" name="send" value="登録" />
		</form>
	</body>
</html>
