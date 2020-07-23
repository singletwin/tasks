<?php
session_start();

date_default_timezone_set('UTC');
$dtc = date('Y')."-".date('m')."-".date('d')." ".date('H').":".date('i').":".date('s');


echo <<<_HTML

<!DOCTYPE html>
<html id='indexhtml'>
	<head>
		<title>Installation page</title>
	</head>
	<body>
<h3>Давайте создадим базу данных с кодировкой Windows 1251, если у вас её нет</h3>
<br>

<span>Введите данные для доступа к MySQL:</span>
<br>
<form method="post" action="install.php">
	<input type="text" size="8" maxlength="64" name="username0" title='username' placeholder='username'>
	<input type="text" size="8" maxlength="64" name="host0" title='host' placeholder='host'>
	<input type='password' size="8" maxlength="64" name="password0" title='password' placeholder='password' >
	<input type="text" size="8" maxlength="64" name="database0" title='database' placeholder='database'>
	<input type="submit" value=" Create Database ">
</form>



<br><br>
<h3>Создадим в базе данных таблицу 'kk' в соответствии с требованиями , с одной тестовой записью</h3>
<br>

<span>Заполните, пожалуйста, форму для доступа к  базе данных:</span>
<br>
<form method="post" action="install.php">
	<input type="text" size="8" maxlength="64" name="username" title='username' placeholder='username'>
	<input type="text" size="8" maxlength="64" name="host" title='host' placeholder='host'>
	<input type='password' size="8" maxlength="64" name="password" title='password' placeholder='password' >
	<input type="text" size="8" maxlength="64" name="database" title='database' placeholder='database'>
	<input type="submit" value=" Create Table in Database ">
</form>
_HTML;


if ( (isset($_POST['username0'])) OR (isset($_POST['host0'])) OR (isset($_POST['password0'])) OR (isset($_POST['database0'])) )
{
		// Test connection to mysql ______________________________________
	$con = new mysqli($_POST['host0'], $_POST['username0'], $_POST['password0'], '');
	if ($con->connect_error) die($con->connect_error);

	$db = $_POST['database0'];
	//$query	= "CREATE DATABASE ktel CHARACTER SET 'cp1251'";
	$result = $con->query("CREATE DATABASE $db CHARACTER SET 'cp1251'");
	if (!$result) echo "<br><br>Сбой операции: $query<br>  *********** ".$con->error." *********** <br><br>";
	else 
	{
		echo "<br><br> *********       SUCCEESS!";
	}


	$con->close();
}



if ( (isset($_POST['username'])) OR (isset($_POST['host'])) OR (isset($_POST['password'])) OR (isset($_POST['database'])) )
{
	//echo "isset "; var_dump($_POST);
	echo "<br>";


	// Test connection to mysql ______________________________________
	$conn = new mysqli($_POST['host'], $_POST['username'], $_POST['password'], $_POST['database']);
	if ($conn->connect_error) die($conn->connect_error);


//******************* ЕСЛИ ТАБЛИЦА УЖЕ СУЩЕСТВУЕТ **********
/*
	$query0 = "DROP TABLE IF EXISTS kk";
	$result0 = $conn->query($query0);
	if (!$result0) echo "Сбой при получении данных: $query0<br>  *********** ".$conn->error." *********** <br><br>";
*/


	$query1 = "CREATE TABLE kk (entry_id INT NOT NULL AUTO_INCREMENT, 
	CB_city VARCHAR(64) default NULL, 
	contract_number VARCHAR(64), 
	abonent varchar(128),
	telephone varchar(15) default NULL,
	surname varchar(128),
	name varchar(128),
	patronymic varchar(128) default NULL,
	birthdate DATE,
	postindex varchar(128),
	country varchar(128),
	region varchar(128),
	area_municipal_district varchar(128) default NULL,
	city varchar(128),
	street varchar(128),
	house_number varchar(128),
	corpus varchar(128) default NULL,
	flat varchar(128),
	passport_series varchar(16),
	passport_number varchar(16),
	passport_issued_by varchar(128),
	passport_issued_at DATE,
	usage_point_address varchar(1024),
	uridical_appeal_date DATE,
	dtc DATETIME,
	dtu DATETIME,
	PRIMARY KEY (entry_id) ) 
	ENGINE MyISAM";
	$result1 = $conn->query($query1);
	if (!$result1) 
	{
		echo "Сбой операции: CREATE TABLE.....<br>  *********** ".$conn->error."  *********** <br><br>";
		echo "<br><br> <a href='index.php'>Похоже, можно пользоваться...</a>";
	}
	else 
	{
		//создаем тестовую запись
		$query2 = "INSERT INTO kk (CB_city, contract_number, abonent, telephone, surname, name, patronymic, birthdate, postindex, country, region, area_municipal_district, city, street, house_number, corpus, flat, passport_series, passport_number, passport_issued_by, passport_issued_at, usage_point_address, uridical_appeal_date, dtc) VALUES('Ekaterinburg', '1234567890', 'abonent', '11111111111', 'surname','name', 'patronymic','1985-11-11','666666','country', 'region', 'areamunicipaldistrict', 'city', 'street', '1', '2', '3', '4444', '666666', 'passportissued', '1999-1-1', 'usagepointaddress', '1999-1-1', '$dtc')";
		$result2 = $conn->query($query2);
		if (!$result2) echo $conn->error;

		echo "<br><br> *********       SUCCEESS!";
		echo "<br><br> <a href='index.php'>Теперь можно пользоваться...</a>";
		
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



}
else 
	{ 
		//echo "not set";
	}


 

//var_dump($conn->get_charset());
//var_dump(mysqli_character_set_name($conn));



echo <<<_HTMLEND
	</body>
</html>
_HTMLEND;
?>