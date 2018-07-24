<html>
    <head>
        <meta charset="utf-8">
        <title>Теория: рекурсивная обработка списков</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <?php
            require_once "help_functions.php";
            printNavigation();        // вывели панель навигации
            printSidebarTheory(5);    // вывели сайдбар для теории
        ?>
        
        <div id="page">
            <br><h1>Рекурсивная обработка списков</h1><br>
            
            <?php       // выводим текст теории
                $file = file_get_contents('files/theory5.txt');
                $file = iconv("windows-1251", "utf-8", $file);
                echo $file;
            ?>
            <br><img src="img/lists.png" alt="">
            <br><br><br>
            <button id="submit" onclick="javascript: document.location.href = 'theory5_tasks1.php';">Задачи для самостоятельного решения</button>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="submit" onclick="javascript: document.location.href = 'theory5_tasks2.php';">Тест</button>
        </div>
        
    </body>
</html>