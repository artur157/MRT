<?php
    require_once 'connect.php';
    
    mysqli_query($link,"SET NAMES utf8");

    session_start();
    $login     = $_SESSION['login'];
    $firstName = $_SESSION['firstName'];
    $lastName  = $_SESSION['lastName'];

    define ("QUAN_Q",10);                     // кол-во вопросов в базе
    define ("k1",0.4);                        // коэф. за ответ на ур. сл. 1
    define ("k2",0.6);                        // коэф. за ответ на ур. сл. 2
    define ("k3",0.8);                        // коэф. за ответ на ур. сл. 3
    $level        = $_POST['level'];
    $score        = $_POST['quan_right'];     // кол-во правильно отвеченных вопросов 
    $order_number = $_POST['order_number'];
    $w            = $_POST['was'];            // массив, i-й эл = 1 <=> вопрос с ID_Q == i уже был задан  
    $was          = explode(" ",$w); 
    $mark;                                    // оценка после аккумуляции

    $x = array();                        
    for ($i = 0; $i < 5; ++$i)
         $x[] = 0;

    function HelpVariables(){
        global $x, $score, $order_number;
        
        // определим вспомогательные перем. xi
        $x[1] = $score - (2*k1*(intval(QUAN_Q/15)+intval((QUAN_Q-5)/15))+k1*intval((QUAN_Q-10)/15));
        if (QUAN_Q % 2 == 1){
            $x[2] = $score*10/(k3*($order_number-1)) - (3*k1*intval(QUAN_Q/10)+2*k1*(QUAN_Q/10-1.5));
            $x[3] = $score*10/(k3*($order_number-1)) - (2*k2*intval(QUAN_Q/10)+3*k2*(QUAN_Q/10-1.5));
        }
        else {
            $x[2] = $score*10/(k3*($order_number-1)) - 5*k1*(QUAN_Q/10-1);
            $x[3] = $score*10/(k3*($order_number-1)) - 5*k2*(QUAN_Q/10-1);
        }
        $x[4] = $score*10/(0.8*($order_number-1))*(k3*(QUAN_Q-2)+1)/(k3*(QUAN_Q-2)+1+0.8*(QUAN_Q-10));
//print_r($x);
        // нормируем их на 0..100
        for ($i = 1; $i < 5; ++$i)
            if ($x[$i] > 7.4) $x[$i] = 100;
            else if ($x[$i] > 5.4) $x[$i] = 100 - pow(3, 7.4 - $x[$i]);
                 else if ($x[$i] > 3.4) $x[$i] = 74 + 4.5 * ($x[$i] - 3.4);
                      else if ($x[$i] > 2.7) $x[$i] = 66 + 11.4 * ($x[$i] - 2.7);
                           else if ($x[$i] > 2) $x[$i] = 57 + 12.8 * ($x[$i] - 2);
                                else if ($x[$i] > 1.6) $x[$i] = 49 + 20 * ($x[$i] - 1.6);
                                     else if ($x[$i] > 1.2) $x[$i] = 24 + 62.5 * ($x[$i] - 1.2);
                                          else $x[$i] *= 20;
    }

    function MU3($xi,$a,$b,$c){
        if ($xi > $c) return 0;
        else if ($xi > $b) return ($c-$xi)/($c-$b);
             else if ($xi > $a) return ($xi-$a)/($b-$a);
                  else return 0;
    } 
        
    function MU4($xi,$a,$b,$c,$d){
        if ($xi > $d) return 0;
        else if ($xi > $c) return ($d-$xi)/($d-$c);
             else if ($xi > $b) return 1;
                  else if ($xi > $a) return ($xi-$a)/($b-$a);
                       else return 0;
    } 

    function MUx1PS(){global $x; return MU4($x[1],0,0,15,30);}
    function MUx1SN(){global $x; return MU4($x[1],40,55,100,100);}
    function MUx1NS(){global $x; return MU3($x[1],20,35,50);}
    function MUx2PS(){global $x; return MU3($x[2],30,50,70);}
    function MUx2SN(){global $x; return MU4($x[2],60,70,100,100);}
    function MUx2NS(){global $x; return MU4($x[2],0,0,20,40);}
    function MUx3PS(){global $x; return MU3($x[3],55,70,85);}
    function MUx3SN(){global $x; return MU4($x[3],70,90,100,100);}
    function MUx3NS(){global $x; return MU4($x[3],0,0,50,70);}
    function MUx4PS(){global $x; return MU4($x[4],80,90,100,100);}
    function MUx4SN(){global $x; return MU3($x[4],70,80,90);}
    function MUx4NS(){global $x; return MU4($x[4],0,0,70,80);}     
    
    function MUBad($y){return MU4($y,0,0,25,50);}
    function MUSatis($y){return MU3($y,40,55,70);}
    function MUGood($y){return MU3($y,60,75,90);}
    function MUExcel($y){return MU4($y,80,90,100,100);}

    function MUBad2($y){
        return min(MUBad($y),max(
            min(max(MUx1SN(),MUx1PS()),MUx2NS(),MUx3NS(),MUx4NS()),
            min(MUx1PS(),MUx2SN(),MUx3SN(),MUx4NS())));
    }

    function MUSatis2($y){
       // echo "<br><br><br>";
       // echo MUx1SN()." ".MUx1NS()." ".MUx2PS()." ".MUx3SN()." ".MUx4NS()." ".MUx1SN()." ".MUx1NS()." ".MUx2SN()." ".MUx3NS()." ".MUx4NS();
       // echo "<br>".MUBad($y);
        return min(MUBad($y),max(
            min(max(MUx1SN(),MUx1NS()),MUx2PS(),MUx3SN(),MUx4NS()),
            min(max(MUx1SN(),MUx1NS()),MUx2SN(),MUx3NS(),MUx4NS())));
    }
            
    function MUGood2($y){
        return min(MUBad($y),max(
            min(MUx1NS(),MUx2SN(),MUx3PS(),MUx4SN()),
            min(MUx1NS(),max(MUx2SN(),MUx2PS()),MUx3PS(),MUx4NS()),
            min(MUx1SN(),MUx2SN(),MUx3SN(),MUx4NS())));
    }

    function MUExcel2($y){
        return min(MUBad($y),min(
            MUx1NS(),MUx2SN(),MUx3SN(),max(MUx4SN(),MUx4PS())));
    }

    function MF($y){
        global $mark;
        if (max(MUBad2($y),MUSatis2($y)) > max(MUGood2($y),MUExcel2($y))){
            if (MUBad2($y) > MUSatis2($y)) $mark = 2;
            else $mark = 3;
        } else {
            if (MUGood2($y) > MUExcel2($y)) $mark = 4;
            else $mark = 5;
        }
        return max(MUBad2($y),MUSatis2($y),MUGood2($y),MUExcel2($y));
    }

    function Defuz(){
        $sum1 = $sum2 = 0;
        for ($y = 0; $y <= 100; $y += 5){
            $sum1 += $y * MF($y);
            $sum2 += MF($y);
            //echo MF($y);
        }
        //$sum2=1; //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        return $sum1/$sum2;
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
            <font size="+2"><br><?php echo $firstName." ".$lastName; ?><br></font>
            <a href="test.php">Выйти</a><br><br>
            <a href="result.php">Просмотреть мои результаты</a>
        </div>
        
        <div id="page">
            <br><h1>Тест</h1><br><br> 
            <h2>Задание <?php echo $order_number ?></h2><br>             
            <div>
                <form action="<?php if ($order_number == QUAN_Q) echo "test_end.php"; else echo "test_q.php" ?>" method="POST">   
                <?php
                
        // здесь алгоритм с нечеткой логикой
                if ($order_number != 1){
                    if ($_POST['ans']==$_POST['right_answer'])    // проверка правильности ответа
                        $score+=$level;   
                    
                    HelpVariables();
                    //print_r($x);
                    $defuz = Defuz();
                    //echo $mark." ".$defuz;
                    $_SESSION['mark'] = $mark;
                    
                    if ($level == 1 && ($mark == 4 || $mark == 5) || $level == 2 && $mark == 5) // контроль уровня сложности
                        ++$level;
                    else if ($level == 3 && ($mark == 3 || $mark == 2) || $level == 2 && $mark == 2)
                        --$level;
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
                
                do                                          // выбрали случайное задание из подходящих
                    $some_num = rand(0, $col_str - 1);
                while ($was[$ar[$some_num][0]]);
                $the_task = $ar[$some_num];
                
                
                // задание выбрали
                /////////////////////////////$was[$the_task[0]] = 1;
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