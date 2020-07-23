<?php
session_start();

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



echo <<<_HTML
<!DOCTYPE html>
<html>
	<head>
		<script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
		<title>Entries View Page</title>
	</head>
	<body>
_HTML;


// ------------ DATABASE QUERY 
$query = "SELECT * FROM kk";
$result = $conn->query($query);
if (!$result) die (' ****** '.$conn->error.' ****** ');




$fetch = mysqli_fetch_all($result, MYSQLI_ASSOC); // приводим объект в ассоциативный массив

//var_dump($fetch);
$numb = 0;
$last = 0;
$pagecount = 0;
$count = count($fetch);
$lastpage = $count%3;
if ($count > 3) 
{
	if ($count%3 != 0)
	{
		$pagecount = ( ( $count-($lastpage) )/3 ) +1;
	}
	else
	{
		$pagecount = $count/3;
	}
}
else { showall(); }
	
echo "<br> ------ Total number of entries = ".count($fetch)."; ".$pagecount." pages; <br>";




//print_r($_GET);

if ( !isset($_GET['p']) AND !isset($_GET['all']) AND $count>3 )
{
	echo " <b> Plese select a page of results to show </b><br>";

}
elseif ( (isset($_GET['p'])) AND (!isset($_GET['last'])) AND (!isset($_GET['all'])) )
{
	showentries($last);
}
elseif ( (isset($_GET['last'])) )
{
	//echo "lastpage";
	if ($lastpage != 0)
	{
		$last = 3-$lastpage;
	}
	else { $last = 0; }
	showentries($last);
}
if ( isset($_GET['all']) ) //AND $_GET['all'] == "true" )
{
	showall();
}






echo <<<_HTMLEND
		<br>
		<div id="pag">Pagination by 3 results on page: </div>

		<span id="links" style="position: relative; top: 50px; left: 350px;">
		<button type="submit" form="mainmenu"> <u style="color: #440077"> > Go to main menu < </u>
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







// ************  paginaciya

for ($page = 1; $page <= $pagecount; $page++)
{
	$pa = (($page-1)*3)+1 . "-".$page*3;
	echo <<<_PAGE
	<script>
 	var ael$page = document.createElement('a'); 
    var href$page = document.createAttribute('href');
    </script>
_PAGE;
	if ($page == $pagecount)
	{
		echo <<<_PAGEl
		<script>
		href$page.value = "/view.php?p=$page&last=true";
		</script>
_PAGEl;
	}
	else
	{
		echo <<<_PAGE2
	    <script>
	    href$page.value = "/view.php?p=$page";
	    </script>
_PAGE2;
	}

echo <<<_PAGE
    <script>
    ael$page.setAttributeNode(href$page);
    ael$page.innerText = ' $page($pa) ';

    document.getElementById('pag').appendChild(ael$page);
    </script>
_PAGE;
}






//********* SHOW ALL ENTRIES link
if ($count>3)
{
echo <<<_VSE
	<script>
		var allel = document.createElement('a');
		var href = document.createAttribute('href');
		href.value = "/view.php?all=true";
		allel.setAttributeNode(href);
		allel.innerText = ' show all entries!';
		document.getElementById('pag').after(allel);
	</script>
_VSE;
}





