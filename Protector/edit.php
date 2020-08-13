<?php

session_start();
//var_dump($_SESSION);
$username = $_SESSION['username'];
$password = $_SESSION['password'];

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
		<title>Entries Edit Page</title>
	</head>
	<body>
_HTML;


// ------------ DATABASE QUERY 


if (isset($_POST['entry_id']))
{
	$entry_id = $_POST['entry_id'];
	$new = 0;


	$query = "select * from Operations where entry_id = '$entry_id' ";
	$result = $conn->query($query); // получаем объект mysqli_result object
	if (!$result) die (' ****** '.$conn->error.' ****** ');
	$fetch = mysqli_fetch_all($result, MYSQLI_ASSOC); // приводим объект в ассоциативный массив


	$account_numb = $fetch[0]['account_numb'];
	$prodali_ot = $fetch[0]['prodali_ot'];
	$organization = $fetch[0]['organization'];
	$bill_summ = $fetch[0]['bill_summ'];
	$paid_prc = $fetch[0]['paid_prc'];
	$paid = $fetch[0]['paid'];
	$uderjanoli5prc = $fetch[0]['uderjanoli5prc'];
	$_5prc = $fetch[0]['_5prc'];
	$nomerscheta = $fetch[0]['nomerscheta'];
	$purchase_summ = $fetch[0]['purchase_summ'];
	$nakl_kolvo = $fetch[0]['nakl_kolvo'];
	$nakl_sum = $fetch[0]['nakl_sum'];
	$transportnye = $fetch[0]['transportnye'];
	$itogo_marja = $fetch[0]['itogo_marja'];
	$prc_marji1 = $fetch[0]['prc_marji1'];
	$prc_marji2 = $fetch[0]['prc_marji2'];
	$prc_marji3 = $fetch[0]['prc_marji3'];
	$comment = $fetch[0]['comment'];
	$dtc = $fetch[0]['dtc'];
	$dtu = $fetch[0]['dtu'];
	$upd_by = $fetch[0]['upd_by'];
}
else
{
	$entry_id = "do not matter";
	$new = 1;

	$account_numb = '';
	$prodali_ot = '';
	$organization = '';
	$bill_summ = '';
	$paid = '';
	$paid_prc = '';
	$uderjanoli5prc = '';
	$_5prc = '';
	$nomerscheta = '';
	$purchase_summ = '';
	$nakl_kolvo = '';
	$nakl_sum = '';
	$transportnye = '';
	$itogo_marja = '';
	$prc_marji1 = '';
	$prc_marji2 = '';
	$prc_marji3 = '';
	$comment = '';
	$dtc = '';
	$dtu = '';
	$upd_by = '';
}


echo <<<_EDITFORM

<form method='POST' action='entry_save.php' onSubmit="">
	
	№ счета <input type="text" name="account_numb" value="$account_numb" title="цифры" pattern="[0-9]{1,21}" required><br>
_EDITFORM;



//*********************************************************
// продали от , берем значение из таблицы. для редактирования
if ($new == 0 && $fetch[0]['prodali_ot'] == "ИНТЕХ")
{ 
echo <<<_PRODALIOT
	Продали от <select name="prodali_ot" required><option value="ПРОТЕКТОР">ПРОТЕКТОР</option><option value="ИНТЕХ" selected>ИНТЕХ</option></select><br>
_PRODALIOT;
}
elseif ($new == 0 && $fetch[0]['prodali_ot'] == "ПРОТЕКТОР")
{
echo <<<_PRODALIOT
	Продали от <select name="prodali_ot" required><option value="Продали от" disabled>Продали от...</option><option value="ПРОТЕКТОР" selected>ПРОТЕКТОР</option><option value="ИНТЕХ">ИНТЕХ</option></select><br>
_PRODALIOT;
}
elseif ($new == 1)
{
echo <<<_PRODALIOT
	Продали от <select name="prodali_ot" required><option value="Продали от" selected disabled>Продали от...</option><option value="ПРОТЕКТОР">ПРОТЕКТОР</option><option value="ИНТЕХ">ИНТЕХ</option></select><br>
_PRODALIOT;
}
//*********************************************************



