<?php
// ------ ИНФОРМАЦИЯ ОБ ОШИБКАХ
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

session_start();

//var_dump($_SESSION);
$username = $_SESSION['username'];
$password = $_SESSION['password'];


echo "<br>";




// Test connection to mysql ______________________________________
$fh = fopen("mysql.sys", 'r') or die("Файл не существует или...");
$text = fread($fh, 180); fclose($fh);
$mysqlenter = explode("\n",$text);
$username = $mysqlenter[0]; $host = $mysqlenter[1]; $password = $mysqlenter[2]; $database = $mysqlenter[3];
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);




echo <<<_HTML
<!DOCTYPE html>
<html>
	<head>
		<title>*Просмотр, редакция*</title>
	</head>
	<body>
_HTML;



// ------------ DATABASE QUERY 
$query = "SELECT * FROM Operations ORDER BY dtc";
$result = $conn->query($query);
if (!$result) die (' ****** '.$conn->error.' ****** ');


$fetch = mysqli_fetch_all($result, MYSQLI_ASSOC); // приводим объект в ассоциативный массив

//		<caption> Отгрузки табличка </caption>

//print_r("results count = ".count($fetch)."<br>");
echo "Доброго времени суток! На этой странице представлена таблица со всеми записями. <br> Чтобы внести изменения: <b> кликните правой клавишей мыши по соответствующей строке. </b><br><br>";
echo <<<_T
	<table border="1">

		<tr>
			<th>№ счета</th>
			<th>Продали от</th>
			<th>Организация</th>
			<th>Сумма счета</th>
			<th>Оплачено %</th>
			<th>Оплачено рублей</th>
			<th>Удержано ли 5% ?</th>
			<th>5% в рублях</th>
			<th>№ счета \ счетов</th>
			<th>Сумма закупа</th>
			<th>Кол-во наклеек</th>
			<th>Сумма за наклейки</th>
			<th>Транспортные</th>
			<th>Итого маржа</th>
			<th>% от маржи (1)</th>
			<th>% маржи (1) в деньгах</th>
			<th>% маржи (2)</th>
			<th>% маржи (2) в деньгах</th>
			<th>% маржи (3)</th>
			<th>% маржи (3) в деньгах</th>
			<th>Комментарий</th>
			<th>Запись создана</th>
			<th>Запись изменена</th>
			<th>Внес изменения</th>
		</tr>
_T;

foreach ($fetch as $res)
{
	$entry_id = $res['entry_id'];


	$account_numb = $res['account_numb'];
	$prodali_ot = $res['prodali_ot'];
	$organization = $res['organization'];
	$bill_summ = $res['bill_summ'];
	$paid_prc = $res['paid_prc'];
	$paid = $res['paid'];
	$uderjanoli5prc = $res['uderjanoli5prc'];
	$_5prc = $res['_5prc'];
	$nomerscheta = $res['nomerscheta'];
	$purchase_summ = $res['purchase_summ'];
	$nakl_kolvo = $res['nakl_kolvo'];
	$nakl_sum = $res['nakl_sum'];
	$transportnye = $res['transportnye'];
	$itogo_marja = $res['itogo_marja'];
	$prc_marji1 = $res['prc_marji1'];
	$prc_marji1_money = $res['prc_marji1_money'];
	$prc_marji2 = $res['prc_marji2'];
	$prc_marji2_money = $res['prc_marji2_money'];
	$prc_marji3 = $res['prc_marji3'];
	$prc_marji3_money = $res['prc_marji3_money'];
	$comment = $res['comment'];
	$dtc = $res['dtc'];
	$dtu = $res['dtu'];
	$upd_by = $res['upd_by'];


	echo <<<_T
		<form id = "form$entry_id" method = "POST" action = "/edit.php">
			<input type="hidden" name="entry_id" value="$entry_id">
			<input type="hidden" name="username" value="$username">
		</form>



		<div id="tr$entry_id">
		<tr oncontextmenu="if (confirm('редактировать запись?')) { document.forms.form$entry_id.submit()  }; event.preventDefault();">
			

			<td>$account_numb</td>
			<td>$prodali_ot</td>
			<td>$organization</td>
			<td>$bill_summ</td>
			<td>$paid_prc</td>
			<td>$paid</td>
			<td>$uderjanoli5prc</td>
			<td>$_5prc</td>
			<td>$nomerscheta</td>
			<td>$purchase_summ</td>
			<td>$nakl_kolvo</td>
			<td>$nakl_sum</td>
			<td>$transportnye</td>
			<td>$itogo_marja</td>
			<td>$prc_marji1</td>
			<td>$prc_marji1_money</td>
			<td>$prc_marji2</td>
			<td>$prc_marji2_money</td>
			<td>$prc_marji3</td>
			<td>$prc_marji3_money</td>
			<td>$comment</td>
			<td>$dtc</td>
			<td>$dtu</td>
			<td>$upd_by</td>
		</tr>
		</div>


_T;
}
echo <<<_TableClose
</table>
_TableClose;



echo <<<_HTMLEND
		<span id="links" style="position: relative; top: 80px; left: 400px;">
			<form id="mainmenu" method="post" action="index.php">
				<input type="hidden" name="username" value="$username">
				<input type="hidden" name="password" value="$password">
			</form>
			<button type="submit" form="mainmenu">
				<u style="color: #440077"> Главное меню </u>
			</button>
			<button><a href='exit.php'> Выход </a></button>
		</span>
_HTMLEND;
?>