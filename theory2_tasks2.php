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
            <br><h2>Тест</h2><br>
            <ol>
                <li>Для чего используется директива forward?<br>
                    <input type="radio" value="a1" name="radio_ans">для определения директив компилятора при работе с косвенной рекурсией<br>
                    <input type="radio" value="a2" name="radio_ans">для определения рекурсивных подпрограмм<br>
                    <input type="radio" value="a3" name="radio_ans">для объявления косвенности рекурсии в подпрограммах<br>
                    <input type="radio" value="a4" name="radio_ans">для объявления заголовков подпрограмм, которые будут определены далее в программе<br>
                </li><br>
                <li>Что будет напечатано приведенными ниже процедурами при вызове A(1)?<br>
                <pre>
procedure B(n: integer); forward;
 
procedure A(n: integer);
begin
  write(n);
  B(n-1);
end;

procedure B(n: integer);
begin
  write(n);
  if n < 5 then
    A(n+2);
end; </pre>
                <input type="text" id="field2"><br><br>
                </li>
                <li>Чему будет равно значение функции F(3)?<br>
                <pre>
function G(n: integer): integer; forward;

function F(n: integer): integer;
begin
   if n=1 then F:= 0
   else F:= 3*F(n-2)-2*G(n-1)
end;

function G(n: integer): integer;
begin
   if n=1 then G:= 1
   else G:= F(n-1)+1
end;</pre>
                <input type="text" id="field3"><br><br>
                </li>
            </ol>
            
        
            <br><button id="submit" onclick="checkAnswers()">Проверить</button><br><br><div id="ans" class="minitest_result"></div><br><br>
            
            
            <a href="theory2.php">Вернуться к теории</a>
            
            <script>
                function checkAnswers(){
                    var score = 0;
                    if (document.getElementsByName('radio_ans')[3].checked){
                        score++
                    }
                    if (document.getElementById("field2").value == '102132435465'){
                        score++
                    }
                    if (document.getElementById("field3").value == '-2'){
                        score++
                    }
                    document.getElementById("ans").innerHTML = score+" из 3 правильных ответов";
                }
            </script>
        </div>
        
    </body>
</html>