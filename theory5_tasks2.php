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
            <br><h2>Тест</h2><br>
            <ol>
                <li>Что напечатает приведенная ниже процедура при вызове P(L), где L представляет собой список <7, 3, 11>?<br>
                <pre>
procedure P(L: list);
begin
  if L <> nil then begin 
    write(L^.elem,' ');
    P(L^.next)
  end;
end;</pre>
                <input type="text" id="field1"><br><br>
                </li>
                <li>Что напечатает приведенная ниже процедура при вызове Q(L), где L представляет собой список <-2, 9, 5>?<br>
                <pre>
procedure Q(L: list);
begin 
  if L^.next <> nil then begin
    write(L^.next^.elem,' ');
    Q(L^.next) 
  end;
end;  </pre>
                <input type="text" id="field2"><br><br>
                </li>
                <li>Что напечатает приведенная ниже процедура при вызове R(L), где L представляет собой список <8, 6, -3>?<br>
                <pre>
function R(L: list): integer;
begin
  if L = nil then R:= 0
  else R:= L^.elem + R(L^.next)
end; </pre>
                Сколько звездочек напечатает эта процедура при вызове F(6)? В ответе запишите только целое число.<br>
                <input type="text" id="field3"><br><br>
                </li>
            </ol>
            
            <br><button id="submit" onclick="checkAnswers()">Проверить</button><br><br><div id="ans" class="minitest_result"></div><br><br>
            
            
            <a href="theory5.php">Вернуться к теории</a>
            
            <script>
                function checkAnswers(){
                    var score = 0;
                    if (document.getElementById("field1").value == '7 3 11'){
                        score++
                    }
                    if (document.getElementById("field2").value == '9 5'){
                        score++
                    }
                    if (document.getElementById("field3").value == '11'){
                        score++
                    }
                    document.getElementById("ans").innerHTML = score+" из 3 правильных ответов";
                }
            </script>
        </div>
        
    </body>
</html>