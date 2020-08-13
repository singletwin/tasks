<?php

require_once "SendMailSmtpClass.php"; // подключаем класс
global $username, $passw_post, $to;
//global $to;


//$mailSMTP = new SendMailSmtpClass('singletwin@inbox.ru', '4mdefpnu', 'ssl://smtp.inbox.ru', 465, "UTF-8");
$mailSMTP = new SendMailSmtpClass('singletwin@yandex.ru', '4mdefpnu', 'ssl://smtp.yandex.ru', 465, "UTF-8");

// $mailSMTP = new SendMailSmtpClass('логин', 'пароль', 'хост', 'порт', 'кодировка письма');
 
// от кого
$from = array(
    " Protector API ", // Имя отправителя
    "singletwin@yandex.ru" // почта отправителя
);
// кому
//$to = 
 
 // текст письма:
$text = "Вот пожалуйста, ваши логин и пароль. Постарайтесь не забыть.<br> ********************************************************************************* <br>Login = ".$username." ; Password = ".$passw_post;
// отправляем письмо
$result =  $mailSMTP->send($to, 'Регистрация на протектор. Памятка', $text, $from); 
// $result =  $mailSMTP->send('Кому письмо', 'Тема письма', 'Текст письма', 'Отправитель письма');
 
if($result === true){
    echo "<br> На заявленную почту отправлено письмо о регистрации с напоминанием пароля";
}else{
    echo "<br> ! Error: " . $result;
}


?>