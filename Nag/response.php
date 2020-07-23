<?php

		//*** объявим используемые переменные***
$inetprihod = $inetrashod = $inetpere = 0;
$phoneprihod = $phonerashod = $phonepere = 0;
$hostingprihod = $hostingrashod = $hostingpere = 0;
$televprihod = $televrashod = $televpere = 0;
$hsetprihod = $hsetrashod = $hsetpere = 0;
$antivprihod = $antivrashod = $antivpere = 0;
$lastinet = $lastphone = $lasthosting = $lasttelev = $lasthset = $lastantiv = 0;
$itoginet = $itogphone = $itoghosting = $itogtelev = $itoghset = $itogantiv = 0;


// Test connection to mysql ______________________________________
$fh = fopen("mysqlenter.txt", 'r') or die("Файл не существует или...");
$text = fread($fh, 180); fclose($fh);
$mysqlenter = explode("\n",$text);
$username = $mysqlenter[0]; $host = $mysqlenter[1]; $password = $mysqlenter[2]; $database = $mysqlenter[3];

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);




if (isset($_GET['m']))
{
	strlen($_GET['m'])<2? $month = "0".$_GET['m'] : $month = $_GET['m'];
	$year = $_GET['y'];
	$client_type = $_GET['ct'];
	//var_dump($_GET);
}




// *******  запрос к базе данных ******
$query = "
	SELECT DATA, SUMMA, PAY_ID, ACNT_ID, NAME, ( select SUM(SUMMA) from payments WHERE DATA<'$year-$month' AND ACNT_ID=services.ID) startbalance 
	FROM payments, services 
	WHERE ACNT_ID=services.ID
		AND payments.DATA LIKE '$year-$month%' 
	ORDER BY ACNT_ID
		";





$result = $conn->query($query);
if (!$result) print ($conn->error);
$fetch = mysqli_fetch_all($result, MYSQLI_ASSOC); // приводим объект в ассоциативный массив
//print(var_dump($fetch)."<br>");


// проходим по каждому результату
foreach ($fetch as $res)
{
	// Считаем для каждой услуги : приход, расход, перерасчет, итог
	if ($res['NAME'] == "Internet")
	{
		if ($res['PAY_ID'] == 1) { $inetprihod = $inetprihod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 2 && $res['SUMMA'] > 0) { $inetprihod = $inetprihod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 2 && $res['SUMMA'] < 0) { $inetrashod = $inetrashod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 3) { $inetpere = $inetpere + $res['SUMMA']; }
		if ($res['PAY_ID'] == 4) { $inetrashod = $inetrashod + $res['SUMMA']; }
		$lastinet = $res['startbalance'];
	}


	if ($res['NAME'] == "Telephone")
	{
		if ($res['PAY_ID'] == 1) { $phoneprihod = $phoneprihod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 2 && $res['SUMMA'] > 0) { $phoneprihod = $phoneprihod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 2 && $res['SUMMA'] < 0) { $phonerashod = $phonerashod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 3) { $phonepere = $phonepere + $res['SUMMA']; }
		if ($res['PAY_ID'] == 4) { $phonerashod = $phonerashod + $res['SUMMA']; }
		$lastphone = $res['startbalance'];
	}


	if ($res['NAME'] == "Hosting")
	{
		if ($res['PAY_ID'] == 1) { $hostingprihod = $hostingprihod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 2 && $res['SUMMA'] > 0) { $hostingprihod = $hostingprihod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 2 && $res['SUMMA'] < 0) { $hostingrashod = $hostingrashod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 3) { $hostingpere = $hostingpere + $res['SUMMA']; }
		if ($res['PAY_ID'] == 4) { $hostingrashod = $hostingrashod + $res['SUMMA']; }
		$lasthosting = $res['startbalance'];
	}


	if ($res['NAME'] == "Television")
	{
		if ($res['PAY_ID'] == 1) { $televprihod = $televprihod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 2 && $res['SUMMA'] > 0) { $televprihod = $televprihod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 2 && $res['SUMMA'] < 0) { $televrashod = $televrashod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 3) { $televpere = $televpere + $res['SUMMA']; }
		if ($res['PAY_ID'] == 4) { $televrashod = $televrashod + $res['SUMMA']; }
		$lasttelev = $res['startbalance'];
	}


	if ($res['NAME'] == "Hardware Setup")
	{
		if ($res['PAY_ID'] == 1) { $hsetprihod = $hsetprihod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 2 && $res['SUMMA'] > 0) { $hsetprihod = $hsetprihod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 2 && $res['SUMMA'] < 0) { $hsetrashod = $hsetrashod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 3) { $hsetpere = $hsetpere + $res['SUMMA']; }
		if ($res['PAY_ID'] == 4) { $hsetrashod = $hsetrashod + $res['SUMMA']; }
		$lasthset = $res['startbalance'];
	}


	if ($res['NAME'] == "Antivirus")
	{
		if ($res['PAY_ID'] == 1) { $antivprihod = $antivprihod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 2 && $res['SUMMA'] > 0) { $antivprihod = $antivprihod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 2 && $res['SUMMA'] < 0) { $antivrashod = $antivrashod + $res['SUMMA']; }
		if ($res['PAY_ID'] == 3) { $antivpere = $antivpere + $res['SUMMA']; }
		if ($res['PAY_ID'] == 4) { $antivrashod = $antivrashod + $res['SUMMA']; }
		$lastantiv = $res['startbalance'];
	}

}
		

		
// 		***************  если в выбранном месяце никаких платежей по данной услуге , 
// 		***************  придется сделать отдельный запрос для подсчета суммы на начало периода. 
		if ($lastinet == 0) 
		{ 
			$query = "SELECT SUM(SUMMA) from payments WHERE DATA<'$year-$month' AND ACNT_ID='1'";
			$result = $conn->query($query);
			if (!$result) print ($conn->error);
			$lastinet = mysqli_fetch_row($result);
			$lastinet = $lastinet[0];
			if ($lastinet == NULL) $lastinet = 0; // баланс на начало первого учетного месяца = 0 
		}


		if ($lastphone == 0) 
		{ 
			$query = "SELECT SUM(SUMMA) from payments WHERE DATA<'$year-$month' AND ACNT_ID='2'";
			$result = $conn->query($query);
			if (!$result) print ($conn->error);
			$lastphone = mysqli_fetch_row($result);
			$lastphone = $lastphone[0];
			if ($lastphone == NULL) $lastphone = 0; // баланс на начало первого учетного месяца = 0 
		}


		if ($lasthosting == 0) 
		{ 
			$query = "SELECT SUM(SUMMA) from payments WHERE DATA<'$year-$month' AND ACNT_ID='3'";
			$result = $conn->query($query);
			if (!$result) print ($conn->error);
			$lasthosting = mysqli_fetch_row($result);
			$lasthosting = $lasthosting[0];
			if ($lasthosting == NULL) $lasthosting = 0; // баланс на начало первого учетного месяца = 0 
		}


		if ($lasttelev == 0) 
		{ 
			$query = "SELECT SUM(SUMMA) from payments WHERE DATA<'$year-$month' AND ACNT_ID='4'";
			$result = $conn->query($query);
			if (!$result) print ($conn->error);
			$lasttelev = mysqli_fetch_row($result);
			$lasttelev = $lasttelev[0];
			if ($lasttelev == NULL) $lasttelev = 0;  // баланс на начало первого учетного месяца = 0 
		}


		if ($lasthset == 0) 
		{ 
			$query = "SELECT SUM(SUMMA) from payments WHERE DATA<'$year-$month' AND ACNT_ID='5'";
			$result = $conn->query($query);
			if (!$result) print ($conn->error);
			$lasthset = mysqli_fetch_row($result);
			$lasthset = $lasthset[0];
			if ($lasthset == NULL) $lasthset = 0; // баланс на начало первого учетного месяца = 0 
		}


		if ($lastantiv == 0) 
		{ 
			$query = "SELECT SUM(SUMMA) from payments WHERE DATA<'$year-$month' AND ACNT_ID='6'";
			$result = $conn->query($query);
			if (!$result) print ($conn->error);
			$lastantiv = mysqli_fetch_row($result);
			$lastantiv = $lastantiv[0];
			if ($lastantiv == NULL) $lastantiv = 0; // баланс на начало первого учетного месяца = 0 
		}





