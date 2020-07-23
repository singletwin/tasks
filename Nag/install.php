<?php

//создадим базу даннх ,  таблицы в ней, затем , заполним всё данными.  затем  потребуется инФОРМАЦИЯ ДЛЯ ДОСТУПА К MYSQL.

echo <<<_HTML

<!DOCTYPE html>
<html>
	<head>
		<title>Installation page</title>
	</head>
	<body>
<h4>Давайте создадим базу данных для работы приложения (если её у вас нет) и таблицы с тестовыми записями в ней. Введите, пожалуйста, данные для доступа к MySQL (они будут сохранены в отдельном файле и будут использоваться для доступа к базе данных).
	Если у вас уже есть база данных, которую вы хотите использовать : введите её имя.
</h4>

<br>

<span>Заполните, пожалуйста, форму для доступа к MySQL:</span>
<br>
<form method="post" action="install.php">
	<input type="text" size="8" maxlength="64" name="username" title='username' placeholder='username' required>
	<input type="text" size="8" maxlength="64" name="host" title='host' placeholder='host' required>
	<input type='password' size="8" maxlength="64" name="password" title='password' placeholder='password' required>
	<input type="text" size="8" maxlength="64" name="database" title='database' placeholder='database' required>
	<input type="submit" value=" Отправить ">
</form>
_HTML;

if ( isset($_POST['username']) AND isset($_POST['host']) AND isset($_POST['password']) AND isset($_POST['database']) )
{
	$conn = new mysqli($_POST['host'], $_POST['username'], $_POST['password']);
	$database = $_POST['database'];
	$query = "CREATE DATABASE $database";
	$result = $conn->query($query);
	if (!$result) print ($conn->error);
	else print ("database '$database' created with success!");


	// Test connection to mysql ______________________________________
	$conn = new mysqli($_POST['host'], $_POST['username'], $_POST['password'], $_POST['database']);
	if ($conn->connect_error) 
	{
		die($conn->connect_error);
	}
	else
	{
		$fh = fopen("mysqlenter.txt", 'w') or die("Создать файл конфигурации не удалось");
		$username = $_POST['username'];
		$host = $_POST['host'];
		$password = $_POST['password'];
		$database = $_POST['database'];
		$text = <<<_END
$username
$host
$password
$database
_END;
		fwrite($fh, $text) or die("Сбой записи файла");
		fclose($fh);
		echo "<br>Файл конфигурации 'mysqlenter.txt' записан успешно ";
	}

	require_once('mysql-create.php');
	echo "<br>";
	echo "<a href='/index.php'> Теперь можно пользоваться </a>";
}

?>