<?php
    require_once 'connect.php';

    //проверить есть ли такой юзер. Если нет направим на test.php
    $login = $_REQUEST["login"];
    $password = crypt($_REQUEST["password"], 'xx');

    //mysqli_set_charset($link, 'utf8');  // устанавливает кодировку (для русских букв)
    mysqli_query($link,"SET NAMES utf8");

    $query = "select * from users where `Login`='{$login}' and `Password`='{$password}';" ;
    $result = mysqli_query($link, $query);

    if (!$result){         // проблемы с запросом
        echo 'Cannot run query.';
        exit;
    }

    $col_str = mysqli_num_rows($result); // кол-во полученых строк

    if (!$col_str){
        header("Location: test.php");
        exit;
    }

    // если всё в порядке
    $row = mysqli_fetch_row($result);
    $firstName = $row[4];
    $lastName  = $row[5];

    session_start();
    //session_register("login", "firstName", "lastName");
    $_SESSION['login']     = $login;
    $_SESSION['firstName'] = $firstName;
    $_SESSION['lastName']  = $lastName;


    define ("QUAN_Q",50); 
    $was = array();                         // массив, i-й эл = 1 <=> вопрос с ID_Q == i уже был задан
    for ($i = 0; $i < QUAN_Q; ++$i)
        $was[] = 0;
    $w = implode(" ", $was);
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
            <br><h1>Тест</h1><br>
            <br><?php echo "Добро пожаловать, ".$firstName." ".$lastName."!"; ?><br><br>
            <form action="test_q.php" method="POST">
                <label for="q1">Выберите уровень сложности:</label><br><br>
				<input type="radio" value="1" name="level">Лёгкий<br>
				<input type="radio" value="2" name="level">Средний<br>
				<input type="radio" value="3" name="level">Повышенный<br><br>
				<input type="hidden" value="0" name="quan_right">
				<input type="hidden" value="1" name="order_number">
				<input type="hidden" value="0" name="ans">
				<input type="hidden" value="0" name="right_answer">
				<input type="hidden" value="<?php echo $w ?>" name="was">
				<input type="submit" name="submit" value="Выбрать" id="submit">
            </form>
        </div>
        
    </body>
</html>