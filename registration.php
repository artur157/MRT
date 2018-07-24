<?php
    require_once 'connect.php';
    
    mysqli_query($link,"SET NAMES utf8");

    $login     = mysqli_real_escape_string($link, $_REQUEST['login']);
    $password  = mysqli_real_escape_string($link, $_REQUEST['password']);
    $password2 = mysqli_real_escape_string($link, $_REQUEST['password2']);
    $firstName = mysqli_real_escape_string($link, $_REQUEST['firstName']);
    $lastName  = mysqli_real_escape_string($link, $_REQUEST['lastName']);
    $email     = mysqli_real_escape_string($link, $_REQUEST['email']);

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Регистрация</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <?php
            require_once "help_functions.php";
            printNavigation();        // вывели панель навигации
            printSidebarTest(0);   // вывели сайдбар для теста
        ?>
        
        <div id="page">
           <div id="center"><br><br><font size="+3">
                <?php
                    // проверка корректности ввода
                    if ($password != $password2)
                        echo "Пароли не совпадают, регистрация отменена.";  
                    else if(!preg_match("/^[a-zA-Zа-яА-Я0-9_]+$/u", $password)) // новинка
                        echo "Пароль использует некорректные символы, регистрация отменена.";
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