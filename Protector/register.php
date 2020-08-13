<?php

// ------ ИНФОРМАЦИЯ ОБ ОШИБКАХ
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);


session_start();

$username = $password = $email = $fail = "";



	//           В этом месте отправленные поля будут вводиться в базу данных
	//           с предварительным использованием хеш-шифрования для пароля
if ( isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) )
{
	// Test connection to mysql ______________________________________
	$fh = fopen("mysql.sys", 'r') or die("Файл не существует или...");
	$text = fread($fh, 180); fclose($fh);
	$mysqlenter = explode("\n",$text);
	$username = $mysqlenter[0]; $host = $mysqlenter[1]; $password = $mysqlenter[2]; $database = $mysqlenter[3];
	$conn = new mysqli($host, $username, $password, $database);
	if ($conn->connect_error) die($conn->connect_error);
	else
	{ 
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email']."@lkz-protector.ru";
		$passw_post = $password;
		$password = password_hash($password, PASSWORD_DEFAULT); // => store in database

	    $query = "INSERT INTO Users VALUES('$username', '$password', '$email')";
		$result = $conn->query($query);
		if (!$result) 
		{
			echo "Сбой операции! <BR>";
			//$query<br>".$conn->error."<br><br>";
			if (preg_match("/Duplicate/", $conn->error)) echo "Похоже, под таким именем уже зарегестрирован кто-то другой... Пожалуйста, выберите другое имя";
			else echo "Сбой следующей операции: $query<br> Error: ".$conn->error."<br><br>";	
		}
		else 
		{
			echo "</head><body>Регистрация прошла успешно!<br>Добро пожаловать на борт!";
			//$to = $_POST['email']."@lkz-protector.ru";
			$to = $_POST['email']."@lkz-protector.ru";
			require_once "sendmail.php"; //отправляем на заявленную почту напоминание с паролем и логином
			echo <<<_REGISTERED
			<form method="post" action="index.php">
			<input type="hidden" name="username" value="$username">
			<input type="hidden" name="password" value="$passw_post">
			<input type="submit" value="->>> Вперёд! <<<-">
			</form>
			</body>
			</html>
_REGISTERED;
			exit;

		}
	}
}



// -------------- HERE Starts HTML & Java script -----------

echo <<<_HEAD
<!DOCTYPE html>
<html>
<head>
	<title>*Страничка регистрации*</title>
</head>
_HEAD;


// ----------------- Registr Form ------------

echo <<<_BODY

<body id='register'>


	<table id='table_reg' border="0" cellpadding="2" cellspacing="5" bgcolor="#fff">
		<th colspan="2" align="center">Заполните пожалуйста форму для регистрации</th>

		<tr>
			<td colspan="2"><p id='registertbl1'><font color=red size=18><i><pre>     ✎ </pre></i></font></p>
			</td>
		</tr>


		<form method="post" action="register.php">
			<tr>
				<td>Имя пользователя</td>
				<td><input type="text" size="16" maxlength="32" name="username" placeholder="✔" title="Don't use forbidden characters, please" pattern="[\wа-яА-ЯёЁ\.\(\)!#~_@-]{1,63}" required></td>
			</tr>

			<tr>
				<td>Пароль</td>
				<td><input type="text" size="16" maxlength="32" name="password" placeholder="✔" title="Пожалуйста не используйте запретные системные символы" pattern="[\wа-яА-ЯёЁ\.\(\)!#~_@-]{1,255}" required></td>
			</tr>

			<tr>
				<td>Адрес почты на lkz-protector.ru без @</td>
				<td><input type="text" size="1" maxlength="64" name="email" placeholder="✔"  title="буквы, цифры, точка, подчеркивание, дефис" required>@lkz-protector.ru</td><td></td>
			</tr>

			<tr>
				<td colspan="2" align="center" bgcolor="#fff"><input type="submit" value="Зарегистрироваться!"></td>
			</tr>
		</form>
	</table>

<br><br>
<a href="\index.php"> <--  Вернуться! </a>
</body>
</html>
_BODY;

?>


