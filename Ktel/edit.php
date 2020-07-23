<?php
session_start();

// Test connection to mysql ______________________________________
$fh = fopen("mysqlenter.txt", 'r') or die("Файл не существует или...");
$text = fread($fh, 180); fclose($fh);
$mysqlenter = explode("\n",$text);
$username = $mysqlenter[0]; $host = $mysqlenter[1]; $password = $mysqlenter[2]; $database = $mysqlenter[3];

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);

$query1 = "SET NAMES 'cp1251'";
$result1 = $conn->query($query1);

$query2 = "SET CHARACTER SET 'cp1251'";
$result2 = $conn->query($query2);



echo <<<_HTML
<!DOCTYPE html>
<html>
	<head>
		<title>Entries Edit Page</title>
	</head>
	<body>
_HTML;


// ------------ DATABASE QUERY 

if (isset($_POST['entry_id']))
{
	$entry_id = $_POST['entry_id'];
	$new = 0;


	$query = "select * from kk where entry_id = '$entry_id' ";
	$result = $conn->query($query); // получаем объект mysqli_result object
	if (!$result) die (' ****** '.$conn->error.' ****** ');
	$fetch = mysqli_fetch_all($result, MYSQLI_ASSOC); // приводим объект в ассоциативный массив


	$CB_city = iconv("cp1251", "UTF-8", $fetch[0]['CB_city']);
	$contract_number = $fetch[0]['contract_number'];
	$abonent = iconv("cp1251", "UTF-8", $fetch[0]['abonent']);
	$telephone = $fetch[0]['telephone'];
	$surname = iconv("cp1251", "UTF-8", $fetch[0]['surname']);
	$name = iconv("UTF-8", "cp1251", $fetch[0]['name']);
	$patronymic = iconv("cp1251", "UTF-8", $fetch[0]['patronymic']);
	$birthdate = $fetch[0]['birthdate'];
	$postindex = $fetch[0]['postindex'];
	$country = iconv("cp1251", "UTF-8", $fetch[0]['country']);
	$region = iconv("cp1251", "UTF-8", $fetch[0]['region']);
	$area_municipal_district = iconv("cp1251", "UTF-8", $fetch[0]['area_municipal_district']);
	$city = iconv("cp1251", "UTF-8", $fetch[0]['city']);
	$street = iconv("cp1251", "UTF-8", $fetch[0]['street']);
	$house_number= $fetch[0]['house_number'];
	$corpus = iconv("cp1251", "UTF-8", $fetch[0]['corpus']);
	$flat = $fetch[0]['flat'];
	$passport_series = $fetch[0]['passport_series'];
	$passport_number = $fetch[0]['passport_number'];
	$passport_issued_by = iconv("cp1251", "UTF-8", $fetch[0]['passport_issued_by']);
	$passport_issued_at = $fetch[0]['passport_issued_at'];
	$usage_point_address = iconv("cp1251", "UTF-8", $fetch[0]['usage_point_address']);
	$uridical_appeal_date = $fetch[0]['uridical_appeal_date'];
}
else 
{
	$new = 1;

	$queryn = "SELECT * FROM kk";
	$resultn = $conn->query($queryn);
	if (!$resultn) die (' ****** '.$conn->error.' ****** ');
	$fetchn = mysqli_fetch_all($resultn, MYSQLI_ASSOC); // приводим объект в ассоциативный массив
	$rescount = count($fetchn);


	$entry_id = $fetchn[$rescount-1]['entry_id']+1;
	//print_r($entry_id);


	$CB_city = '';
	$contract_number = '';
	$abonent = '';
	$telephone = '';
	$surname = '';
	$name = '';
	$patronymic = '';
	$birthdate = '';
	$postindex = '';
	$country = '';
	$region = '';
	$area_municipal_district = '';
	$city = '';
	$street = '';
	$house_number= '';
	$corpus = '';
	$flat = '';
	$passport_series = '';
	$passport_number = '';
	$passport_issued_by = '';
	$passport_issued_at = '';
	$usage_point_address = '';
	$uridical_appeal_date = '';
}


