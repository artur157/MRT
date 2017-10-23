<?php
    require_once 'connect.php';
    
    mysqli_query($link,"SET NAMES utf8");

    session_start();
    $login     = $_SESSION['login'];
    $firstName = $_SESSION['firstName'];
    $lastName  = $_SESSION['lastName'];
    $mark      = $_SESSION['mark']; 


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
            <font size="+2"><br><?php echo $firstName." ".$lastName; ?><br></font>
            <a href="test.php">Выйти</a><br><br>
            <a href="result.php">Просмотреть мои результаты</a>
        </div>
        
        <div id="page">
            <br><h1>Тест</h1><br><br>              
    
            <div id="supertext">
                Ваша оценка: 
                <?php 
                    switch ($mark){
                        case 5: echo " отлично"; break;
                        case 4: echo " хорошо"; break;
                        case 3: echo " удовлетворительно"; break;
                        case 2: echo " неудовлетворительно"; break;
                        default: echo " неоднозначно";
                    }
                    
                    // занести в бд
                    // найти id
                    $query = "select * from users where `Login`='{$login}';" ;
                    $result = mysqli_query($link, $query);
                    if (!$result){         // проблемы с запросом
                        echo 'Cannot run query.';
                        exit;
                    }
                
                    $row = mysqli_fetch_row($result);
                    $id = $row[0];
                    
                    // записываем результат
                    $query = "insert into results values (null,{$mark},{$id},CURDATE());";
                    $result = mysqli_query($link, $query);
                    if (!$result){         // проблемы с запросом
                        echo 'Cannot run query.';
                        exit;
                    }
                
                ?>
            </div>
        </div>
        
    </body>
</html>