//************************* SHOW PAGINATED ENTIR+ES
function showentries($last)
{
	global $fetch;


	for ($q = 3; $q >= (1+$last); $q--)
	{
		$entry = ( $_GET['p']*3 ) - $q;
		$entry1 = ( $_GET['p']*3 ) - $q +1;


		$CB_city = iconv("cp1251", "UTF-8", $fetch[$entry]['CB_city']);
		$contract_number = $fetch[$entry]['contract_number'];
		$abonent = iconv("cp1251", "UTF-8", $fetch[$entry]['abonent']);
		$telephone = $fetch[$entry]['telephone'];
		$surname = iconv("cp1251", "UTF-8", $fetch[$entry]['surname']);
		$name = iconv("cp1251", "UTF-8", $fetch[$entry]['name']);
		$patronymic = iconv("cp1251", "UTF-8", $fetch[$entry]['patronymic']);
		$birthdate = $fetch[$entry]['birthdate'];
		$postindex = $fetch[$entry]['postindex'];
		$country = iconv("cp1251", "UTF-8", $fetch[$entry]['country']);
		$region = iconv("cp1251", "UTF-8", $fetch[$entry]['region']);
		$area_municipal_district = iconv("cp1251", "UTF-8", $fetch[$entry]['area_municipal_district']);
		$city = iconv("cp1251", "UTF-8", $fetch[$entry]['city']);
		$street = iconv("cp1251", "UTF-8", $fetch[$entry]['street']);
		$house_number= $fetch[$entry]['house_number'];
		$corpus = iconv("cp1251", "UTF-8", $fetch[$entry]['corpus']);
		$flat = $fetch[$entry]['flat'];
		$passport_series = $fetch[$entry]['passport_series'];
		$passport_number = $fetch[$entry]['passport_number'];
		$passport_issued_by = iconv("cp1251", "UTF-8", $fetch[$entry]['passport_issued_by']);
		$passport_issued_at = $fetch[$entry]['passport_issued_at'];
		$usage_point_address = iconv("cp1251", "UTF-8", $fetch[$entry]['usage_point_address']);
		$uridical_appeal_date = $fetch[$entry]['uridical_appeal_date'];

		$dtu = $fetch[$entry]['dtu'];
		$dtc = $fetch[$entry]['dtc'];
		$entry_id = $fetch[$entry]['entry_id'];

	echo <<<_VIEWENTRIES
			<span id='viewspan$entry'> $entry1 , Ф.И.О. -> $surname $name $patronymic | Modifiyed: $dtu | Created: $dtc </span>
			<button id='togl$entry'>VIEW \ HIDE</button>
			<button id='fm$entry' onclick="document.getElementById('viewform$entry').submit();"> EDIT 
			<form id='viewform$entry' method='POST' action='edit.php'>
				<input type="hidden" name="entry_id" value="$entry_id">
			</form>
			</button>
			<br>
			<!--- <button id="removeb$entry" type="submit" name="remove" value="$entry_id" form="remove$entry" onclick="if(!confirm('Are you sure want to remove the entry?')) { return false; }"> DELETE
				<form id="remove$entry" method="post" action="entry_delete.php"></form>
			</button> --->


			<div id='viewdiv$entry' style='display: none; border: 3px solid #3399BB; padding: 10px; padding-bottom: 15px;'>
				Город БК - $CB_city <br>
				№ Договора - $contract_number <br>
				Наименование абонента - $abonent <br>
				№ телефона - $telephone <br>
				Фамилия - $surname <br>
				Имя - $name <br>
				Отчество - $patronymic <br>
				Дата рождения - $birthdate <br>
				Почтовый индекс - $postindex <br>
				Страна - $country <br>
				Область - $region <br>
				Район, муниципальный округ - $area_municipal_district <br>
				Город - $city <br>
				Улица - $street <br>
				Номер дома, строение - $house_number  <br>
				Корпус - $corpus <br>
				Квартира - $flat <br>
				Серия паспорта - $passport_series <br>
				Номер паспорта - $passport_number <br>
				Кем выдан - $passport_issued_by <br>
				Когда выдан - $passport_issued_at <br>
				Адрес точки, на которой ФЗ пользуется оконечным оборудованием ЮЛ - $usage_point_address <br>
				Дата обращения Юр.лица (дата предоставления сведений о пользователях оконечного оборудования) - $uridical_appeal_date <br>
			</div>
			<script>
				$('#togl$entry').click(function() { $('#viewdiv$entry').toggle('slow', 'linear') });
			</script>
_VIEWENTRIES;
	}
}












