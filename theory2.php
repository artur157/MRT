<html>
    <head>
        <meta charset="utf-8">
        <title>Теория: косвенная рекурсия</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <?php
            require_once "help_functions.php";
            printNavigation();        // вывели панель навигации
            printSidebarTheory(2);    // вывели сайдбар для теории
        ?>
        
        <div id="page">
            <br><h1>Косвенная рекурсия</h1><br>
            
            <?php       // выводим текст теории
                $file = file_get_contents('files/theory2.txt');
                $file = iconv("windows-1251", "utf-8", $file);
                echo $file;
            ?>
            <br>
            <button id="submit" onclick="javascript: document.location.href = 'theory2_tasks2.php';">Тест</button>
        </div>
        
    </body>
</html>