<?php
    require_once 'connect.php';
    
    mysqli_query($link,"SET NAMES utf8");

    $login     = $_REQUEST['login'];
    $password  = $_REQUEST['password'];
    $password2 = $_REQUEST['password2'];
    $firstName = $_REQUEST['firstName'];
    $lastName  = $_REQUEST['lastName'];
    $email     = $_REQUEST['email'];

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Теория: понятие рекурсии</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <div id="navigation">
            <ul>
                <li><a href="theory1.html">Теория</a></li>
                <li><a href="illustration.html">Иллюстрация</a></li>
                <li><a href="test.php">Тест</a></li>
            </ul>
        </div>
        
        <div class="sidebar">
            
        </div>
        
        <div id="page">
           <div id="center"><br><br><font size="+3">
                <?php
                    // проверка корректности ввода
                    if ($password != $password2)
                        echo "Пароли не совпадают, регистрация отменена.";  
                    else if(!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $firstName)) 
                        echo "Имя пользователя задано в неправильном формате, регистрация отменена.";
                    else if(!preg_match("/^[a-zA-Zа-яА-Я]+$/u", $lastName)) 
                        echo "Фамилия пользователя задана в неправильном формате, регистрация отменена.";
                    else if(!preg_match("/^[\w]+[\w\d_]*$/", $login)) 
                        echo "Логин задан в неправильном формате, регистрация отменена.";
                    else if(!preg_match("/^([\w\d]+)([\w\d_]*)@[\w]+\.[\w]+$/", $email)) 
                        echo "E-mail задан в неправильном формате, регистрация отменена.";
                    else {
                        // если всё правильно, то записываем в базу
                        $password = crypt($password, 'xx');
                        $query = "insert into users values (null,'{$login}','{$password}','{$email}','{$firstName}','{$lastName}');";
                        $result = mysqli_query($link, $query);
                        if (!$result){         // проблемы с запросом
                            echo 'Cannot run query.';
                            exit;
                        }
                            
                        echo 'Регистрация прошла успешно. Пожалуйста, <a href="test.php">авторизируйтесь</a>.';
                    }
               ?>
            
           </font></div>
        </div>
        
    </body>
</html>