//  *******  вычисляем итог по каждой услуге на данный период
		$itoginet = $lastinet + $inetprihod + $inetrashod + $inetpere;
		$itogphone = $lastphone + $phoneprihod + $phonerashod + $phonepere;
		$itoghosting = $lasthosting + $hostingprihod + $hostingrashod + $hostingpere;
		$itogtelev = $lasttelev + $televprihod + $televrashod + $televpere;
		$itoghset = $lasthset + $hsetprihod + $hsetrashod + $hsetpere;
		$itogantiv = $lastantiv + $antivprihod + $antivrashod + $antivpere;
		





//создаем отчет в виде таблицы
echo <<<_TABLE
<table border="1">
	<caption>Отчет по каждой услуге</caption>
	<tr>
		<th>Услуга</th>
		<th>Баланс на начало периода</th>
		<th>Приход</th>
		<th>Расход</th>
		<th>Перерасчет</th>
		<th>Итого</th>
	</tr>
	<tr><td>Интернет</td><td>$lastinet</td><td>$inetprihod</td><td>$inetrashod</td><td>$inetpere</td><td>$itoginet</td></tr>
	<tr><td>Телефония</td><td>$lastphone</td><td>$phoneprihod</td><td>$phonerashod</td><td>$phonepere</td><td>$itogphone</td></tr>
	<tr><td>Хостинг</td><td>$lasthosting</td><td>$hostingprihod</td><td>$hostingrashod</td><td>$hostingpere</td><td>$itoghosting</td></tr>
	<tr><td>Телевидение</td><td>$lasttelev</td><td>$televprihod</td><td>$televrashod</td><td>$televpere</td><td>$itogtelev</td></tr>
	<tr><td>Настройка оборудования</td><td>$lasthset</td><td>$hsetprihod</td><td>$hsetrashod</td><td>$hsetpere</td><td>$itoghset</td></tr>
	<tr><td>Антивирус</td><td>$lastantiv</td><td>$antivprihod</td><td>$antivrashod</td><td>$antivpere</td><td>$itogantiv</td></tr>
</table>
_TABLE;



?>