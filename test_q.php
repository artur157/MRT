<?php
    require_once 'connect.php';
    
    mysqli_query($link,"SET NAMES utf8");

    session_start();
    $login     = $_SESSION['login'];
    $firstName = $_SESSION['firstName'];
    $lastName  = $_SESSION['lastName'];

    define ("QUAN_Q",10);                     // кол-во вопросов в базе
    define ("k1",0.65);                       // коэф. за ответ на ур. сл. 1   0.55
    define ("k2",0.85);                       // коэф. за ответ на ур. сл. 2   0.85
    define ("k3",1);                          // коэф. за ответ на ур. сл. 3   1
    $level        = $_POST['level'];
    $score        = $_POST['quan_right'];     // кол-во правильно отвеченных вопросов 
    $order_number = $_POST['order_number'];
    $_POST['ans'] = strip_tags($_POST['ans']);
    $w            = $_POST['was'];            // массив, i-й эл = 1 <=> вопрос с ID_Q == i уже был задан  
    $was          = explode(" ",$w); 
    $mark;                                    // оценка после аккумуляции

    $x = array();                        
    for ($i = 0; $i < 5; ++$i)
         $x[] = 0;

    function HelpVariables(){
        global $x, $score, $order_number;
        
        for($i = 1; $i<5; ++$i)
            $x[$i] = $score*100/(($order_number-1)*k3);
    }

    function MU3($xi,$a,$b,$c){
        if ($xi > $c) return 0;
        else if ($xi > $b) return ($c-$xi)/($c-$b);
             else if ($xi > $a) return ($xi-$a)/($b-$a);
                  else return 0;
    } 
        
    function MU4($xi,$a,$b,$c,$d){
        if ($a==$b && $xi<=$c) return 1;
        if ($c==$d && $xi>=$b) return 1;
        
        if ($xi >= $d) return 0;
        else if ($xi > $c) return ($d-$xi)/($d-$c);
             else if ($xi > $b) return 1;
                  else if ($xi > $a) ($xi-$a)/($b-$a);
                       else return 0;
    } 

    // неудовлетворительно
    function MUx1PS(){global $x; return MU4($x[1],0,0,15,30);}   
    function MUx1SN(){global $x; return MU4($x[1],40,55,100,100);}
    function MUx1NS(){global $x; return MU3($x[1],20,35,50);}
    // удовлетворительно
    function MUx2PS(){global $x; return MU3($x[1],30,50,70);} 
    function MUx2SN(){global $x; return MU3($x[1],10,30,50)+MU3($x[2],50,70,90);} 
    function MUx2NS(){global $x; return MU4($x[1],0,0,10,30)+MU4($x[2],70,90,100,100);}
    // хорошо
    function MUx3PS(){global $x; return MU3($x[1],55,70,85);} 
    function MUx3SN(){global $x; return MU4($x[1],70,90,100,100)+MU4($x[3],0,0,40,55);} 
    function MUx3NS(){global $x; return MU4($x[1],0,0,40,55);} 
    // отлично
    function MUx4PS(){global $x; return MU4($x[1],80,90,100,100);}
    function MUx4SN(){global $x; return MU3($x[1],70,80,90);}
    function MUx4NS(){global $x; return MU4($x[1],0,0,70,80);}     
    
    function MUBad($y){return MU4($y,0,0,20,40);}
    function MUSatis($y){return MU3($y,30,50,70);}
    function MUGood($y){return MU3($y,60,75,90);}
    function MUExcel($y){return MU4($y,80,90,100,100);}

    function MUBad2($y){
        /*echo "арг: ".$y."  ";
        //echo "1) ".MUBad($y)."  ";
        //echo "2) ".min(max(MUx1SN(),MUx1PS()),MUx2NS(),MUx3NS(),MUx4NS())."<br>";*/
        return min(MUBad($y),max(
            min(max(MUx1SN(),MUx1PS()),MUx2NS(),MUx3NS(),MUx4NS()),
            min(MUx1PS(),MUx2SN(),MUx3SN(),MUx4NS())));
    }

    function MUSatis2($y){
       // echo "<br><br><br>";
       // echo MUx1SN()." ".MUx1NS()." ".MUx2PS()." ".MUx3SN()." ".MUx4NS()." ".MUx1SN()." ".MUx1NS()." ".MUx2SN()." ".MUx3NS()." ".MUx4NS();
       // echo "<br>".MUBad($y);
        return min(MUSatis($y),max(
            min(max(MUx1SN(),MUx1NS()),MUx2PS(),MUx3SN(),MUx4NS()),
            min(max(MUx1SN(),MUx1NS()),MUx2SN(),MUx3NS(),MUx4NS())));
    }
            
    function MUGood2($y){
        //echo "1) ".MUGood($y)."  ";
        //echo "2) ".min(max(MUx1SN(),MUx1PS()),MUx2NS(),MUx3NS(),MUx4NS())."<br>";
        return min(MUGood($y),max(
            min(MUx1NS(),MUx2SN(),MUx3PS(),MUx4SN()),
            min(MUx1NS(),max(MUx2SN(),MUx2PS()),MUx3PS(),MUx4NS()),
            min(MUx1SN(),MUx2SN(),MUx3SN(),MUx4NS())));
    }

    function MUExcel2($y){
        return min(MUExcel($y),min(
            MUx1NS(),MUx2SN(),MUx3SN(),max(MUx4SN(),MUx4PS())));
    }

    function MF($y){   // тут ещё по идее надо 2 к функциям добавить
        global $mark;
        if (max(MUBad($y),MUSatis($y)) > max(MUGood($y),MUExcel($y))){
            if (MUBad($y) > MUSatis($y)) $mark = 2;
            else $mark = 3;
        } else {
            if (MUGood($y) > MUExcel($y)) $mark = 4;
            else $mark = 5;
        }
        //echo MUBad($y) . " " . MUSatis($y) . " ".MUGood($y)." ".MUExcel($y)."<br>";
        return max(MUBad($y),MUSatis($y),MUGood($y),MUExcel($y));
    }

    function Defuz(){    // а зачем она вообще нужна??????
        $sum1 = $sum2 = 0;
        for ($y = 0; $y <= 100; $y += 2){
            switch ($mark){
                case 2: $sum1 += $y * MUBad($y); $sum2 += MF($y); break;
            }
            $sum1 += $y * MF($y);
            $sum2 += MF($y);
            //echo MF($y);
        }
        //$sum2=1; //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        return $sum1/$sum2;
    }

    function NoSpacesLowCase($s){
        return str_replace(' ','',strtolower($s));
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Тест</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <?php
            require_once "help_functions.php";
            printNavigation();        // вывели панель навигации
            printSidebarTest(1);    // вывели сайдбар для теста
        ?>
        
        <div id="page">
            <br><h1>Тест</h1><br><br> 
            <h2>Задание <?php echo $order_number ?></h2><br>             
            <div>
                <form action="<?php if ($order_number == QUAN_Q) echo "test_end.php"; else echo "test_q.php" ?>" method="POST" class="formtask">   
                <?php
                
    
        // здесь алгоритм с нечеткой логикой
                if ($order_number != 1){
                    switch ($level){
                        case 1: $cur_score = k1; break;
                        case 2: $cur_score = k2; break;
                        case 3: $cur_score = k3; break;
                    }
                    
                    if (isset($_POST['ans']) && NoSpacesLowCase($_POST['ans'])==NoSpacesLowCase($_POST['right_answer'])) // проверка правильности ответа
                        //$score+=$level;   // здесь же явная ошибка!
                        $score+=$cur_score;
                    
                    HelpVariables();
                    //print_r($x);
                    MF($x[1]);
                    //$defuz = Defuz();  // здесь mark сам собой опр-ся
                    //echo $mark." ".$defuz;
                    $_SESSION['mark'] = $mark;
                    
                    //echo "mark: " .$mark. "<br><br>";
                    
                    if ($level == 1 && ($mark == 3 || $mark == 4 || $mark == 5) || $level == 2 && ($mark == 4 || $mark == 5)) // контроль уровня сложности
                        ++$level;
                    else if ($level == 3 && ($mark == 3 || $mark == 2) || $level == 2 && $mark == 2)
                        --$level;
                    
                    if ($level == 1 && $mark == 5) 
                        ++$level;
                    else if ($level == 3 && $mark == 2)
                        --$level;
                    
                    // а теперь условие выхода "пораньше" из теста
                    if ((MF($x[1]) > 0.9) && ($order_number > 5))
                        header("Location: test_end.php");
                }
                
        // всё
                
                $order_number++;
                
                $result = mysqli_query($link,"select * from questions where `Level_Q`={$level};");  // запрос на задание
                if (!$result){die("<p>Ошибка 1: ".mysqli_error($link)."</p>");}
                $col_str = mysqli_num_rows($result);
                
                $the_task = NULL;
                $right_answer = NULL;
                
                $ar = array();                              // формируем массив подходящих строк (заданий)
                while ($row = mysqli_fetch_row($result)){ 
                    $ar[] = $row;
                }
                
                $some_num = 0;
                
                do                                          // выбрали случайное задание из подходящих
                    $some_num = rand(0, $col_str - 1);
                while ($was[$ar[$some_num][0]]);
                $the_task = $ar[$some_num];
                
                
                // задание выбрали
                $was[$the_task[0]] = 1;
                $w = implode(" ", $was);
                echo $the_task[1];
                
                // выводим задание с вариантами ответов                
                $result = mysqli_query($link,"select * from answers where `ID_Q`={$the_task[0]};");
                if (!$result){die("<p>Ошибка 2: ".mysqli_error($link)."</p>");}
                
                if ($level == 1){
                    while ($row = mysqli_fetch_row($result)){  // вытаскиваем все ответы на задание
                        echo '<br><input type="radio" value="'.$row[2].'" name="ans"> '.$row[2];
                        if ($row[3]) $right_answer = $row[2]; 
                    }
                    echo "<br><br>";
                    
                } else {
                    $row = mysqli_fetch_row($result);
                    $right_answer = $row[2]; 
                    // выводим задание с edit-полем
                    echo '<br><br><input type="text" size="50" name="ans"> <br><br>';
                }
                          
                //echo $right_answer;
                ?> 
                
                <input type="hidden" value="<?php echo $level ?>" name="level">
                <input type="hidden" value="<?php echo $score ?>" name="quan_right">
				<input type="hidden" value="<?php echo $order_number ?>" name="order_number">
				<input type="hidden" value="<?php echo $right_answer ?>" name="right_answer">
				<input type="hidden" value="<?php echo $w ?>" name="was">
                <input type="submit" name="submit" value="Далее" id="submit">
                </form>
            </div>
        </div>
        
    </body>
</html>