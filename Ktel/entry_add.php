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

$query1 = "SET NAMES 'cp1251'";
$result1 = $conn->query($query1);
$query2 = "SET CHARACTER SET 'cp1251'";
$result2 = $conn->query($query2);


session_start();
//$user=$_SESSION['username'];


date_default_timezone_set('UTC');
$dtc = date('Y')."-".date('m')."-".date('d')." ".date('H').":".date('i').":".date('s');




$conn->close();
header('Location: http://localhost:3000/edit.php');

?>