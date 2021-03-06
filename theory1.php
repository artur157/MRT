<html>
    <head>
        <meta charset="utf-8">
        <title>Теория: понятие рекурсии</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <?php
            require_once "help_functions.php";
            printNavigation();        // вывели панель навигации
            printSidebarTheory(1);    // вывели сайдбар для теории
        ?>
        
        <div id="page">
            <br><h1>Понятие рекурсии</h1><br>
            <div class="leftfoto">
                <img src="img/uroboros.png" alt="">
                <figcaption>Образное представление рекурсии. Уроборос – змей, пожирающий свой хвост</figcaption>
            </div>
            
            <?php       // выводим текст теории
                $file = file_get_contents('files/theory1.txt');
                $file = iconv("windows-1251", "utf-8", $file);
                echo $file;
            ?>
            
            <br>
            <button id="submit" onclick="javascript: document.location.href = 'theory1_tasks1.php';">Задачи для самостоятельного решения</button>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="submit" onclick="javascript: document.location.href = 'theory1_tasks2.php';">Тест</button>
        </div>
        
    </body>
</html>