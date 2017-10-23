<?php
    require_once 'connect.php';
    
    mysqli_query($link,"SET NAMES utf8");

    $login     = $_REQUEST['login'];
    $email     = $_REQUEST['email'];

    function GeneratePassword(){
        $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";  // символы, которые будут использоваться в пароле 
        $max=10;                // кол-о символов в пароле 
        $size=StrLen($chars)-1; // длина $chars
        $password=null;         // определяем пустую переменную, в которую и будем записывать символы
        while($max--)           // создаём пароль 
            $password.=$chars[rand(0,$size)]; 
        return $password;
    }
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
                    // ищем такого юзера
                    $query = "select * from users where `Login`='{$login}' and `Email`='{$email}';";
                    $result = mysqli_query($link, $query);
                    if (!$result){         // проблемы с запросом
                        echo 'Cannot run query1.';
                        exit;
                    }
               
                    $col_str = mysqli_num_rows($result); // кол-во полученых строк

                    if (!$col_str){
                        echo "Соответствий не найдено.";
                    }
                    else {  // а если нашли, то берем id этого юзера, записываем в бд новый пароль и отправляем ему на почту
                        $password = GeneratePassword();
        
                        $row = mysqli_fetch_row($result);
                        $id = $row[0];  
                        
                        $password = crypt($password, 'xx');
                        $query = "update users set `Password`='{$password}' where `ID`={$id};";
                        $result = mysqli_query($link, $query);
                        if (!$result){         // проблемы с запросом
                            echo 'Cannot run query.';
                            exit;
                        }
                        
                        //mail($email, "Новый пароль в MyRecursionTraining", "Ваш новый пароль: ".$password); 
                        $mail =& Mail::factory('smtp', array('host' => 'localhost', 'port' => 25));
                        $mail->send($email, "Новый пароль в MyRecursionTraining", "Ваш новый пароль: ".$password);    
                        
                        echo 'Новый пароль выслан на почтовый ящик '.$email;
                    }

                
               ?>
            
           </font></div>
        </div>
        
    </body>
</html>