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


session_start();
//$user=$_SESSION['username'];


var_dump($_POST);

$entry_id = $_POST['remove'];


$query="DELETE FROM kk WHERE entry_id=$entry_id";
$result = $conn->query($query);
if (!$result) die ($conn->error); 



$conn->close();
header('Location: http://localhost:3000/view.php');

?>