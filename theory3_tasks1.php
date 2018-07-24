<html>
    <head>
        <meta charset="utf-8">
        <title>Теория: рекурсия и итерация</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <?php
            require_once "help_functions.php";
            printNavigation();        // вывели панель навигации
            printSidebarTheory(3);    // вывели сайдбар для теории
        ?>
        
        <div id="page">
            <br><h1>Рекурсия и итерация</h1><br>
            <br><h2>Задачи для самостоятельного решения</h2><br>
            <ol>
                <li>Написать рекурсивную и нерекурсивную функции вычисления полинома: H<sub>n</sub>(x) = x*H<sub>n-1</sub>(x)-(n-2)*H<sub>n-2</sub>(x).</li>
                <li>Написать рекурсивную и нерекурсивную функции вычисления выражения<br><img src="img/rec_it_task.jpg" alt=""></li>
                <li>Написать рекурсивную и нерекурсивную функции вычисления выражения<br><img src="img/rec_it_task2.jpg" alt=""></li>
                <li>Написать рекурсивную и нерекурсивную функции вычисления выражения<br><img src="img/rec_it_task3.jpg" alt=""></li>
                <li>Написать рекурсивную и нерекурсивную функции вычисления выражения<br><img src="img/rec_it_task4.jpg" alt=""></li>
            </ol>
            
            
            <br>
            <a href="theory3.php">Вернуться к теории</a>
        </div>
        
    </body>
</html>