echo <<<_EDITFORM

	Организация <input type="text" name="organization" value="$organization" title="буквы, цифры, пробел, дефис" pattern="[0-9A-Za-zА-Яа-яЁё\s-]{1,63}" required><br>

	Сумма счета <input type="text" name="bill_summ" value="$bill_summ" title="рубли и копейки через точку , например '12345678.90' " pattern="\d{1,19}(\.\d{2})?" required><br>

	<input title="Оплачено %" type="hidden" name="paid_prc" value="$paid_prc">

	Оплачено сумма <input type="text" name="paid" value="$paid" title="рубли и копейки через точку , например '12345678.90' " pattern="\d{1,19}(\.\d{2})?" required><br>
_EDITFORM;




//*********************************************************
// удержано ли 5%  , берем значение из таблицы. для редактирования
 if ($new == 0 && $fetch[0]['uderjanoli5prc'] == "удержано 5%")
{
 echo <<<_uderjanoli5prc
 	Удержано ли 5%? 
	<span> 
		<input type="radio" name="uderjanoli5prc" value="удержано 5%" checked> Удержано
		<input type="radio" name="uderjanoli5prc" value="нет"> Не удержано
	</span> <br>
_uderjanoli5prc;
}
elseif ($new == 0 && $fetch[0]['uderjanoli5prc'] == "нет")
{
 echo <<<_uderjanoli5prc
 	Удержано ли 5%? 
	<span> 
		<input type="radio" name="uderjanoli5prc" value="удержано 5%"> Удержано
		<input type="radio" name="uderjanoli5prc" value="нет" checked> Не удержано
	</span> <br>
_uderjanoli5prc;
}
elseif ($new == 1) 
{
 echo <<<_uderjanoli5prc
 	Удержано ли 5%? 
	<span> 
		<input type="radio" name="uderjanoli5prc" value="удержано 5%" required> Удержано
		<input type="radio" name="uderjanoli5prc" value="нет" required> Не удержано
	</span> <br>
_uderjanoli5prc;
}
// *********************************************



echo <<<_EDITFORM
	№ счетов <input type="text" name="nomerscheta" value="$nomerscheta" title="номера счетов через пробел, запятую или +" pattern="[0-9\+\s,]{1,45}" required><br>

	Сумма закупа <input type="text" name="purchase_summ" value="$purchase_summ" title="рубли и копейки через точку , например '12345678.90' " pattern="\d{1,19}(\.\d{2})?" required><br>

	Кол-во наклеек <input type="text" name="nakl_kolvo" value="$nakl_kolvo" title="" pattern="[0-9]{1,4}" required><br>

	Транспортные <input type="text" name="transportnye" value="$transportnye" title="рубли и копейки через точку , например '12345678.90' " pattern="\d{1,19}(\.\d{2})?" required><br>

	сосчитать от маржи (1), % <input type="text" name="prc_marji1" value="$prc_marji1" title="цифры" pattern="[0-9]{1,3}"><br>

	сосчитать от маржи (2), % <input type="text" name="prc_marji2" value="$prc_marji2" title="цифры" pattern="[0-9]{1,3}"><br>

	сосчитать от маржи (3), % <input type="text" name="prc_marji3" value="$prc_marji3" title="цифры" pattern="[0-9]{1,3}"><br>

	Комментарий <input type="text" name="comment" value="$comment" title="не используйте, пожалуйста, системные символы" pattern="[0-9A-Za-zА-Яа-яЁё%=!,_\.\+\?\(\)\s-]{1,63}"><br>

	<input type="hidden" name="entry_id" value="$entry_id">
	<input type="hidden" name="new" value="$new">
	<input type="hidden" name="username" value="$username">
	<input type="submit" value="Сохранить!" style="color: #440077">

</form>


_EDITFORM;



echo <<<_HTMLEND
		<span id="links" style="position: relative; top: 50px; left: 350px;">
		<button type="submit" form="mainmenu"> <u style="color: #440077"> Главное меню </u>
			<form id="mainmenu" method="post" action="index.php">
				<input type="hidden" name="username" value="$username">
				<input type="hidden" name="password" value="$password">
			</form>
		</button>
		<button><a href='exit.php'> Выход </a></button>
		</span>
	</body>
</html>
_HTMLEND;



?>