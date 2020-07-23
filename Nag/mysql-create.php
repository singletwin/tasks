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


// ****** создаем требуемые таблицы **********
$query = "CREATE TABLE clients (ID INT AUTO_INCREMENT, NAME TEXT(255), TYPE TINYINT, PRIMARY KEY(ID)) ENGINE MyISAM";
$result = $conn->query($query);
if (!$result) print ("<br>".$conn->error);
else echo "<br> table 'clients' created with success";

$query = "CREATE TABLE services (ID INT AUTO_INCREMENT, NAME TEXT(255), PRIMARY KEY(ID)) ENGINE MyISAM";
$result = $conn->query($query);
if (!$result) print ("<br>".$conn->error);
else echo "<br> table 'services' created with success";

$query = "CREATE TABLE paytypes (ID INT AUTO_INCREMENT, NAME TEXT(255), PRIMARY KEY(ID)) ENGINE MyISAM";
$result = $conn->query($query);
if (!$result) print ("<br>".$conn->error);
else echo "<br> table 'paytypes' created with success";

$query = "CREATE TABLE payments (ID INT AUTO_INCREMENT, CLIENT_ID INT, SUMMA DECIMAL(32,2), DATA DATE, DESCRIPTION TEXT(255), ACNT_ID INT, PAY_ID INT, PRIMARY KEY(ID)) ENGINE MyISAM";
$result = $conn->query($query);
if (!$result) print ("<br>".$conn->error);
else echo "<br> table 'payments' created with success";



// **********   заполняем таблицы тестовыми данными  *********
seed_clients();
seed_paytypes();
seed_services();
for ($y = 1998; $y <= 2019; $y++) // заполняем таблицу payments тестовыми данными , в период с 1998 по 2019
{
	for ($t = 1; $t <=10; $t++) seed_payments($y);
}





function seed_clients()
{
	global $conn;
	for ($ic = 1; $ic <=5; $ic++)
	{
		$clienttype = $ic%2;
		if ($clienttype == 0) $clienttype = 0;
		else $clienttype = 1;
		// ******** TYPE 1 = физ.лицо, TYPE 0 = юр.лицо
		$query = "INSERT INTO clients(NAME, TYPE) VALUES('client$ic','$clienttype')";
		$result = $conn->query($query);
		if (!$result) print ($conn->error);
	}
}

function seed_paytypes()
{
	global $conn;
		$query = "INSERT INTO paytypes(NAME) VALUES('Services Payment')";
		$result = $conn->query($query);
		if (!$result) print ($conn->error);

		$query = "INSERT INTO paytypes(NAME) VALUES('Calculation of the billing system')";
		$result = $conn->query($query);
		if (!$result) print ($conn->error);

		$query = "INSERT INTO paytypes(NAME) VALUES('Recalculation')";
		$result = $conn->query($query);
		if (!$result) print ($conn->error);

		$query = "INSERT INTO paytypes(NAME) VALUES('Bonus accrual')";
		$result = $conn->query($query);
		if (!$result) print ($conn->error);
}

function seed_services()
{
	global $conn;
		$query = "INSERT INTO services(NAME) VALUES('Internet')";
		$result = $conn->query($query);
		if (!$result) print ($conn->error);

		$query = "INSERT INTO services(NAME) VALUES('Telephone')";
		$result = $conn->query($query);
		if (!$result) print ($conn->error);

		$query = "INSERT INTO services(NAME) VALUES('Hosting')";
		$result = $conn->query($query);
		if (!$result) print ($conn->error);

		$query = "INSERT INTO services(NAME) VALUES('Television')";
		$result = $conn->query($query);
		if (!$result) print ($conn->error);

		$query = "INSERT INTO services(NAME) VALUES('Hardware Setup')";
		$result = $conn->query($query);
		if (!$result) print ($conn->error);

		$query = "INSERT INTO services(NAME) VALUES('Antivirus')";
		$result = $conn->query($query);
		if (!$result) print ($conn->error);
}




function seed_payments($year)
{
	global $conn;
	
	// ********  count clients *******
	if ($result = $conn->query('select ID from clients'))
	{
		$clientcount = $result->num_rows;
		//var_dump($clientcount);
	}


	for ($i = 1; $i <= 21; $i++)
	{
		$clientid = rand(1,$clientcount);
		//echo $clientid."<br>";

		$float = rand(0,99);
		$fl = strlen($float)==1? '0'.$float : $float;
		//echo $fl."<BR>";

		$summ = pow(-1,$i)*rand(0,100000).".".$fl; //положительные и отрицательные платежи
		//echo "summa =".$summ; echo "<br>";

		$mo = rand(1,12);
		$month = strlen($mo)==1? '0'.$mo : $mo;
		//echo $month."<br>";

		$d = rand(1,30);
		$day = strlen($d)==1? '0'.$d : $d;
		//echo $day."<br>";

		$h = rand(0,23);
		$hours = strlen($h)==1? '0'.$h : $h;
		//echo $hours."<br>";

		$min = rand(0,59);
		$minutes = strlen($min)==1? '0'.$min : $min;
		$sec = rand(0,59);
		$secs = strlen($sec)==1? '0'.$sec : $sec;

		if ($month==2 && $day>28) $day=28; // ЕСЛИ ФЕВРАЛЬ В НЕМ НЕТ 29 и 30 чисел
		$datetime = $year."-".$month."-".$day;

		$acntid = rand(1,6);
		$payid = rand(1,4);


		switch ($payid)
		{
			case 1:
			$summ=abs($summ);  //ЕСЛИ ОПЛАТА УСЛУГ
			break;
			case 3:
			$summ=0.1*($summ);  //ЕСЛИ перерасчет 
			break;
			case 4:
			$summ=abs($summ)*(-0.1); ////ЕСЛИ БОНУС_НАЧИСЛЕНИЕ
			break;
		}
		

		$query = "INSERT INTO payments(CLIENT_ID, SUMMA, DATA, DESCRIPTION, ACNT_ID, PAY_ID) VALUES('$clientid','$summ','$datetime','description...','$acntid','$payid')";
		$result = $conn->query($query);
		if (!$result) print ($conn->error); 
	}
}






  ?>