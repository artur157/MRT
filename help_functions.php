<?php
    function printNavigation(){
        echo '<div id="navigation">
            <ul>
                <li><a href="theory1.php">Теория</a></li>
                <li><a href="illustration1.php">Иллюстрация</a></li>
                <li><a href="test.php">Тест</a></li>
            </ul>
        </div>';
    }

    function printSidebarTheory($param){
        $str = '<div class="sidebar">
            <ul>
                <li><a href="theory1.php">Понятие рекурсии</a></li>
                <li><a href="theory2.php">Косвенная рекурсия</a></li>
                <li><a href="theory3.php">Рекурсия и итерация</a></li>
                <li><a href="theory5.php">Рекурсивная обработка списков</a></li>
                <li><a href="theory6.php">Рекурсивная обработка деревьев</a></li>
                <li>Примеры</li>
                <ul class="ex">
                    <li><a href="theory41.php">“Индийский алгоритм” возведения в степень</a></li>
                    <li><a href="theory42.php">Ханойские башни</a></li>
                    <li><a href="theory43.php">Обход графа в глубину</a></li>
                    <li><a href="theory44.php">Быстрая сортировка Хоара</a></li>
                </ul>
            </ul>
        </div>';
        
        if (!is_numeric($param)) $param = 1;
        
        $str = str_replace('theory'.$param.'.php"', 'theory'.$param.'.php" class="special"', $str);
        
        echo $str;
    }

    function printSidebarIllustration($param){
        $str = '<div class="sidebar" id="sidebar_i">
            <ul>
                <li><a href="illustration1.php">Сумма положительных элементов массива</a></li>
                <li><a href="illustration2.php">Вычисление факториала</a></li>
                <li><a href="illustration3.php">Числа Фибоначчи</a></li>
                <li class="bold"><a href="illustration4.php" >Написать программу</a></li>
            </ul>
            <button id="but">Пуск</button><br><br>
            <label>Время паузы:</label>
            <input type="text" id="pausetime" size="1" value="2" class="tbvton"> с
        </div>';
        
        if (!is_numeric($param)) $param = 1;
        
        $str = str_replace('illustration'.$param.'.php"', 'illustration'.$param.'.php" class="special"', $str);
        
        echo $str;
    }

    function printSidebarTest($param){
        $str = '<div class="sidebar">'; 
        if ($param != 0) $str .= '<font size="+2"><br>'.$_SESSION['firstName']." ".$_SESSION['lastName'].'<br></font>
            <a href="test.php">Выйти</a><br><br>
            <a href="result.php">Просмотреть мои результаты</a>';
        $str .= '</div>';
        echo $str;
    }


?>