<?php

require_once "SendMailSmtpClass.php"; // подключаем класс
$mailSMTP = new SendMailSmtpClass('singletwin@yandex.ru', '4mdefpnu', 'ssl://smtp.yandex.ru', 465, "UTF-8");
// $mailSMTP = new SendMailSmtpClass('логин', 'пароль', 'хост', 'порт', 'кодировка письма');
 
// от кого
$from = array(
    "ya", // Имя отправителя
    "singletwin@yandex.ru" // почта отправителя
);
// кому
$to = 'singletwin@inbox.ru';
 
// отправляем письмо
$result =  $mailSMTP->send($to, 'Тема письма', 'Текст письма', $from); 
// $result =  $mailSMTP->send('Кому письмо', 'Тема письма', 'Текст письма', 'Отправитель письма');
 
if($result === true){
    echo "Done";
}else{
    echo "Error: " . $result;
}


?>