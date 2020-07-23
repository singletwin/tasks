<?php


ECHO <<<_HTML
<!DOCTYPE html>
<html>
	<head>
		<script src="/js_functions.js"></script>
		<title>Entries View Page</title>
	</head>
	<body>
		<div> SELECT PERIOD </div>

		<form method="post" action="index.php">
			<select name="month" title="choose month" required>
				<option selected disabled>Месяц</option>
				<option value="1"> Jannuary </option>
				<option value="2"> Feb </option>
				<option value="3"> Mar </option>
				<option value="4"> Apr</option>
				<option value="5"> May </option>
				<option value="6"> Jun </option>
				<option value="7"> Jul </option>
				<option value="8"> Aug </option>
				<option value="9"> Sep </option>
				<option value="10"> Oct </option>
				<option value="11"> Nov </option>
				<option value="12"> Dec </option>
			</select>

			<input type="text" name="year" placeholder="YEAR" title="enter year (4 digits)" size="1" pattern="[0-9]{4}" required></input>

			<select id="cltype" name="client type" title="choose client type">
				<option selected disabled>Опционально: тип клиента</option>
				<option value="1">Физическое лицо</option>
				<option value="0">Юридическое лицо</option>
			</select>

			<input type="submit" value="get data!"></input>
		</form>

		<div id="results"> results will be placed here </div>
_HTML;

if (isset($_POST['month']))
{
	//var_dump($_POST);
	$month = $_POST['month'];
	$year = $_POST['year'];
	$client_type = "undefined";
	isset($_POST['client_type'])? $client_type = $_POST['client_type'] : $client_type = "undefined";
	echo "<script> XHRpost($month,$year,$client_type); </script>";
}


echo <<<_HTML
	</body>
</html>
_HTML;

?>