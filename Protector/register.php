<?php

// ------ ИНФОРМАЦИЯ ОБ ОШИБКАХ
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);


session_start();

$username = $password = $email = $fail = "";

/*
if (isset($_POST['username']))
	$username = fix_string($_POST['username']);
if (isset($_POST['password']))
	$password = fix_string($_POST['password']);
if (isset($_POST['email']))
	$email = fix_string($_POST['email']);
*/



	//           В этом месте отправленные поля будут вводиться в базу данных
	//           с предварительным использованием хеш-шифрования для пароля
if ( isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) )
{
	// Test connection to mysql 
	$conn = new mysqli('localhost', 'root', '4Mdefpnu!', 'Resources');
	if ($conn->connect_error) die($conn->connect_error); 
	else
	{ 
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email']."@lkz-protect.ru";
		$passw_post = $password;
		$password = password_hash($password, PASSWORD_DEFAULT); // => store in database

	    $query = "INSERT INTO Users VALUES('$username', '$password', '$email')";
		$result = $conn->query($query);
		if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";
		else 
		{
			echo "</head><body>Registration succeded!<br>Welcome aboard!";
			echo <<<_REGISTERED
			<form method="post" action="index.php">
			<input type="hidden" name="username" value="$username">
			<input type="hidden" name="password" value="$passw_post">
			<input type="submit" value="->>> Go on! <<<-">
			</form>
			</body>
			</html>
_REGISTERED;
			exit;

		}
	}
}



// -------------- HERE Starts HTML & Java script -----------

echo <<<_HEAD
<!DOCTYPE html>
<html>
<head>
	<title>*Registration page*</title>
</head>
_HEAD;


// ----------------- Registr Form ------------

echo <<<_BODY

<body id='register'>


	<table id='table_reg' border="0" cellpadding="2" cellspacing="5" bgcolor="#fff">
		<th colspan="2" align="center">Registration Form</th>

		<tr>
			<td colspan="2"><p id='registertbl1'><font color=red size=18><i><pre>     ✎ </pre></i></font></p>
			</td>
		</tr>


		<form method="post" action="register.php">
			<tr>
				<td>User Name</td>
				<td><input type="text" size="16" maxlength="32" name="username" placeholder="✔" title="Don't use forbidden characters, please" pattern="[\w\.!#~@-]{1,63}" required></td>
			</tr>

			<tr>
				<td>Pass Word</td>
				<td><input type="text" size="16" maxlength="32" name="password" placeholder="✔" title="Don't use forbidden characters, please" pattern="[\w\.!#~@-]{1,255}" required></td>
			</tr>

			<tr>
				<td>Email Address</td>
				<td><input type="text" size="16" maxlength="64" name="email" placeholder="✔" required></td><td>@lkz-pr.ru</td>
			</tr>

			<tr>
				<td colspan="2" align="center" bgcolor="#fff"><input type="submit" value="Register Me!"></td>
			</tr>
		</form>
	</table>

<br><br>
<a href="\index.php"> <--- Go Back </a>
</body>
</html>
_BODY;

?>


