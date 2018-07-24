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
            <br><h2>Тест</h2><br>
            <ol>
                <li>Дан рекурсивный алгоритм:<br>
                <pre>
procedure F(n: integer);
begin
  writeln(n);
  if n < 5 then begin
    F(n + 1);
    F(n + 3)
  end
end;</pre>
                Найдите сумму чисел, которые будут выведены при вызове F(1).<br>
                <input type="text" id="field1"><br><br>
                </li>
                <li>Дан рекурсивный алгоритм:<br>
                <pre>
procedure F(n: integer);
begin
 writeln('*');
 if n > 0 then begin
   F(n-2);
   F(n div 2)
 end
end; </pre>
                Сколько символов "звездочка" будет напечатано на экране при выполнении вызова F(7)?<br>
                <input type="text" id="field2"><br><br>
                </li>
                <li>Процедура F(n), где n – натуральное число, задана следующим образом:<br>
                <pre>
procedure F(n: integer);
begin
  if n < 3 then
    write('*')
  else begin
    F(n-1);
    F(n-2);
    F(n-2)
  end;
end; </pre>
                Сколько звездочек напечатает эта процедура при вызове F(6)? В ответе запишите только целое число.<br>
                <input type="text" id="field3"><br><br>
                </li>
            </ol>
            
            <br><button id="submit" onclick="checkAnswers()">Проверить</button><br><br><div id="ans" class="minitest_result"></div><br><br>
            
            
            <a href="theory3.php">Вернуться к теории</a>
            
            <script>
                function checkAnswers(){
                    var score = 0;
                    if (document.getElementById("field1").value == '49'){
                        score++
                    }
                    if (document.getElementById("field2").value == '21'){
                        score++
                    }
                    if (document.getElementById("field3").value == '21'){
                        score++
                    }
                    document.getElementById("ans").innerHTML = score+" из 3 правильных ответов";
                }
            </script>
        </div>
        
    </body>
</html>