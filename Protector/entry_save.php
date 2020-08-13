<?php

// ------ ИНФОРМАЦИЯ ОБ ОШИБКАХ
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);




session_start();
//$user=$_SESSION['username'];
//var_dump($_SESSION);



// Test connection to mysql ______________________________________
$fh = fopen("mysql.sys", 'r') or die("Файл не существует или...");
$text = fread($fh, 180); fclose($fh);
$mysqlenter = explode("\n",$text);
$username = $mysqlenter[0]; $host = $mysqlenter[1]; $password = $mysqlenter[2]; $database = $mysqlenter[3];
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);





//var_dump($_POST);
$new = $_POST['new'];
$entry_id=$_POST['entry_id'];

	$account_numb = $_POST['account_numb'];
	$prodali_ot = $_POST['prodali_ot'];
	$organization = $_POST['organization'];
	$bill_summ = $_POST['bill_summ'];
	$paid = $_POST['paid'];
	$paid_prc = round(($paid * 100 / $bill_summ), 1);
	$uderjanoli5prc = $_POST['uderjanoli5prc'];
	if ($uderjanoli5prc == 'удержано 5%') $_5prc = $paid / 20;
	else $_5prc = 0;
	$nomerscheta = $_POST['nomerscheta'];
	$purchase_summ = $_POST['purchase_summ'];
	$nakl_kolvo = $_POST['nakl_kolvo'];
	$nakl_sum = $nakl_kolvo * 40;
	$transportnye = $_POST['transportnye'];
	$itogo_marja = $bill_summ - $_5prc - $purchase_summ - $nakl_sum - $transportnye;
	$prc_marji1 = $_POST['prc_marji1'];
	if ($prc_marji1 == NULL) $prc_marji1_money = 0;
	else $prc_marji1_money = $itogo_marja / 100 * $prc_marji1;
	$prc_marji2 = $_POST['prc_marji2'];
	if ($prc_marji2 == NULL) $prc_marji2_money = 0;
	else $prc_marji2_money = $itogo_marja / 100 * $prc_marji2;
	$prc_marji3 = $_POST['prc_marji3'];
	if ($prc_marji3 == NULL) $prc_marji3_money = 0;
	else $prc_marji3_money = $itogo_marja / 100 * $prc_marji3;


	$comment = $_POST['comment'];


$dtu = date('Y')."-".date('m')."-".date('d')." ".date('H').":".date('i').":".date('s');
//var_dump($dtu);

$dtc = date('Y')."-".date('m')."-".date('d')." ".date('H').":".date('i').":".date('s');

$upd_by = $_SESSION['username'];


