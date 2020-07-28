<?php
// ------ ИНФОРМАЦИЯ ОБ ОШИБКАХ
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);



// Test connection to mysql ______________________________________
$conn = new mysqli('localhost', 'root', '4Mdefpnu!', 'Resources');
if ($conn->connect_error) die($conn->connect_error); 

session_start();
//if (isset($_SESSION)) print("var_dump(S_SESSION) : ".var_dump($_SESSION));
echo "<br>";


if (isset($_POST['username']) && isset($_POST['password']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	//echo "var_dump(S_POST) : ";var_dump($_POST);
	echo "<br>";


  // ****************** pASSWORD vERIFICATION ************************
	$password_entered = $password; // <user input at login>
	$query = "SELECT password from Users where username='$username' ";
	$result = $conn->query($query);
	if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";
	$password_hash = $result->fetch_row(); // <retrieved from database based on username>
	//print("var_dump Spassword_hash : ".var_dump($password_hash));
	if (password_verify($password_entered, $password_hash[0]))
	{ 
		echo <<<_VERIFY
		<script>
			var passok = " ツ Glad to see You, $username!! Godspeed! ☦ ";
			alert(passok);
		</script>
_VERIFY;
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
	}
	else { echo "<script>alert(' Wrong!  ☹ ')</script>"; }
}


// IF PASSWORD MATCHED THEN YOU ARE LOGED IN
if (isset($_SESSION['username']))
  {
    $user     = $_SESSION['username'];
    $loggedin = TRUE;
  }
else $loggedin = FALSE;


if ($loggedin)
{
	echo <<<_LOGGEDIN
	<span id='indexreg'><button id="indexlogout"><a href="exit.php"> Выйти </a></button></span>
	<br>
	<br>
	<div>VIEW / EDIT</div>
	<div>NEW ENTRY</div>
	<br>
_LOGGEDIN;
}



echo <<<_HTML
<!DOCTYPE html>
<html>
  <head>
    <title>...WELCOME...</title>
  </head>
  <body>
_HTML;


if (!$loggedin)
{
echo <<<_GUEST
    <span>
        <form method="post" action="index.php">
        <legend>...✏ Введите имя пользователя и пароль...</legend>
        <br>
        <input type="text" size="12" maxlength="64" name="username" title="Не используйте запрещенные символы, пожалуйста" placeholder="...✍ имя пользователя" pattern="[\w\.!#~@-]{1,63}" required>
        <input type='password' size="8" maxlength="64" name="password" placeholder="...✍ пароль"  title="Не используйте запрещенные символы, пожалуйста" pattern="[\w\.!#~@-]{1,255}" required>
        <input type="submit" value=" Вход ">
        </form>
        <p><br>Для использования приложения<br> необходимо <a id="register" href="register.php">->>> зарегестрироваться <<<-</a>
    </span>
_GUEST;
}



echo <<<_HTMLEND
  </body>
</html>
_HTMLEND;



?>