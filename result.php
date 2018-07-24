<?php
    require_once 'connect.php';
    
    mysqli_query($link,"SET NAMES utf8");

    session_start();
    $login     = mysqli_real_escape_string($link, $_SESSION['login']);
    $firstName = strip_tags($_SESSION['firstName']);
    $lastName  = strip_tags($_SESSION['lastName']);
    //$mark      = $_SESSION['mark']; 

    function TransMark($ch){
        switch ($ch){
            case 5: return " отлично"; break;
            case 4: return " хорошо"; break;
            case 3: return " удовлетворительно"; break;
            case 2: return " неудовлетворительно"; break;
            default: return " неоднозначно";
        }
    }

    function TransDate($str){  // преобразовывает дату в стандартный формат
        return $str[8].$str[9].".".$str[5].$str[6].".".$str[0].$str[1].$str[2].$str[3];
    }
?>
   

<html>
    <head>
        <meta charset="utf-8">
        <title>Результаты</title>
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
            <br><h1>Мои результаты</h1><br><br>              
            <font size="+2"><br><?php echo $firstName." ".$lastName; ?><br></font>  <!-- выводим имя -->
            <?php
                // находим id юзера
                $query = "select * from users where `Login`='{$login}';";
                $result = mysqli_query($link, $query);
                if (!$result){         // проблемы с запросом
                    echo 'Cannot run query.';
                    exit;
                }
                
                $row = mysqli_fetch_row($result);
                $id = $row[0];
            
                $query = "select * from results where `ID_U`={$id} order by date,id;" ;
                $result = mysqli_query($link, $query);
                if (!$result){         // проблемы с запросом
                    echo 'Cannot run query.';
                    exit;
                }
                
                echo '<br><table border="">';
                while ($row = mysqli_fetch_row($result)){ 
                    echo "<tr><td>".TransDate($row[3])."</td><td>".TransMark($row[1])."</td></tr>";
                }
                echo "</table>";
                
            
            ?>
        </div>
        
    </body>
</html>