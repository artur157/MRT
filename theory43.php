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
            printSidebarTheory(43);    // вывели сайдбар для теории
        ?>
        
        <div id="page">
            <br><h1>Обход графа в глубину</h1><br>
            <div class="rightfoto">
                <img src="img/DFS.png" alt="">
                <figcaption>Порядок обхода дерева в глубину</figcaption>
            </div>
            
            <?php       // выводим текст теории
                $file = file_get_contents('files/theory43.txt');
                $file = iconv("windows-1251", "utf-8", $file);
                echo $file;
            ?>
            
        </div>
        
    </body>
</html>