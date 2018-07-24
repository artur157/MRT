<html>
    <head>
        <meta charset="utf-8">
        <title>Теория: примеры</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <?php
            require_once "help_functions.php";
            printNavigation();        // вывели панель навигации
            printSidebarTheory(41);    // вывели сайдбар для теории
        ?>
        
        <div id="page">
            <br><h1>“Индийский алгоритм” возведения в степень</h1><br>
            
            <?php       // выводим текст теории
                $file = file_get_contents('files/theory41.txt');
                $file = iconv("windows-1251", "utf-8", $file);
                echo $file;
            ?>
            
        </div>
        
    </body>
</html>