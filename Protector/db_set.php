<?php
// ------ ИНФОРМАЦИЯ ОБ ОШИБКАХ
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);




// Test connection to mysql ______________________________________
$conn = new mysqli('localhost', 'root', '4Mdefpnu!');
if ($conn->connect_error) die($conn->connect_error); 


//let's create a database
$query = "CREATE DATABASE Resources";
$result = $conn->query($query);
if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";

// select and use our database
$query = "USE Resources";
$result = $conn->query($query);
if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";

//let's create a table for registered users
$query = "CREATE TABLE Users (username VARCHAR(64), password VARCHAR(256), email VARCHAR(64)) ENGINE MyISAM";
$result = $conn->query($query);
if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";


//let's create a table in database
$query = "CREATE TABLE Operations (entry_id INT NOT NULL AUTO_INCREMENT, client VARCHAR(64), otgruzka INT, zatraty VARCHAR(64), usloviya VARCHAR(256), status VARCHAR(64), mine VARCHAR(64), account_numb INT, prodali_ot varchar(64), organization VARCHAR(64), bill_summ DECIMAL(19,2), paid_prc TINYINT, paid DECIMAL(19,2), uderjanoli5prc SMALLINT, 5prc DECIMAL(19,2), nomerscheta VARCHAR(64), purchase_summ DECIMAL(19,2), nakl_kolvo SMALLINT, nakl_sum DECIMAL(19,2), transportnye DECIMAL(19,2), itogo_marja DECIMAL(19,2), 30prc_marji DECIMAL(19,2), 40prc_marji DECIMAL(19,2), 60prc_marji DECIMAL(19,2), account1 INT, account2 INT, account3 INT, dtc DATETIME, dtu DATETIME, upd_by VARCHAR(64), PRIMARY KEY(entry_id) ) ENGINE MyISAM";
$result = $conn->query($query);
if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";


?>