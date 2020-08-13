<?php
// ------ ИНФОРМАЦИЯ ОБ ОШИБКАХ
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);


echo <<<_HTML
<!DOCTYPE html>
<html>
	<head>
		<title>Database Setting</title>
	</head>
	<body>
_HTML;

if ( (!isset($_POST['host'])) && (!isset($_POST['username'])) && (!isset($_POST['password'])))
{
	echo <<<_FORM
		<form method="POST" action="db_set.php">
			Введите пожалуйста данные для доступа к MySQL
			<input type="text" name="host" placeholder="Hostname" size="6" required>
			<input type="text" name="username" placeholder="Username" size="6" required>
			<input type="text" name="password" placeholder="Password" size="6" required>
			<input type="submit" value="Сохранить!" style="color: #440077">
		</form>
	</body>
</html>
_FORM;
}
else // Если форма заполнена и отправлена 
{
	//var_dump($_POST);
	//echo "<br>";

	$host = $_POST['host'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$database = "Resources";
/*
	// *********** Test connection to mysql  ****************
	$conn = new mysqli('localhost', 'root', '4Mdefpnu!');
	if ($conn->connect_error) die($conn->connect_error);
	else echo "<br> OKEY <br>";
*/
	// *********** Test connection to mysql  ****************
	$conn = new mysqli($host, $username, $password);
	if ($conn->connect_error) die($conn->connect_error); 

	else // ** Если данные корректны и подключение к MySQL проходит благополучно: 
	// ****    Создаем базу данных, таблицы, тестовые записи, 
	// ****    сохраняем данные доступа к MySQL для дальнейшего использования
	{
		
		//let's create a database 
		$query = "CREATE DATABASE Resources";
		$result = $conn->query($query);
		if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";

		// select and use our database
		$query = "USE Resources";
		$result = $conn->query($query);
		if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";

		//let's create a table for registered users
		$query = "CREATE TABLE Users (username VARCHAR(64), password VARCHAR(256), email VARCHAR(64), PRIMARY KEY(username)) ENGINE MyISAM";
		$result = $conn->query($query);
		if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";

		//create test entry for Users
		$pass = password_hash('1', PASSWORD_DEFAULT); // => store in database
		$query = "INSERT INTO Users(username, password, email) VALUES('1','$pass','singletwin@inbox.ru')";
		$result = $conn->query($query);
		if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";


		//let's create a table or Operations
		$query = "CREATE TABLE Operations (entry_id INT NOT NULL AUTO_INCREMENT, account_numb INT, prodali_ot varchar(64), organization VARCHAR(64), bill_summ DECIMAL(21,2), paid_prc DECIMAL(5,2), paid DECIMAL(21,2), uderjanoli5prc VARCHAR(64), _5prc DECIMAL(21,2), nomerscheta VARCHAR(64), purchase_summ DECIMAL(21,2), nakl_kolvo SMALLINT, nakl_sum INT, transportnye DECIMAL(21,2), itogo_marja DECIMAL(21,2), prc_marji1 VARCHAR(5), prc_marji1_money DECIMAL(21,2), prc_marji2 VARCHAR(5), prc_marji2_money DECIMAL(21,2), prc_marji3 VARCHAR(5), prc_marji3_money DECIMAL(21,2), comment VARCHAR(512), dtc DATETIME, dtu DATETIME, upd_by VARCHAR(64), PRIMARY KEY(entry_id) ) ENGINE MyISAM";
		$result = $conn->query($query);
		if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";




		// put 2 test entries
		$query = "INSERT INTO Operations (account_numb, prodali_ot, organization, bill_summ, paid_prc, paid, uderjanoli5prc, _5prc, nomerscheta, purchase_summ, nakl_kolvo, nakl_sum, transportnye, itogo_marja, prc_marji1, prc_marji1_money, prc_marji2, prc_marji2_money, prc_marji3, prc_marji3_money, dtc) VALUES('999','ПРОТЕКТОР','avangard','223440.00','5.00','223480.00','удержано 5%','11170','108','177600.00','74','2960.0','6600.00','36320.00','10','3632','25', '9800', '60','24106','2020-07-28 12:12:12')";
		$result = $conn->query($query);
		if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";


		$query = "INSERT INTO Operations (account_numb, prodali_ot, organization, bill_summ, paid_prc, paid, uderjanoli5prc, _5prc, nomerscheta, purchase_summ, nakl_kolvo, nakl_sum, transportnye, itogo_marja, prc_marji1, prc_marji1_money, prc_marji2, prc_marji2_money, prc_marji3, prc_marji3_money, dtc) VALUES('1008','ИНТЕХ','avangard','223440.00','100','223480.00','нет','0','117','177600.00','0','0','6600.00','36320.00','10','3632','25', '9800', '60','24106','2020-07-28 14:14:14')";
		$result = $conn->query($query);
		if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";






		// ****** создадим файл соединения с MySQL для повсеместного использования  ******
		$fh = fopen("mysql.sys", 'w') or die("Создать файл конфигурации не удалось");
		$username = $_POST['username'];
		$host = $_POST['host'];
		$password = $_POST['password'];
		$database = "Resources";
		$text = <<<_END
$username
$host
$password
$database
_END;
		fwrite($fh, $text) or die("Сбой записи файла");
		fclose($fh);
		echo "<br>Файл конфигурации 'mysql.sys' записан успешно <br>";
		echo "<a href='/index.php'> Теперь можно пользоваться </a>";

	}





echo <<<_HTML
	</body>
</html>
_HTML;
}

?>