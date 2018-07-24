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
            
            <?php       // выводим текст теории
                $file = file_get_contents('files/theory3.txt');
                $file = iconv("windows-1251", "utf-8", $file);
                echo $file;
            ?>
            <br>
            <button id="submit" onclick="javascript: document.location.href = 'theory3_tasks1.php';">Задачи для самостоятельного решения</button>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="submit" onclick="javascript: document.location.href = 'theory3_tasks2.php';">Тест</button>
        </div>
        
    </body>
</html>