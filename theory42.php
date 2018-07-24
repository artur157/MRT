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
            printSidebarTheory(42);    // вывели сайдбар для теории
        ?>
        
        <div id="page">
            <br><h1>Ханойские башни</h1><br>
            <div class="leftfoto">
                <img src="img/hanoi.jpg" alt="">
                <figcaption>Модель Ханойской башни с восемью дисками</figcaption>
            </div>
            
            <?php       // выводим текст теории
                $file = file_get_contents('files/theory42.txt');
                $file = iconv("windows-1251", "utf-8", $file);
                echo $file;
            ?>
            
        </div>
        
    </body>
</html>