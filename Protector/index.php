<?php
// ------ ИНФОРМАЦИЯ ОБ ОШИБКАХ
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);



session_start();
//if (isset($_SESSION)) print("var_dump(S_SESSION) : ".var_dump($_SESSION));

//var_dump($_POST);


// Test connection to mysql ______________________________________
$fh = fopen("mysql.sys", 'r') or die("Файл не существует или...");
$text = fread($fh, 180); fclose($fh);
$mysqlenter = explode("\n",$text);
$username = $mysqlenter[0]; $host = $mysqlenter[1]; $password = $mysqlenter[2]; $database = $mysqlenter[3];
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);


// ************** HTML starts here ***********
echo <<<_HTML
<!DOCTYPE html>
<html>
  <head>
    <title>...WELCOME...</title>
  </head>
  <body>
_HTML;


if (isset($_POST['username']) && isset($_POST['password']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	//echo "var_dump(S_POST) : ";var_dump($_POST);



  // ****************** pASSWORD vERIFICATION ************************
	$password_entered = $password; // <user input at login>
	$query = "SELECT password from Users where username='$username' ";
	$result = $conn->query($query);
	if (!$result) echo "Сбой операции: $query<br>".$conn->error."<br><br>";
	$password_hash = $result->fetch_row(); // <retrieved from database based on username>
	//print("var_dump Spassword_hash : ".var_dump($password_hash));
	if (password_verify($password_entered, $password_hash[0]))
	{ 
		echo "Вы вошли. Добро пожаловать! ";
		echo "<br>";
		echo <<<_MENU
		<br>
		<a href='table.php'> > Просмотр / Редактирование записей < </a>
		<br>
		<a href='edit.php'> > Создание новой записи < </a>
		<br><br>
		<button><a href='exit.php'> Выйти </a></button>
		<br>
_MENU;
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
	}
	elseif (isset($_SESSION['username']))
	{
		echo <<<_MENU
		<br>
		<a href='table.php'> > Просмотр / Редактирование записей < </a>
		<br>
		<a href='edit.php'> > Создание новой записи < </a>
		<br><br>
		<button><a href='exit.php'> Выйти </a></button>
		<br>
_MENU;
	}
	elseif ( ($_POST['username'] === '') AND ($_POST['password'] === '') )
	{
		//var_dump($_POST);
		echo <<<_NOINPUT
			...✏ Введите имя пользователя и пароль...
			<br>
		<span>
			<form method="post" action="index.php" onSubmit="">
		        <input type="text" size="8" maxlength="64" name="username" title="...✍" placeholder="...✍ имя " >
		        <input type='password' size="8" maxlength="64" name="password" placeholder="...✍ пароль">
		        <input type="submit" value=" Вход ">
	        </form>
	    </span>
	    Если вы все ещё не сделали этого, необходимо 
	    <a href="register.php"> >>> зарегестрироваться <<< </a>
_NOINPUT;
	}
	else 
	{
		echo "Не верно введены имя пользователя и пароль! Попробуйте снова... ";
		echo "<br>";
		echo <<<_INVALIDINPUT
		<span>
			<form method="post" action="index.php" onSubmit="">
		        <input type="text" size="8" maxlength="64" name="username" title="...✍" placeholder="...✍ имя" >
		        <input type='password' size="8" maxlength="64" name="password" placeholder="...✍ пароль">
		        <input type="submit" value=" Вход ">
	        </form>
	    </span>
	    Если вы все ещё не сделали этого, необходимо 
	    <a href="register.php"> >>> зарегестрироваться <<< </a>
_INVALIDINPUT;
	}
}
else
{
		echo <<<_NOINPUT
			...✏ Введите имя пользователя и пароль...
			<br>
		<span>
			<form method="post" action="index.php" onSubmit="">
		        <input type="text" size="8" maxlength="64" name="username" title="...✍" placeholder="...✍ имя" >
		        <input type='password' size="8" maxlength="64" name="password" placeholder="...✍ пароль">
		        <input type="submit" value=" Вход ">
	        </form>
	    </span>

	    Если вы все ещё не сделали этого, необходимо 
	    <a href="register.php"> >>> зарегестрироваться <<< </a>
_NOINPUT;
}








echo <<<_HTMLEND
  </body>
</html>
_HTMLEND;



?>