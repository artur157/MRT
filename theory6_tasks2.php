<html>
    <head>
        <meta charset="utf-8">
        <title>Теория: рекурсивная обработка деревьев</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <?php
            require_once "help_functions.php";
            printNavigation();        // вывели панель навигации
            printSidebarTheory(6);    // вывели сайдбар для теории
        ?>
        
        <div id="page">
            <br><h1>Рекурсивная обработка деревьев</h1><br>
            <br><h2>Тест</h2><br>
            Для дерева
            <br><br><img src="img/tree_task.jpg" alt=""><br><br>
            укажите последовательности посещения узлов при <br>
            прямом <input type="text" id="field1"><br>
            обратном <input type="text" id="field2"><br>
            синтаксическом <input type="text" id="field3"> <br>
            порядке обхода (вводить без запятых и пробелов).<br>
            <br><button id="submit" onclick="checkAnswers()">Проверить</button><br><br><div id="ans" class="minitest_result"></div><br><br>
            
            
            <a href="theory6.php">Вернуться к теории</a>
            
            <script>
                function checkAnswers(){
                    var score = 0;
                    if (document.getElementById("field1").value == '831647101413'){
                        score++
                    }
                    if (document.getElementById("field2").value == '147631314108'){
                        score++
                    }
                    if (document.getElementById("field3").value == '134678101314'){
                        score++
                    }
                    document.getElementById("ans").innerHTML = score+" из 3 правильных ответов";
                }
            </script>
        </div>
        
    </body>
</html>