if ( $new == 0 )
{
	
//-----------------------------------------------------
//************ запись изменений в лог ****************
	$query2 = "SELECT account_numb, prodali_ot, organization, bill_summ, paid, uderjanoli5prc, nomerscheta, purchase_summ, nakl_kolvo, transportnye, prc_marji1, prc_marji2, prc_marji3, comment from Operations WHERE entry_id='$entry_id'";
	$result2 = $conn->query($query2);
	if (!$result2) die ($conn->error);
	$fetch2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
	// ********* account_numb
	if ($fetch2['account_numb'] != $account_numb)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;  account_numb ".$fetch2["account_numb"]." -> $account_numb BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}
	//******* prodali_ot
	if ($fetch2['prodali_ot'] != $prodali_ot)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;  prodali_ot ".$fetch2["prodali_ot"]." -> $prodali_ot BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}
	//******* organization
	if ($fetch2['organization'] != $organization)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;   organization ".$fetch2["organization"]." -> $organization BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}
	//******* bill_summ
	if ($fetch2['bill_summ'] != $bill_summ)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;   bill_summ ".$fetch2["bill_summ"]." -> $bill_summ BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}
	//*******paid
	if ($fetch2['paid'] != $paid)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;   paid ".$fetch2["paid"]." -> $paid BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}
	//*******uderjanoli5prc
	if ($fetch2['uderjanoli5prc'] != $uderjanoli5prc)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;   uderjanoli5prc ".$fetch2["uderjanoli5prc"]." -> $uderjanoli5prc BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}
	//*******nomerscheta
	if ($fetch2['nomerscheta'] != $nomerscheta)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;   nomerscheta ".$fetch2["nomerscheta"]." -> $nomerscheta BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}
	//******* purchase_summ
	if ($fetch2['purchase_summ'] != $purchase_summ)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;   purchase_summ ".$fetch2["purchase_summ"]." -> $purchase_summ BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}
	//******* nakl_kolvo
	if ($fetch2['nakl_kolvo'] != $nakl_kolvo)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;   nakl_kolvo ".$fetch2["nakl_kolvo"]." -> $nakl_kolvo BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}
	//******* transportnye
	if ($fetch2['transportnye'] != $transportnye)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;   transportnye ".$fetch2["transportnye"]." -> $transportnye BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}
	//******* prc_marji1
	if ($fetch2['prc_marji1'] != $prc_marji1)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;   prc_marji1 ".$fetch2["prc_marji1"]." -> $prc_marji1 BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}
	//******* prc_marji2
	if ($fetch2['prc_marji2'] != $prc_marji2)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;   prc_marji2 ".$fetch2["prc_marji2"]." -> $prc_marji2 BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}
	//******* prc_marji3
	if ($fetch2['prc_marji3'] != $prc_marji3)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;   prc_marji3 ".$fetch2["prc_marji3"]." -> $prc_marji3 BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}

	//******* comment
	if ($fetch2['comment'] != $comment)
	{
		$file = "changes.log";
		$text = "$dtu entryID: $entry_id; номер счета: $account_numb ;   comment ".$fetch2["comment"]." -> $comment BY $upd_by\n";
		file_put_contents($file, $text, FILE_APPEND);
	}
//-------------------------------------------------------------
//**************************************************************






//*************** изменение записи *******************
	$query = "UPDATE Operations SET account_numb = '$account_numb', prodali_ot = '$prodali_ot', organization = '$organization', bill_summ = '$bill_summ', paid_prc = '$paid_prc', paid = '$paid', uderjanoli5prc = '$uderjanoli5prc', _5prc = '$_5prc', nomerscheta = '$nomerscheta',  purchase_summ = '$purchase_summ', nakl_kolvo = '$nakl_kolvo', nakl_sum = '$nakl_sum', transportnye = '$transportnye', itogo_marja = '$itogo_marja', prc_marji1 = '$prc_marji1', prc_marji1_money = '$prc_marji1_money' , prc_marji2 = '$prc_marji2', prc_marji2_money = '$prc_marji2_money' , prc_marji3 = '$prc_marji3', prc_marji3_money = '$prc_marji3_money' , comment = '$comment', dtu = '$dtu', upd_by = '$upd_by' WHERE entry_id='$entry_id'";
	$result = $conn->query($query);
	if (!$result) die ($conn->error);


}
elseif ( $new == 1 )
{
	$query = "INSERT INTO Operations (account_numb, prodali_ot, organization, bill_summ, paid_prc, paid, uderjanoli5prc, _5prc, nomerscheta, purchase_summ, nakl_kolvo, nakl_sum, transportnye, itogo_marja, prc_marji1, prc_marji1_money, prc_marji2, prc_marji2_money, prc_marji3, prc_marji3_money, comment, dtc, upd_by) VALUES('$account_numb','$prodali_ot','$organization','$bill_summ','$paid_prc','$paid','$uderjanoli5prc','$_5prc','$nomerscheta','$purchase_summ','$nakl_kolvo','$nakl_sum','$transportnye','$itogo_marja','$prc_marji1', '$prc_marji1_money', '$prc_marji2', '$prc_marji2_money', '$prc_marji3', '$prc_marji3_money','$comment','$dtc', '$upd_by')";
	$result = $conn->query($query);
	if (!$result) die ($conn->error);
}


$conn->close();
header('Location: /table.php');

?>