<?php

// ------ ИНФОРМАЦИЯ ОБ ОШИБКАХ
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);


session_start();
//   ********** username = "valid" ,  password = 'valid' *******

//print_r($_POST);

echo <<<_HTML
<!DOCTYPE html>
<html id='indexhtml'>
	<head>
		<title>main page</title>
	</head>
	<body>
_HTML;



if ( (isset($_POST['username'])) AND (isset($_POST['password'])) )
{
	if ( ($_POST['username'] == 'valid') AND ($_POST['password'] == 'valid') )
	{
		echo "Now You Are Logged In, Welcome! ";
		echo <<<_MENU
		<br>
		<a href='view.php'> > View \ Edit Entries < </a>
		<br>
		<a href='edit.php'> > Add a New Entry < </a>
		<br>
		<button><a href='exit.php'> Exit </a></button>
		<br>
_MENU;
	}
	elseif ( ($_POST['username'] == '') AND ($_POST['password'] == '') )
	{
		echo <<<_NOINPUT
			Please log in to use the app

		<span>
			<form method="post" action="index.php" onSubmit="">
		        <input type="text" size="8" maxlength="64" name="username" title="...✍" placeholder="...✍ username" >
		        <input type='password' size="8" maxlength="64" name="password" placeholder="...✍ password">
		        <input type="submit" value=" Enter ">
	        </form>
	    </span>
_NOINPUT;
	}
	else 
	{
		echo "Invalid username\password input! Try again...";

		echo <<<_INVALIDINPUT
		<span>
			<form method="post" action="index.php" onSubmit="">
		        <input type="text" size="8" maxlength="64" name="username" title="...✍" placeholder="...✍ username" >
		        <input type='password' size="8" maxlength="64" name="password" placeholder="...✍ password">
		        <input type="submit" value=" Enter ">
	        </form>
	    </span>
_INVALIDINPUT;
	}
}
else 
{ 
	echo <<<_NOINPUT
	Please log in to use the app

		<span>
			<form method="post" action="index.php" onSubmit="">
		        <input type="text" size="8" maxlength="64" name="username" title="...✍" placeholder="...✍ username" >
		        <input type='password' size="8" maxlength="64" name="password" placeholder="...✍ password">
		        <input type="submit" value=" Enter ">
	        </form>
	    </span>
_NOINPUT;
}



echo <<<_HTMLEND
	</body>
</html>
_HTMLEND;

?>