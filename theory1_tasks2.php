<html>
    <head>
        <meta charset="utf-8">
        <title>Теория: понятие рекурсии</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <?php
            require_once "help_functions.php";
            printNavigation();        // вывели панель навигации
            printSidebarTheory(1);    // вывели сайдбар для теории
        ?>
        
        <div id="page">
            <br><h1>Понятие рекурсии</h1><br>
            <br><h2>Тест</h2><br>
            <ol>
                <li>Что напечатает приведенная ниже процедура при вызове Rec(4)?<br>
                <pre>
procedure Rec(a: integer);
begin
  write(a);
  if a>0 then
    Rec(a-1);
  write(a);
end;</pre>
                <input type="text" id="field1"><br><br>
                </li>
                <li>Чему будет равно значение функции Nod(78, 26)?<br>
                <pre>
function Nod(a, b: integer): integer;
begin
  if a > b then
    Nod := Nod(a – b, b)
  else
    if b > a then
      Nod := Nod(a, b – a)
    else
      Nod := a;
end; </pre>
                <input type="text" id="field2"><br><br>
                </li>
                <li>Что напечатает нижеприведенная процедура при вызове BT(0, 1, 3)?<br>
                <pre>
procedure BT(x, D, MaxD: integer);
begin
  if D = MaxD then
    write(x)
  else
  begin
    BT(x – 1, D + 1, MaxD);
    BT(x + 1, D + 1, MaxD);
  end;
end; </pre>
                <input type="text" id="field3"><br><br>
                </li>
            </ol>
            
            <br><button id="submit" onclick="checkAnswers()">Проверить</button><br><br><div id="ans" class="minitest_result"></div><br><br>
            
            
            <a href="theory1.php">Вернуться к теории</a>
            
            <script>
                function checkAnswers(){
                    var score = 0;
                    if (document.getElementById("field1").value == '4321001234'){
                        score++
                    }
                    if (document.getElementById("field2").value == '26'){
                        score++
                    }
                    if (document.getElementById("field3").value == '-2002'){
                        score++
                    }
                    document.getElementById("ans").innerHTML = score+" из 3 правильных ответов";
                }
            </script>
        </div>
        
    </body>
</html>