//************ SHOW ALL ENTRIES
function showall()
{
	global $numb;
	global $fetch;
	// ******************************* VSE RESULTATY !!!!
	foreach($fetch as $res)
	{
		$numb = $numb+1;

	$CB_city = iconv("cp1251", "UTF-8", $res['CB_city']);
	$contract_number = $res['contract_number'];
	$abonent = iconv("cp1251", "UTF-8", $res['abonent']);
	$telephone = $res['telephone'];
	$surname = iconv("cp1251", "UTF-8", $res['surname']);
	$name = iconv("cp1251", "UTF-8", $res['name']);
	$patronymic = iconv("cp1251", "UTF-8", $res['patronymic']);
	$birthdate = $res['birthdate'];
	$postindex = $res['postindex'];
	$country = iconv("cp1251", "UTF-8", $res['country']);
	$region = iconv("cp1251", "UTF-8", $res['region']);
	$area_municipal_district = iconv("cp1251", "UTF-8", $res['area_municipal_district']);
	$city = iconv("cp1251", "UTF-8", $res['city']);
	$street = iconv("cp1251", "UTF-8", $res['street']);
	$house_number= $res['house_number'];
	$corpus = iconv("cp1251", "UTF-8", $res['corpus']);
	$flat = $res['flat'];
	$passport_series = $res['passport_series'];
	$passport_number = $res['passport_number'];
	$passport_issued_by = iconv("cp1251", "UTF-8", $res['passport_issued_by']);
	$passport_issued_at = $res['passport_issued_at'];
	$usage_point_address = iconv("cp1251", "UTF-8", $res['usage_point_address']);
	$uridical_appeal_date = $res['uridical_appeal_date'];

	$dtu = $res['dtu'];
	$dtc = $res['dtc'];
	$entry_id = $res['entry_id'];

		echo <<<_VIEWENTRIES
				<span id='viewspan$numb'> $numb , Ф.И.О. -> $surname $name $patronymic | Modifiyed: $dtu | Created: $dtc </span>
				<button id='togl$numb'>VIEW \ HIDE</button>
				<button id='fm$numb' onclick="document.getElementById('viewform$numb').submit();"> EDIT 
				<form id='viewform$numb' method='POST' action='edit.php'>
					<input type="hidden" name="entry_id" value="$entry_id">
				</form>
				</button>
				<br>
				<!--- <button id="removeb$numb" type="submit" name="remove" value="$entry_id" form="remove$numb" onclick="if(!confirm('Are you sure want to remove the entry?')) { return false; }"> DELETE
					<form id="remove$numb" method="post" action="entry_delete.php"></form>
				</button> --->


				<div id='viewdiv$numb' style='display: none; border: 3px solid #3399BB; padding: 10px; padding-bottom: 15px;'>
					Город БК - $CB_city <br>
					№ Договора - $contract_number <br>
					Наименование абонента - $abonent <br>
					№ телефона - $telephone <br>
					Фамилия - $surname <br>
					Имя - $name <br>
					Отчество - $patronymic <br>
					Дата рождения - $birthdate <br>
					Почтовый индекс - $postindex <br>
					Страна - $country <br>
					Область - $region <br>
					Район, муниципальный округ - $area_municipal_district <br>
					Город - $city <br>
					Улица - $street <br>
					Номер дома, строение - $house_number  <br>
					Корпус - $corpus <br>
					Квартира - $flat <br>
					Серия паспорта - $passport_series <br>
					Номер паспорта - $passport_number <br>
					Кем выдан - $passport_issued_by <br>
					Когда выдан - $passport_issued_at <br>
					Адрес точки, на которой ФЗ пользуется оконечным оборудованием ЮЛ - $usage_point_address <br>
					Дата обращения Юр.лица (дата предоставления сведений о пользователях оконечного оборудования) - $uridical_appeal_date <br>
				</div>
				<script>
					$('#togl$numb').click(function() { $('#viewdiv$numb').toggle('slow', 'linear') });
				</script>


_VIEWENTRIES;

	}
}






?>