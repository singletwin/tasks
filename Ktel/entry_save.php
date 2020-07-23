<?php

// ------ ИНФОРМАЦИЯ ОБ ОШИБКАХ
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

 // Test connection to mysql ______________________________________
$fh = fopen("mysqlenter.txt", 'r') or die("Файл не существует или...");
$text = fread($fh, 180); fclose($fh);
$mysqlenter = explode("\n",$text);
$username = $mysqlenter[0]; $host = $mysqlenter[1]; $password = $mysqlenter[2]; $database = $mysqlenter[3];

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);

//--------------- параметры для Mysql ------------
$query1 = "SET NAMES 'cp1251'";
$result1 = $conn->query($query1);
$query2 = "SET CHARACTER SET 'cp1251'";
$result2 = $conn->query($query2);



session_start();
//$user=$_SESSION['username'];
//var_dump($_SESSION);



//var_dump($_POST);
$new = $_POST['new'];
$entry_id=$_POST['entry_id'];

$CB_city = iconv("UTF-8", "cp1251", $_POST['CB_city']);
$contract_number = $_POST['contract_number'];
$abonent = iconv("UTF-8", "cp1251", $_POST['abonent']);
$telephone = $_POST['telephone'];
$surname = iconv("UTF-8", "cp1251", $_POST['surname']);
$name = iconv("UTF-8", "cp1251", $_POST['name']);
$patronymic = iconv("UTF-8", "cp1251", $_POST['patronymic']);
$birthdate = $_POST['birthdate'];
$postindex = $_POST['postindex'];
$country = iconv("UTF-8", "cp1251", $_POST['country']);
$region = iconv("UTF-8", "cp1251", $_POST['region']);
$area_municipal_district = iconv("UTF-8", "cp1251", $_POST['area_municipal_district']);
$city = iconv("UTF-8", "cp1251", $_POST['city']);
$street = iconv("UTF-8", "cp1251", $_POST['street']);
$house_number= $_POST['house_number'];
$corpus = iconv("UTF-8", "cp1251", $_POST['corpus']);
$flat = $_POST['flat'];
$passport_series = $_POST['passport_series'];
$passport_number = $_POST['passport_number'];
$passport_issued_by = iconv("UTF-8", "cp1251", $_POST['passport_issued_by']);
$passport_issued_at = $_POST['passport_issued_at'];
$usage_point_address = iconv("UTF-8", "cp1251", $_POST['usage_point_address']);
$uridical_appeal_date = $_POST['uridical_appeal_date'];


date_default_timezone_set('UTC');
$dtu = date('Y')."-".date('m')."-".date('d')." ".date('H').":".date('i').":".date('s');
//var_dump($dtu);

$dtc = date('Y')."-".date('m')."-".date('d')." ".date('H').":".date('i').":".date('s');



if ( $new == 0 )
{
	$query = "UPDATE kk SET CB_city='$CB_city', contract_number='$contract_number', abonent='$abonent', telephone='$telephone', surname='$surname' , name='$name', patronymic='$patronymic', birthdate='$birthdate', postindex='$postindex', country='$country', region='$region', area_municipal_district='$area_municipal_district', city='$city', street='$street', house_number='$house_number', corpus='$corpus', flat='$flat', passport_series='$passport_series', passport_number='$passport_number', passport_issued_by='$passport_issued_by', passport_issued_at='$passport_issued_at', usage_point_address='$usage_point_address', uridical_appeal_date='$uridical_appeal_date', dtu='$dtu' WHERE entry_id='$entry_id'";
	$result = $conn->query($query);
	if (!$result) die ($conn->error);
}
elseif ( $new == 1 )
{
	$query = "INSERT INTO kk(CB_city, contract_number, abonent, telephone, surname, name, patronymic, birthdate, postindex, country, region, area_municipal_district, city, street, house_number, corpus, flat, passport_series, passport_number, passport_issued_by, passport_issued_at, usage_point_address, uridical_appeal_date, dtc) VALUES('$CB_city', '$contract_number', '$abonent', '$telephone', '$surname','$name', '$patronymic','$birthdate','$postindex','$country', '$region', '$area_municipal_district', '$city', '$street', '$house_number', '$corpus', '$flat', '$passport_series', '$passport_number', '$passport_issued_by', '$passport_issued_at', '$usage_point_address', '$uridical_appeal_date', '$dtc')";
	$result = $conn->query($query);
	if (!$result) die ($conn->error);
}


$conn->close();
header('Location: /view.php');

?>