echo <<<_EDITFORM
	<form method='POST' action='entry_save.php' onSubmit="">
		Город БК <input type="text" name="CB_city" value='$CB_city' title='буквы, пробел, дефис ' pattern="[A-Za-zА-Яа-яЁё\s-]{2,63}"> 
		№ Договора <input type="text" name="contract_number" value='$contract_number' title='Цифры' pattern="[0-9]{3,63}" required><br>
		Наименование абонента <input type="text" name="abonent" value='$abonent' title='буквы, цифры, пробел, дефис' pattern="[0-9A-Za-zА-Яа-яЁё\s-]{2,127}" required><br>
		<br>

		№ телефона <input type="text" name="telephone" value='$telephone' title='11-15 цифр' pattern="[0-9]{11,15}"><br>
		Фамилия <input type="text" name="surname" value='$surname' title='буквы, дефис' pattern="[A-Za-zА-Яа-яЁё-]{2,127}" required> 
		Имя <input type="text" name="name" value='$name' title='буквы, дефис' pattern="[A-Za-zА-Яа-яЁё-\s]{2,127}" required> 
		Отчество <input type="text" name="patronymic" value='$patronymic' title='буквы, дефис' pattern="[A-Za-zА-Яа-яЁё-]{2,127}"><br>
		Дата рождения <input type="date" name="birthdate" value='$birthdate' title='Дата рождения' required><br>
		Почтовый идекс <input type="text" name="postindex" value='$postindex' title='цифры'  pattern="[0-9]{2,127}" required><br>
		Страна <input type="text" name="country" value='$country' title='буквы, пробел, дефис' pattern="[A-Za-zА-Яа-яЁё\s-]{2,127}" required><br>
		Область <input type="text" name="region" value='$region' title='буквы, пробел, дефис' pattern="[A-Za-zА-Яа-яЁё\s-]{2,127}" required><br>
		Район, муниципальный округ <input type="text" name="area_municipal_district" value='$area_municipal_district' title='буквы, пробел, дефис' pattern="[A-Za-zА-Яа-яЁё-\s]{2,127}"><br>
		Город/поселок/деревня/аул <input type="text" name="city" value='$city' title='буквы, пробел, дефис' pattern="[A-Za-zА-Яа-яЁё\s-]{2,127}" required><br>
		Улица <input type="text" name="street" value='$street' title='буквы, цифры, пробел, дефис' pattern="[0-9A-Za-zА-Яа-яЁё-]{2,127}" required><br>
		Номер дома, строение <input type="text" name="house_number" value='$house_number' title='цифры' pattern="[0-9]{1,10}"required><br>
		Корпус <input type="text" name="corpus" value='$corpus' title='буквы, цифры, дефис' pattern="[0-9A-Za-zА-Яа-яЁё-]{1,10}"><br>
		Квартира <input type="text" name="flat" value='$flat' title='буквы, цифры, дефис' pattern="[0-9A-Za-zА-Яа-яЁё-]{1,10}" required><br>
		Серия паспорта <input type="text" name="passport_series" value='$passport_series' title='4 цифры' pattern="[0-9]{4}" required><br>
		Номер паспорта <input type="text" name="passport_number" value='$passport_number' title='6 цифр'  pattern="[0-9]{6}" required><br>
		Кем выдан <input type="text" name="passport_issued_by" value='$passport_issued_by' title='буквы, цифры, пробел, дефис' pattern="[0-9A-Za-zА-Яа-яЁё\s-]{2,127}" required><br>
		Когда выдан <input type="date" name="passport_issued_at" value='$passport_issued_at' title='Когда выдан' required><br>
		Адрес точки, на которой ФЗ пользуется оконечным оборудованием ЮЛ <input type="text" name="usage_point_address" value='$usage_point_address' title='буквы, цифры, пробел, дефис, точка, запятая' pattern="[0-9A-Za-zА-Яа-яЁё\s\.\,-]{2,127}" required><br>
		Дата обращения Юр.лица <br>(дата предоставления сведений о пользователях оконечного оборудования) <input type="date" name="uridical_appeal_date" value="$uridical_appeal_date" title='Дата обращения Юр.лица (дата предоставления сведений о пользователях оконечного оборудования)' required><br>

		<input type="hidden" name="entry_id" value="$entry_id">
		<input type="hidden" name="new" value="$new">
		<input type="submit" value="save">

	</form>
_EDITFORM;

/*
if (isset($_POST['entry_id']))
{
	echo <<<_REM
	<button type="submit" name="remove" value="$entry_id" form="remove" onclick="if(!confirm('Are you sure want to remove the entry?')) { return false; }">remove
		<form id="remove" method="post" action="entry_delete.php"></form>
	</button>
_REM;
}
*/





echo <<<_HTMLEND
		<span id="links" style="position: relative; top: 50px; left: 350px;">
		<button type="submit" form="mainmenu"> <u style="color: #440077"> > Go to main menu < </u></a>
			<form id="mainmenu" method="post" action="index.php">
				<input type="hidden" name="username" value="valid">
				<input type="hidden" name="password" value="valid">
			</form>
		</button>
		<button><a href='exit.php'> Exit </a></button>
		</span>
	</body>
</html>
_HTMLEND;


?>