<?php
 require_once 'app_config.php';

 $link = mysqli_connect(DATABASE_HOST,DATABASE_USERNAME,DATABASE_PASSWORD) 
     or die("<p>Ошибка подключения к базе данных: ".mysqli_connect_error()."</p>"); 

 $result = mysqli_query($link,"USE ".DATABASE_NAME.";");
 if (!$result){
     die("<p>Ошибка при выборе базы данных ".DATABASE_NAME.": {mysqli_error($link)}</p>");
 }

 //header("Location: test_q.php");
 //exit();
?>