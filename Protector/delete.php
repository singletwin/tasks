<!DOCTYPE html>
<html>
	<head>
		<title>* Удаление записи *</title>
	</head>
	<body>
		<form method="POST" action="delete.php" onSubmit="if(!confirm('Уверены, удалить запись?')) { return false; }">
			<input type="text" name="account_numb" placeholder="номер счета записи, которую хотите удалить" title="номер счета записи, которую нужно удалить" size="30">
			<input type="hidden" name="delete" value="confirmed">
			<input type="submit" value="Удалить">
		</form>




<?php
// Test connection to mysql ______________________________________
$fh = fopen("mysql.sys", 'r') or die("Файл не существует или...");
$text = fread($fh, 180); fclose($fh);
$mysqlenter = explode("\n",$text);
$username = $mysqlenter[0]; $host = $mysqlenter[1]; $password = $mysqlenter[2]; $database = $mysqlenter[3];
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);

if (isset($_POST['delete']))
{
	$account_numb = $_POST['account_numb'];

	$query = "SELECT * FROM Operations WHERE account_numb = '$account_numb'";
	$result = $conn->query($query); // получаем объект mysqli_result object
	if (!$result) die (' ****** '.$conn->error.' ****** ');
	elseif ($conn->affected_rows == 0) die ('записи c таким номер счета не существует');
	else 
	{
		$log ='';
		$equal = "=";
		$fetch = mysqli_fetch_all($result, MYSQLI_ASSOC); // приводим объект в ассоциативный массив)
		foreach ($fetch[0] as $key => $value)
		{
			$log = $log.$key.$equal.$value." | ";
		}

		$date = date('Y')."-".date('m')."-".date('d')." ".date('H').":".date('i').":".date('s');
		$log = $date." <u>Удалено:</u> ".$log."\n";
		//var_dump($log);
		$file = "changes.log";
		file_put_contents($file, $log, FILE_APPEND);
	}

	$query = "delete from Operations where account_numb = '$account_numb' ";
	$result = $conn->query($query); // получаем объект mysqli_result object
	if (!$result) die (' ****** '.$conn->error.' ****** ');
	else echo "Запись удалена!";

}

?>


	</body>
</html>