<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Иллюстрация</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <?php
            require_once "help_functions.php";
            printNavigation();        // вывели панель навигации
            printSidebarIllustration(4);    // вывели сайдбар для иллюстрации
        ?>
        
        <div id="page_ill">
          <textarea name="programma" id="program_textarea" ></textarea>
          <div id="program">  <!-- 
<pre>var a: integer;

function Fib(n: integer): integer;
begin
  if n > 1 then
    Fib := Fib(n-1) + Fib(n-2)
  else
    Fib := 1;
end;

begin
  <span id="s1">a := Fib(3);</span>  
end. </pre>   -->
            </div>
            
            <div id="variables">
                <div id="stack"> 
                    <span id="stack1"> </span>
                    <span id="stack2"> </span>
                    <span id="stack3"> </span>
                    <span id="stack4"> </span>
                    <span id="stack5"> </span>
                </div> 
            </div>
            
            
      <!--       <textarea name="mod_body" id="mod_body" readonly></textarea>  -->
           <div id="mod_body"><!-- 
<pre>
<span id="s2">n:= 3;</span>     
<span id="s3">Fib:= Fib(2) + Fib(1);</span>  
      
<span id="s4">n:= 2;</span>    
<span id="s5">Fib:= Fib(1) + Fib(0);</span>  
     
<span id="s6">n:= 1;</span>   
<span id="s7">Fib:= 1;</span>   
    
<span id="s8">n:= 0;</span>   
<span id="s9">Fib:= 1;</span> 

<span id="s10">Fib:= 1 + 1;</span>  
    
<span id="s11">n:= 1;</span>   
<span id="s12">Fib:= 1;</span> 
    
<span id="s13">Fib:= 2 + 1;</span>     
</pre>   -->
            </div>
            
            <div id="scheme">
                <canvas id="sch" width="650" height="500"></canvas>  
            </div>
            
            <div id="console">
                  
            </div>
        </div>
        
        <script src="scripts/jquery-3.1.1.min.js"></script>
        <script>
            var textarea = document.getElementById("program_textarea");
            var program = document.getElementById("program");
            var mod_body = document.getElementById("mod_body");
            var console = document.getElementById("console");
            var vararea = document.getElementById("variables");
            var stack1 = document.getElementById("stack1");
            var s1 = document.getElementById('s1');
            var but = document.getElementById('but');
            
            var kol = 0;
            const inttime = 200;
            var canvas = document.getElementById("sch");
            var context = canvas.getContext("2d");
            
            context.fillStyle = "#515";
            context.lineWidth=5;
            context.strokeStyle="#9F5F9F";
            context.font = "16pt sans-serif";
            
            $(program).hide();
            
            var targetStack = [];// СТЕК ЦЕЛЕЙ (funcToGo, valToGo, id, parent_id)
            var targetStackOk = [];  // в этот стек попадают уже посчитанные значения
            var curId = 0;       // id новоявленной цели
            var variables = [];  // тут будут имена переменных и их значения (тип везде integer)
            var functions = [];  // тут будут функции (имя, тело и список параметров)
            var procedures = []; // тут будут процедуры
            var vertexes = [];   // тут хранятся вершины дерева (x, y, func, val, id, parent_id)
            var maxKolCalls = 2; // макс число рек вызовов в строке (потом посчитается)
            
            var funcToGo = "";   // имя функции на выход
            var valToGo = 0;     // значение на выход
            var targetId = 0;    // 
            var targetParentId = 0;    // 
            var text;            // текст программы (позже мод. тела)
            var resultValue;
            var stack = [];      // стек в смысле где блок переменных
            
            // рекомендации (справка)
            alert("Справка\n\nПодмножество распознаваемых программ имеет следующие ограничения. Для всех переменных предусмотрен тип данных integer. Непредусмотрено использование констант, операторов цикла, операторов ввода с клавиатуры, файлов, объектов. Параметры подпрограмм могут быть только параметрами-значениями. Настоятельно рекомендуется давать переменным имена, состоящие из одной строчной буквы, а именам подпрограмм - из одной прописной. При несоблюдении данных ограничений возможна некорректная визуализация либо зависание. При возникновении ошибок рекомендуется обновить страницу.");
            
            function isalpha(c) {
                return (((c >= 'a') && (c <= 'z')) || ((c >= 'A') && (c <= 'Z')));
            }
    
            function isdigit(c) {
                return ((c >= '0') && (c <= '9'));
            }

            function isalnum(c) {
                return (isalpha(c) || isdigit(c));
            }
            
            function hasLetter(c){
                for(var i=0; i<c.length; ++c){
                    if (isalpha(c[i])){
                        return true;
                    }
                }
                return false;
            }
            
            function textHasBadWords(ttt){
                return (ttt.indexOf("while ") == -1 && 
                    ttt.indexOf(" do") == -1 && 
                    ttt.indexOf("repeat") == -1 && 
                    ttt.indexOf("until ") == -1 && 
                    ttt.indexOf("for ") == -1 && 
                    ttt.indexOf(": byte") == -1 && 
                    ttt.indexOf(": real") == -1 && 
                    ttt.indexOf(": char") == -1 && 
                    ttt.indexOf(": string") == -1 && 
                    ttt.indexOf("const ") == -1 && 
                    ttt.indexOf("^") == -1 && 
                    ttt.indexOf("/") == -1 && 
                    ttt.indexOf("read(") == -1 && 
                    ttt.indexOf("readln(") == -1) ? false : true;
            }
            
            function drawLineAndText(x1, y1, x2, y2, text1){
                context.beginPath();
                context.moveTo(x1,y1);
                context.lineTo(x2,y2);
                context.stroke();
                context.beginPath();
                context.fillStyle = "#9F5F9F";
                context.arc(x2,y2,10,0,2*Math.PI, true);
                context.fill();
                context.fillStyle = "#515";
                context.fillText(text1,x2+10-y2/25,y2-20);
            }
            
            function alreadyIsInVertexes(xx,yy){
                //alert("JSON.stringify = " + JSON.stringify(vertexes, "", 4));
                for(var u=0;u<vertexes.length;++u){
                    if (vertexes[u] !== undefined && vertexes[u]["x"] == xx && vertexes[u]["y"] == yy){
                        return true;
                    }
                }
                return false;
            }
            
            function defineMaxKolCalls(){
                // пройтись по всем подпрограммам и выбрать максимум вхождений - кол-во повторений названия функции (этой или других) в строке
                var zapisi = "";
                
                for (var j = 0; j<functions.length; ++j){
                    zapisi += functions[j]["ftext"]+"\n";
                }

                zapisi = zapisi.split("\n");
                
                var max_kol_vh = 0;
                
                for (var k = 0; k<zapisi.length; ++k){
                    var kol_vh = 0;
                    
                    for (var j = 0; j<functions.length; ++j){
                        kol_vh += zapisi[k].count(functions[j]["name"]);
                    }
                    
                    if (max_kol_vh < kol_vh)
                        max_kol_vh = kol_vh;
                }
                
                max_kol_vh--;
                
                if (procedures.length > 0){
                    // для процедур придётся смотреть сколько вызовов во всем теле (хотя конечно и по логике надо лишь по ветви смотреть, но нам это сложно)
                    for (var k = 0; k<procedures.length; ++k){
                        var kol_vh = procedures[k]["ftext"].count(procedures[k]["name"]);
                        if (max_kol_vh < kol_vh)
                            max_kol_vh = kol_vh;
                    }
                }
                
                return max_kol_vh;
            }
            
            function newBranchInTree(funcToGo_, valToGo_, child_id, parent_id){
                var text2 = funcToGo_+"("+valToGo_+")";
                
                var cy = vertexes[parent_id]["y"]+100;
                var cx = vertexes[parent_id]["x"];
                
                if (maxKolCalls > 1){
                    cx = vertexes[parent_id]["x"]-100*(200/vertexes[parent_id]["y"]-0.4);
                    while (alreadyIsInVertexes(cx,cy)){
                        cx += 200*(200/vertexes[parent_id]["y"]-0.4)/(maxKolCalls-1);
                    }
                }
                
                vertexes[child_id] = {x: cx, y: cy, func: funcToGo_, val: valToGo_, id: child_id, parent_id: parent_id, marked: 0}; 
                //drawLineAndText(vertexes[parent_id]["x"], vertexes[parent_id]["y"], vertexes[child_id]["x"], vertexes[child_id]["y"],text2);
            }
            
            function findGreaterUnmarkedSon(pid){
                var cid;
                for(var i_=0; i_<vertexes.length; ++i_){
                    if (vertexes[i_]["parent_id"] == pid && vertexes[i_]["marked"] == 0){
                        cid = vertexes[i_]["id"];
                    }
                }
                return cid;
            }
            
            function findLeastUnmarkedSon(pid){
                var cid;
                for(var i_=vertexes.length-1; i_>=0; --i_){
                    if (vertexes[i_]["parent_id"] == pid && vertexes[i_]["marked"] == 0){
                        cid = vertexes[i_]["id"];
                    }
                }
                return cid;
            }
            
            function deleteDuplicateEnter(){
                for(var i=0;i<10;++i)
                    text = text.replaceAll("\n\n","\n");
                text = text.substring(0,text.lastIndexOf("\n"));
                while (!isalpha(text[0]))
                    text = text.substring(1);
            }
            
            function deleteTriplicateEnter(){
                for(var i=0;i<10;++i)
                    text = text.replaceAll("\n\n\n","\n\n");
                while (!isalpha(text[0]))
                    text = text.substring(1);
            }
            
            function analyzeForward(){   // если в строке есть слово форвард, удаляем строку нахрен
                if (text.substring(0,text.indexOf("\n")).indexOf("forward") > 0){
                    text = text.substring(text.indexOf("\n")+1);
                }
            }
            
            function analyzeVar(){    // анализируем вначале переменную (правда подразумевается что если она есть то одна)
                if (text.substring(0,3) == "var"){
                    var token = "";
                    i = 4;
                    while (!isalpha(text[i])){
                        i++;
                    }
                    while (text[i] != ":"){
                        token+=text[i];
                        i++;
                    } 
                    // тут создать перем с именем token и знач-ем 0
                    var var1 = {name: token, value: 0};
                    variables.push(var1);
                    text = text.substring(text.indexOf("\n")+1);
                }
            }
            
            function kolBeginEnd(c){  // выдает баланс бэгин и энд
                var balance = 0;
                /*while(c.indexOf("begin", balance+1) != -1){
                    balance++;
                }
                var num = 1;
                while(c.indexOf("end", num) != -1){
                    balance--;
                    num++;
                }*/
                var vh = 0;
                while(c.indexOf("begin", vh) != -1){
                    vh = c.indexOf("begin", vh) + 1;
                    balance++;
                }
                vh = 0;
                while(c.indexOf("end", vh) != -1){
                    vh = c.indexOf("end", vh) + 1;
                    balance--;
                }
                return balance;
            }
            
            function noInVariables(c){
                for (var j=0; j<variables.length; ++j){
                    if (variables[j]["name"] == c){
                        return false;
                    }
                }
                return true;
            }
            
            function noInFunctions(c){
                for (var j=0; j<functions.length; ++j){
                    if (functions[j]["name"] == c){
                        return false;
                    }
                }
                return true;
            }
            
            function analyzeSubprogs(){
                while (true){
                    if (text.substr(0,8) == "function"){
                        var str1 = text.substring(9,text.indexOf("\n")-10);
                        text = text.substring(text.indexOf("\n")+1);
                        // имеем имя ф-ии и аргументы с указанием типа в скобках
                        var token = "";
                        while (isalpha(str1[0])){
                            token += str1[0];
                            str1 = str1.substring(1);
                        }
                        var params = [];
                        if (str1[0] == "("){
                            str1 = str1.substring(1,str1.indexOf(":"));
;                            // имеем список аргументов через запятую
                            while(true){
                                while(str1.length > 0 && !isalpha(str1[0])){
                                    str1 = str1.substring(1);      
                                }
                                var varName = "";
                                while(str1.length > 0 && isalpha(str1[0])){
                                    varName += str1[0];
                                    str1 = str1.substring(1);   
                                }
                                params.push(varName);
                                if (noInVariables(varName)){
                                    var newvar = {name: varName, value: 0};
                                    variables.push(newvar);
                                }
                                if (str1.length == 0){
                                    break;
                                }
                            }
                        }
                        
                        var ftext = ""; // ?   (а теперь я не могу понять зачем тут этот вопросик)
                        
                        var num = 0;
                        while (true){
                            var ot = text.indexOf("\n")+1;         // после бегина
                            var doo = text.indexOf("end;", num)-1; // до энда
                            if (kolBeginEnd(text.substring(ot, doo)) == 0){
                                ftext = text.substring(ot, doo);
                                text = text.substring(doo+6);
                                break;
                            }
                            num = text.indexOf("end;", num) + 1;
                        }
                        
                        var var1 = {name: token, params: params, ftext: ftext.trim()};
                        functions.push(var1);
                        var var2 = {name: token, value: 0};
                        variables.push(var2);
                        
                    }
                    else if (text.substr(0,9) == "procedure"){ 
                        var str1 = text.substring(10,text.indexOf("\n")-1);
                        text = text.substring(text.indexOf("\n")+1);
                        // имеем имя ф-ии и аргументы с указанием типа в скобках
                        var token = "";
                        while (isalpha(str1[0])){
                            token += str1[0];
                            str1 = str1.substring(1);
                        }
                        var params = [];
                        if (str1[0] == "("){
                            str1 = str1.substring(1,str1.indexOf(":"));
;                            // имеем список аргументов через запятую
                            while(true){   // а не легче тут было сделать split по запятой?
                                while(str1.length > 0 && !isalpha(str1[0])){
                                    str1 = str1.substring(1);      
                                }
                                var varName = "";
                                while(str1.length > 0 && isalpha(str1[0])){
                                    varName += str1[0];
                                    str1 = str1.substring(1);   
                                }
                                params.push(varName);
                                if (noInVariables(varName)){
                                    var newvar = {name: varName, value: 0};
                                    variables.push(newvar);
                                }
                                if (str1.length == 0){
                                    break;
                                }
                            }
                        }
                        
                        var ftext = ""; // ?   (а теперь я не могу понять зачем тут этот вопросик)
                        
                        var num = 0;
                        while (true){
                            var ot = text.indexOf("\n")+1;         // после бегина
                            var doo = text.indexOf("end;", num)-1; // до энда
                            if (kolBeginEnd(text.substring(ot, doo)) == 0){
                                ftext = text.substring(ot, doo);
                                text = text.substring(doo+6);
                                break;
                            }
                            num = text.indexOf("end;", num) + 1;
                        }
                    
                        var var1 = {name: token, params: params, ftext: ftext.trim()};
                        procedures.push(var1);
                        //var var2 = {name: token, value: 0};  это не надо
                        //variables.push(var2);
                        
                    }
                    
                    else{
                        break;
                    }
                }
            }
            
            function analyzeTarget(){   // надобно доопределить -----------------------------------------
                // взять предпоследнюю строку
                var str1 = text.substring(text.lastIndexOf("\n",text.lastIndexOf("\n")-1),text.lastIndexOf("\n")).trim();
                // удалить 3 посл строки
                for (var i = 0; i < 3; ++i){
                    text = text.substring(0,text.lastIndexOf("\n",text.length-1));
                }
                // из этой строки извлечь имя функции и значения аргументов
                var token = "";
                if (str1.indexOf(":=") != -1){  // если это функция, то...
                    while (isalpha(str1[0])){
                        token += str1[0];
                        str1 = str1.substring(1);
                    }
                    
                    while (!isalpha(str1[0])){
                        str1 = str1.substring(1);
                    }
                }
                
                var nameOfVar = token;
                token = "";
                
                while (isalpha(str1[0])){
                    token += str1[0];
                    str1 = str1.substring(1);
                }
                funcToGo = token;
                str1 = str1.substring(1);
                token = "";
                while (isalnum(str1[0])){
                    token += str1[0];
                    str1 = str1.substring(1);
                }
                if(!isNaN(token)){
                    valToGo = Number(token);
                }
                else {
                    var allRight = false;
                    // ищем в variables
                    for (var vars in variables){
                        if (vars["name"] == token){
                            valToGo = vars["value"];
                            allRight = true;
                        }
                    }
                    
                    if (!allRight){  // не нашли...
                        try{
                            throw "dsf";
                        }
                        catch(e){
                            alert("Ошибка. Невозможно выполнение программы");
                        }
                    }
                }
                
                // имеем funcToGo и valToGo, отправляем их в стек
                var specvar = {func: funcToGo, val: valToGo, id: 0, parent_id: -1};
                targetStack.push(specvar);
                
                // рисуем дерево
                vertexes.push({x:325, y:100, func: funcToGo, val: valToGo, id: 0, parent_id: -1, marked: 0});
                //drawLineAndText(325,50,325,100,funcToGo+"("+valToGo+")");
                
                return nameOfVar;
            }
            
            function toTab(txt) {   // позволяет сохранить знаки табуляции
                var pattern = /  /g;
                var new_pattern = txt.replace(pattern,"\t");
                return new_pattern;
            }
            
            function enterReplace(txt) {
                var pattern = /\n/g;   //\r\n|\r| не понадобилось
                var new_pattern = txt.replace(pattern,"<br>");     //    
                pattern = /\t/g;
                new_pattern = new_pattern.replace(pattern,"&nbsp;&nbsp;");
                return new_pattern;
            }
            
            function enterDelete(txt) {
                var pattern = /\n/g;   //\r\n|\r| не понадобилось
                var new_pattern = txt.replace(pattern," ");
                return new_pattern;
            }
            
            function deleteEntersAndSpaces(c){
                var cc = "";
                var stroki = c.split("\n");
                for (var i=0; i<stroki.length; ++i){
                    cc = cc.replace("&nbsp;&nbsp;","&nbsp;");
                    cc+= stroki[i].trim() + " ";
                }
                cc = cc.substr(0,cc.length-1);
                return cc;
            }
            
            function getFuncByName(c){   // или процедуру
                for(var i = 0; i<functions.length;++i){
                    var func1 = functions[i];
                    if (func1["name"] == c){
                        return functions[i];
                    }
                }
                for(var i = 0; i<procedures.length;++i){
                    var func1 = procedures[i];
                    if (func1["name"] == c){
                        return procedures[i];
                    }
                }
                return false;
            }
            
            function getVarByName(c){
                for(var i = 0; i<variables.length;++i){
                    var func1 = variables[i];
                    if (func1["name"] == c){
                        return variables[i];
                    }
                }
                return false;
            }
            
            function nachalnyePrisvaivaniya(){   // когда новую цель выполняем, делаем присваивания параметров (в частном случае одного)
                var func1 = getFuncByName(funcToGo); 
                for (var i=0; i<func1["params"].length; ++i){
                    var parname = func1["params"][i];
                    // ищем в списке переменных и присваиваем значение... какое? valToGo
                    for (var j=0; j<variables.length; ++j){
                        if (variables[j]["name"] == parname){
                            variables[j]["value"] = valToGo;
                            text+= variables[j]["name"] + ":= " + valToGo + ";\n";
                        }
                    }
                }
            }
            
            function assignIfMaybe(c){    // в выражении "с" должна находиться операция присваивания
                var tok = "";
                var num = "";
                var i = 0;
                
                while (i<c.length && !isalpha(c[i])){
                    i++;
                }
                while (i<c.length && isalpha(c[i])){
                    tok+=c[i];
                    i++;
                }
                while (i<c.length && !isdigit(c[i])){
                    i++;
                }
                while (i<c.length && isdigit(c[i])){
                    num+=c[i];
                    i++;
                }
                
                for (var j=0; j<variables.length; ++j){
                    if (variables[j]["name"] == tok){
                        variables[j]["value"] = Number(num);
                        showVariables();
                        return Number(num);
                    }
                }
            }
            
            function assignment(c){   // будет вызываться в цикле отображения
                
                var varname = "";
                var i = 0;
                
                while (i<c.length && !isalpha(c[i])){
                    i++;
                }
                while (i<c.length && isalpha(c[i])){
                    varname+=c[i];
                    i++;
                }
                
                var expr = calculate(c.substring(c.indexOf(":=")+2, c.indexOf(";")).trim());
                
                //alert(c+":"+varname+"   "+expr);
                
                if (!isNaN(Number(expr)))
                    for (var j=0; j<variables.length; ++j){
                        if (variables[j]["name"] == varname){
                            variables[j]["value"] = Number(expr);
                            showVariables();
                        }
                    }
                
                return Number(expr);
            }
                     
            function formStack(){
                var str_ = '<div id="stack">';
                var r = 1;
                
                //stack_reverse = stack.reverse();
                stack_reverse = [];
                for (var i = 0; i < stack.length; ++i){
                    stack_reverse.unshift(stack[i]);
                }
                
                while (r <= stack.length && r <= 5){
                    str_ += '<span id="stack'+r+'">'+stack_reverse[r-1]+'</span>';
                    r++;
                }
                
                while (r <= 5){
                    str_ += '<span id="stack'+r+'"> </span>';
                    r++;
                }
                
                str_ += '</div>';
                return str_;
            }
            
            function showVariables(){  // отобразить переменные в блоке переменных
                //<p>Fib = <span id="f" class="varr">0</span></p> 
                var stroka = "";
                var smena = false;
                
                for (var j=0; j<variables.length; ++j){
                    stroka += "&nbsp;&nbsp;&nbsp;&nbsp;"+variables[j]["name"]+' &nbsp;&nbsp;=&nbsp;&nbsp; <span id="var_'+variables[j]["name"]+'" class="varr">'+variables[j]["value"]+'</span>';
                    
                    smena = (variables.length / 5 >= 1) ? !smena : false;
                    stroka += smena ? "&nbsp;&nbsp;&nbsp;&nbsp;" : "<br>";
                       
                }
                // сначала стек формируем
                vararea.innerHTML = formStack();
                vararea.innerHTML += stroka;
            }
            
            function varsEqZero(){  // обнулить все переменные
                for (var j=0; j<variables.length; ++j){
                    variables[j]["value"] = 0; 
                }
            }
            
            function getValueByVarName(varname){
                for (var j=0; j<variables.length; ++j){
                    if (variables[j]["name"] == varname){
                        return variables[j]["value"];
                    }
                }
                return false;
            }
            
            function compare(c){
                var cc = c;
                
                // удаляем все пробелы
                for(var i=cc.length-1; i>=0; --i){
                    if(cc[i]==" "){
                        cc = cc.substring(0,i)+cc.substring(i+1);
                    }
                }
                
                var token = "";
                var j = 0;
                while(isalnum(cc[j])){
                    token += cc[j];
                    ++j;
                }
                
                var op1 = token;
                var comop = cc[j];
                var op2 = cc.substring(j+1);
                return comparing(op1,comop,op2);
            }
            
            function comparing(p, comop, d){
                var op1, op2;
                if (getValueByVarName(p) != false)
                    op1 = Number(getValueByVarName(p))
                else op1 = Number(p);
                if (getValueByVarName(d) != false)
                    op2 = Number(getValueByVarName(d))
                else op2 = Number(d);
                switch(comop){
                    case '=': return op1 == op2; break;
                    case '>': return op1 > op2; break;
                    case '<': return op1 < op2; break;
                }
            }
            
            function operation(op1, op2, operator){  // на выходе "op1 (operator) op2"
                var opp1 = Number(op1);
                var opp2 = Number(op2);
                switch(operator){
                    case '*-': return -opp1 * opp2; break;
                    case '*': return opp1 * opp2; break;
                    case ' div ': return Math.floor(opp1 / opp2); break;
                    case '-': return opp1 - opp2; break;
                    case '+': return opp1 + opp2; break;
                }
            }
            
            String.prototype.replaceAll = function(search, replace){
                return this.split(search).join(replace);
            }
            
            String.prototype.count = function(s1) { 
                return (this.length - this.replace(new RegExp(s1,"g"), '').length) / s1.length;
            }
            
            function canCalculateButNotNumber(c){
                var cc = c.substring(4,c.length-1);
                return !isNaN(Number(calculate(cc))) && isNaN(Number(cc));
            }
            
            function canCalculate(c){
                var cc = c.substring(4,c.length-1);
                return !isNaN(Number(calculate(cc)));
            }
            
            function calculate(c){   // вычисляет значение выражения
                return svertka(replaceVarsToVals(c));
            }
            
            function calculateOnlyInBrackets(c){
                return svertkaOnlyInBrackets(replaceVarsToVals(c));
            }
            
            function replaceVarsToVals(c){    // меняет в выражении все имена переменных на их значения
                var new_pattern = String(c);
                for (var j=0; j<variables.length; ++j){
                    var varname = variables[j]["name"];
                    var varval = variables[j]["value"];
                    if (noInFunctions(varname)){
                        var new_pattern = new_pattern.replaceAll(varname, varval);
                    }
                }
                return new_pattern;
            }
            
            function svertka(c){    // выполняем все мат. операции и получаем число
                var cc = c;
                var counter = 1;

                // особый случай: *-     если вдруг унарный минус
                while(cc.indexOf('*-',counter) != -1){
                    var ind = cc.indexOf('*-',counter);
                    if (isdigit(cc[ind-1]) && isdigit(cc[ind+2])){
                        var do1 = ind-1;
                        var posle1 = ind-1;
                        while (isdigit(cc[do1-1])){
                            do1--;
                        }
                        var do2 = ind+2;
                        var posle2 = ind+2;
                        while (isdigit(cc[posle2+1])){
                            posle2++;
                        }
                        cc = cc.substring(0,do1)+operation(cc.substring(do1,posle1+1),cc.substring(do2,posle2+1),'*-')+cc.substring(posle2+1); 
                    }
                    else
                        counter++;
                }
                // продублировать для *
                while(cc.indexOf('*',counter) != -1){
                    var ind = cc.indexOf('*',counter);
                    if (isdigit(cc[ind-1]) && isdigit(cc[ind+1])){
                        var do1 = ind-1;
                        var posle1 = ind-1;
                        while (isdigit(cc[do1-1])){
                            do1--;
                        }
                        var do2 = ind+1;
                        var posle2 = ind+1;
                        while (isdigit(cc[posle2+1])){
                            posle2++;
                        }
                        cc = cc.substring(0,do1)+operation(cc.substring(do1,posle1+1),cc.substring(do2,posle2+1),'*')+cc.substring(posle2+1); 
                    }
                    else
                        counter++;
                }
                // продублировать для div
                var counter = 1;
                while(cc.indexOf(' div ',counter) != -1){
                    var ind = cc.indexOf(' div ',counter);
                    if (isdigit(cc[ind-1]) && isdigit(cc[ind+5])){
                        var do1 = ind-1;
                        var posle1 = ind-1;
                        while (isdigit(cc[do1-1])){
                            do1--;
                        }
                        var do2 = ind+5;
                        var posle2 = ind+5;
                        while (isdigit(cc[posle2+1])){
                            posle2++;
                        }
                        cc = cc.substring(0,do1)+operation(cc.substring(do1,posle1+1),cc.substring(do2,posle2+1),' div ')+cc.substring(posle2+1); 
                    }
                    else
                        counter++;
                }
                // продублировать для -
                var counter = 1;
                while(cc.indexOf('-',counter) != -1){
                    var ind = cc.indexOf('-',counter);
                    if (isdigit(cc[ind-1]) && isdigit(cc[ind+1])){
                        var do1 = ind-1;
                        var posle1 = ind-1;
                        while (isdigit(cc[do1-1]) || cc[do1-1] == "-"){
                            do1--;
                        }
                        var do2 = ind+1;
                        var posle2 = ind+1;
                        while (isdigit(cc[posle2+1])){
                            posle2++;
                        }
                        cc = cc.substring(0,do1)+operation(cc.substring(do1,posle1+1),cc.substring(do2,posle2+1),'-')+cc.substring(posle2+1); 
                    }
                    else
                        counter++;
                }
                // продублировать для +
                var counter = 1;
                while(cc.indexOf('+',counter) != -1){
                    var ind = cc.indexOf('+',counter);
                    if (isdigit(cc[ind-1]) && isdigit(cc[ind+1])){
                        var do1 = ind-1;
                        var posle1 = ind-1;
                        while (isdigit(cc[do1-1]) || cc[do1-1] == "-"){
                            do1--;
                        }
                        var do2 = ind+1;
                        var posle2 = ind+1;
                        while (isdigit(cc[posle2+1])){
                            posle2++;
                        }
                        cc = cc.substring(0,do1)+operation(cc.substring(do1,posle1+1),cc.substring(do2,posle2+1),'+')+cc.substring(posle2+1); 
                    }
                    else
                        counter++;
                }
                return cc;
            }
            
            function svertkaOnlyInBrackets(c){
                var cc = c;
                var position = 0;
                while (cc.indexOf('(',position) != -1){
                    var ott = cc.indexOf('(',position);
                    var doo = cc.indexOf(')',position) + 1;
                    position = cc.indexOf(')',position) + 1;
                    //alert(position+" "+ott+" "+doo+"На свертку: "+cc.substring(ott,doo)+"   После свертки: "+svertka(cc.substring(ott,doo))+"  Строка до: "+cc+"  Строка после: "+cc.substring(0,ott)+svertka(cc.substring(ott,doo))+cc.substring(doo));
                    cc = cc.substring(0,ott)+svertka(cc.substring(ott,doo))+cc.substring(doo);
                }
                return cc;
            }
            
            function accurateReplace(c, arrayOfParams, val){   // end тут n не меняет на число
                var cc = c;
                var per = arrayOfParams[0];
                
                for (var i = cc.length-2; i > 0; --i){
                    if (cc[i] == per && !isalpha(cc[i-1]) && !isalpha(cc[i+1])){
                        cc = cc.substring(0,i) + val + cc.substring(i+1,cc.length);
                    }  
                }
                
                return svertka(cc);
            }
            
            function writeInConsole(c){
                console.innerHTML += (getValueByVarName(c) == false) ? c.replaceAll("'","") : getValueByVarName(c);
                console.scrollTop = 1000;
            }
            
            function getResult(c){   //   F:= 434;   =>   434
                var cc = calculate(c);
                return cc.substring(4,cc.length-1);
            }
            
            function formProgramDiv(){   // где enter-ы???????
                program.innerHTML = enterReplace(text);
                
                //program.innerHTML += '<font color="#00FF00">первое</font> слово другим цветом';
                var text_ = program.innerHTML;
                var lion = text_.lastIndexOf("<br>");
                var lion2 = text_.lastIndexOf("<br>", lion-1);
                var kusokDo = text_.substring(0,lion2+4);
                var kusokPosle = text_.substring(lion);
                var theElememt = text_.substring(lion2+4,lion);
                program.innerHTML = kusokDo + '<span id="s0">' + theElememt + '</span>' + kusokPosle;
            }
            
            function wrapModBodyInTags(){  // обернуть строки в теги
                // есть text
                var stroki_ = text.split("\n");
                var counter = 1;
                
                for(var i=0; i<stroki_.length; ++i){
                    if (stroki_[i].trim() != ""){
                        stroki_[i] = '<span id="s'+counter+'">'+stroki_[i]+'</span>';
                        counter++;
                    }
                }
                
                text = stroki_.join("\n");
                return counter;
            }
            
            function hideModBody(counter){   // скрыть все строки мод тела
                for (var j=1;j<counter;++j){
                    $('#s'+j).hide();
                }
            }
            
            function exec(c){          ///   +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                var cc = c.trim();
                if (cc[cc.length-1] == ';'){
                    cc = cc.substr(0,cc.length-1);
                }
                if (cc[cc.length-1] != ';'){
                    cc = cc+";";
                }
                if (cc.substr(0,7) == "writeln"){
                    //writeInConsole(cc.substring(8,cc.indexOf(")")));
                    //writeInConsole("<br>");
                    text+= cc;
                }
                else if (cc.substr(0,5) == "write"){  
                    //writeInConsole(cc.substring(6,cc.indexOf(")")));
                    text+= cc;
                }
                else if (cc.indexOf(":=") != -1){  // присваивание
                    checkRecCalls(calculateOnlyInBrackets(c));
                    text+= calculateOnlyInBrackets(c);
                }
                else{   // вызов процедуры    +++++++++++++++++++++++++++++++++++++++++++++
                    //text+= "выполяется "+calculateOnlyInBrackets(c);
                    //runProcedure(calculateOnlyInBrackets(c)); 
                    runProg();
                }
                //alert(text);
            }
            
            function checkEndedTargets(){
                for (var i=targetStackOk.length-1; i>=0; --i){  // пройдемся по архивному стеку, посмотрим что можно вывести - получить результат
                    var thisId = targetStackOk[i]["id"];
                    // if у пэрента больше нет детей в действующем стеке (стеке на выполнение), то мы делаем замену в строке (result) пэрента "funcToGo(valToGo)" на "resultValue"
                    var est = false;  // дети есть?
                    var qToCheckChildren = [];
                    qToCheckChildren.push(thisId);

                    /*for (var j=0; j<targetStack.length; ++j){  // ну что, есть там дети в стеке у thisId? Детей-то нет... НО ВНУКОВ ТОЖЕ НАДО ПРОВЕРЯТЬ!!!!!!
                        if (targetStack[j]["parent_id"] == thisId){
                            est = true;
                        }
                    }*/

                    while(qToCheckChildren.length > 0){
                        var thisId_ = qToCheckChildren.pop();
                        for (var j=0; j<targetStack.length; ++j){  // ну что, есть там дети в стеке у thisId? Детей-то нет... НО ВНУКОВ ТОЖЕ НАДО ПРОВЕРЯТЬ!!!!!!
                            if (targetStack[j]["parent_id"] == thisId_/*targetParentId*/){
                                est = true;
                            }
                        }
                        for (var j=0; j<targetStackOk.length; ++j){ 
                            if (targetStackOk[j]["parent_id"] == thisId_/*targetParentId*/){
                                qToCheckChildren.push(targetStackOk[j]["id"]);
                            }
                        }
                    }

                    if (!est && !isdigit(targetStackOk[i]["result"][0])){  // если детей в стеке нету и результат не число, значит пора что-то менять (см выше что именно)
                        for (var k=0; k<targetStackOk.length; ++k){
                            if (targetStackOk[k]["parent_id"] == thisId){
                                targetStackOk[i]["result"] = (targetStackOk[i]["result"]).replace(targetStackOk[k]["func"]+"("+targetStackOk[k]["val"]+")", targetStackOk[k]["result"]);
                            }
                        }

                        //alert(Number(targetStackOk[i]["result"]));
                        if (targetStackOk[i]["result"][0] != undefined && isNaN(Number(targetStackOk[i]["result"]))){
                            text += "\n\n"+targetStackOk[i]["result"];
                            targetStackOk[i]["result"] = getResult(calculate(targetStackOk[i]["result"]));
                            
                            // НОВОВВЕДЕНИЕ! Хотим присваивать переменные
                            getVarByName(targetStackOk[i]["func"])["value"] = targetStackOk[i]["result"];
                        }
                    }
                }
            }
            
            function checkRecCalls(c){  // проверяем наличие рекурсивных вызовов и добавляем их в стек целей
                var found = false;
                var ind = c.length-1;
                
                while (ind >= 0){   // ищем токены (имена функций) и затем их аргументы
                    // ищем токены
                    var tok = "";
                    while(ind >= 0 && !isalpha(c[ind])){
                        ind--;
                    }
                    var firstIn = ind;
                    while(ind >= 0 && isalpha(c[ind])){
                        tok = c[ind] + tok;
                        ind--;
                    }      
                    if (tok != "" && c[firstIn+1] == "("){  // если мы получили токен, ищем его аргументы
                        if (!found){  // если рек вызов найден впервые, то надо этого родителя записать в архивный стек. Вот только с result облом, не вычислено же. И записываем в полном виде...
                            targetStackOk.push({func: funcToGo, val: valToGo, id: targetId, parent_id: targetParentId, result: c});  // правда не то что мы хотели, но всё ещё впереди
                        }
                        found = true;
                        var args_ = c.substring(firstIn+2,c.indexOf(')',firstIn+2)).replaceAll(" ","").split(",");  // массив аргументов
                        curId++;
                        targetStack.push({func: tok, val: args_, id: curId, parent_id: targetId});
                    }
                }
                
                if (!found){  // если рек вызовов не найдено    
                    var resultValue = assignIfMaybe(calculate(c));     // ВОТ СЮДА ДОБАВИЛ calculate
                    
                    // НОВОВВЕДЕНИЕ! Хотим присваивать переменные
                    getVarByName(funcToGo)["value"] = resultValue;
                    
                    targetStackOk.push({func: funcToGo, val: valToGo, id: targetId, parent_id: targetParentId, result: resultValue});
                    
                    //checkEndedTargets(); 
                }  
                        
            }
            
            function runProcedure(c){    // НЕ ПОНАДОБИЛОСЬ!!!
                // извлекаем из с имя процедуры и параметр
                var c_ = c.trim();
                name_p = c_.substring(0,c_.indexOf("("));
                val_p = c_.substring(c_.indexOf("(")+1,c_.indexOf(")"));
                
                //curId++;
                
                // имеем funcToGo и valToGo, отправляем их в стек  --- че это вообще
                //var specvar = {func: name_p, val: val_p, id: "???", parent_id: "???"};
                //targetStack.push(specvar);
                
                // рисуем дерево   (РАНЬШЕ!!!)
                //newBranchInTree(name_p, val_p, curId, parent_id);
                
                
                runProg();  // выведем кусок мод тела
                //text+="\n\n";
            }
            
            function runProg(){  // берем цель из стека целей и формируем соотв мод тело
                var curTarget = targetStack.pop();
                funcToGo = curTarget["func"];
                valToGo = curTarget["val"];
                targetId = curTarget["id"];
                targetParentId = curTarget["parent_id"];
                
                var func1 = getFuncByName(funcToGo); 
                if (targetId > 0 && procedures.length == 0)
                    newBranchInTree(funcToGo, valToGo, targetId, targetParentId);
                text += "\n";
                nachalnyePrisvaivaniya();
                
                var examplar = func1["ftext"];
                //alert(examplar);
                var examplarString = accurateReplace(deleteEntersAndSpaces(examplar), func1["params"], valToGo);  // новинка
                //alert(examplarString);
                
                if (examplarString.substr(0,3) != "if "){   // если начинаем не с if, то давайте выполним, что хотите. НО НЕ БОЛЕЕ ОДНОЙ ОПЕРАЦИИ!!! можно и более, если while сделать
                    var str_ = examplarString.substring(0,examplar.indexOf("\n"));
                    examplarString = examplarString.substring(examplar.indexOf("\n")+1);
                    exec(str_);
                    //alert(str_);
                    text+= "\n";
                }
                
                if (examplarString.substr(0,3) == "if "){   // идем по пути if
                    // НАДО: из examplarString взять условие, взять then и проверить есть ли else
                    var condition = examplarString.substring(3,examplarString.indexOf(" then"));
                    examplarString = examplarString.substring(examplarString.indexOf(" then")+6);
                    
                    var totKusok;   // то, что будет выполняться
                    
                    if (compare(condition)){   // если сравнение пройдено успешно
                        //////////////////////////////         +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                        /// не факт что это else есть. Опять же надо учесть случай begin и end после then и else
                        // добавляем то что между then и else
                        totKusok = (examplarString.indexOf(" else ") != -1) ? examplarString.substring(0,examplarString.indexOf(" else ")) : examplarString;
                           // тут вроде всё
                    }
                    else{  // иначе добавляем то что после else
                        totKusok = (examplarString.indexOf(" else ") != -1) ? examplarString.substring(examplarString.indexOf(" else ")+5) : "";
                        
                        // тут вроде всё
                    }

                    if (totKusok.trim() != ""){
                        // при необходимости удалить begin и end (считаем что они встретились максимум 1 раз)
                        if (totKusok.indexOf("begin") != -1)
                            totKusok = totKusok.substring(0, totKusok.indexOf("begin"))+totKusok.substring(totKusok.indexOf("begin")+6);
                        if (totKusok.indexOf("end") != -1)
                            totKusok = totKusok.substring(0, totKusok.indexOf("end"))+totKusok.substring(totKusok.indexOf("end")+4);
                        //alert(totKusok);
                        //totKusok = calculateOnlyInBrackets(totKusok);

                        // РАЗБИТЬ totKusok на массив, деленный по ;
                        totKusokMass = totKusok.split(";");
                        // УДАЛИТЬ из этого массива пустые строки (надо однако)
                        for (var p=0;p<totKusokMass.length;++p)
                            totKusokMass[p] = totKusokMass[p].trim();
                        totKusokMass = totKusokMass.filter(String);
                        
                        /*var dlavyv = "";
                        for (var p=0;p<totKusokMass.length;++p)
                            dlavyv += totKusokMass[p]+"+++";
                        alert(dlavyv);*/
                        
                        // если это процедура, то для нее нужна специальная обработка
                        if (noInFunctions(funcToGo)){
                            var sons = [];
                           
                            for(var t=0; t<totKusokMass.length; ++t){
                                totKusok = totKusokMass[t].trim();
                                if (totKusok[totKusok.length-1] != ';'){
                                    totKusok+= ';';
                                }
                                
                                if (totKusok.indexOf(":=") == -1 && totKusok.indexOf("write") == -1){
                                    var token = totKusok.substring(0,totKusok.indexOf("("));
                                    var token2 = totKusok.substring(totKusok.indexOf("(")+1,totKusok.indexOf(")"));
                                    
                                    ++curId;
                                    newBranchInTree(token, Number(token2), curId, targetId);
                                    
                                    var specvar = {func: token, val: Number(token2), id: curId, parent_id: targetId};
                                    sons.push(specvar);
                                }
                            }
                            
                            // в обратном порядке запихиваем в стек
                            for (var j = sons.length-1; j >= 0; --j){
                                targetStack.push(sons[j]);
                            }
                        }
                        
                        
                        
                        for(var t=0; t<totKusokMass.length; ++t){
                            totKusok = totKusokMass[t].trim();
                            if (totKusok[totKusok.length-1] != ';'){
                                totKusok+= ';';
                            }
                            
                            exec(totKusok);
                            
                            //text+= totKusok;
                            if (t != totKusokMass.length - 1)
                                text+= "\n";              
                        }
                        
                        checkEndedTargets(); 
                    }
                }
                
                
            }
            
            but.onclick = function() {                
                pausetime = Number(document.getElementById("pausetime").value);   // взяли кол-во секунд на паузу
                console.innerHTML = "";
                //mod_body.textContent = $("#program").val();
                //$("#program").attr("readonly", true);     
                text = toTab(textarea./*innerHTML*/value)+"\n";
                if (textHasBadWords(text)){
                    alert("Ошибка анализа. Невозможно отобразить программу.")
                    return;
                }
                //alert(text);
                
                deleteDuplicateEnter();  // удаляем дублирующиеся энтеры
                // сделать предпоследнюю строку с желтым фоном
                formProgramDiv();
                $(textarea).hide();
                $(program).show();
                
                
                // ВСТУПЛЕНИЕ ОКОНЧЕНО
                
                // ОЧИСТКА
                stack = [];
                targetStack = [];
                targetStackOk = []; 
                variables = [];          // очищаем
                functions = [];          
                procedure = [];
                vertexes = [];
                context.clearRect(0, 0, canvas.width, canvas.height);
                curId = 0;
                stack = [];
                
                // АНАЛИЗ
                analyzeVar();            // распознаем глобальную переменную, если есть, но максимум одну
                analyzeForward();        // если есть косвенная рекурсия, то нам нужно удалить строку с "forward"
                var varToAssign = analyzeTarget(); // анализ первой цели. Обязательно это должна быть одно строка между begin и end в конце
                analyzeSubprogs();       // формируются массивы функций и переменных 
                maxKolCalls = defineMaxKolCalls();
                
                // ЦИКЛ АНАЛИЗА
                while (targetStack.length != 0){
                    runProg();  // выведем кусок мод тела
                    text+="\n\n";
                }   
                // всё, теперь в text у нас мод. тело
                
                deleteTriplicateEnter();
                
                // обнуляем все переменные
                varsEqZero();
                showVariables();
                              
                // работаем с мод телом
                var kol_vo = wrapModBodyInTags();
                mod_body.innerHTML = enterReplace(text);
                hideModBody(kol_vo);
                
                
                // СЕЙЧАС ПОЙДЕТ ГЛАВНЫЙ МЕГАЦИКЛ ОТОБРАЖЕНИЯ
                document.getElementById('s0').style.background="#fe7";
                
                var ii = 1;   // идем по мод телу
                //var jj = 0;   // идем по дереву
                
                var fathers = [];
                fathers.push(0);
                
                //////////////////////////////////////////////////////////
                var h = setInterval(function() {
                    if (ii > 1)
                        document.getElementById('s'+(ii-1)).style.background="none";
                    
                    var our_str = document.getElementById('s'+ii).innerHTML;
                    
                    var resultVal = assignment(our_str);  // понадобится для стека и в самом конце
                    
                    // стек
                    if (!noInFunctions(our_str[0]) && canCalculate(our_str)){
                        if (document.getElementById("s"+ii).style.visibility == "visible"){
                            stack.push(resultVal);
                        }
                        else{
                            stack.pop(); stack.pop();
                            stack.push(resultVal);
                        }
                        showVariables();
                    }
                    
                    // но появиться должна вся подпрограмма, а не одна строка
                    var ii_ = ii;
                    
                    do{
                        if ($('#s'+ii_).css("visibility", "visible"))
                            $('#s'+ii_).fadeIn(inttime);
                        
                        ii_++;
                    } while (ii_<kol_vo && /*document.getElementById('s'+ii_).innerHTML.substr(0,3) != "n:="*/ document.getElementById('s'+ii_).innerHTML.substr(0,3).match(/[a-z]:=/g) == null && !canCalculateButNotNumber(document.getElementById('s'+ii_).innerHTML));
                    
                    mod_body.scrollTop = +document.getElementById('s'+(ii_-1)).offsetTop - mod_body.clientHeight + 55;
                    document.getElementById('s'+ii).style.background="#fe7";
                    
                    var ccc = document.getElementById('s'+ii).innerHTML.trim();
                    //ccc = ccc.substring(0,ccc.length-1);
                    if (ccc.substr(0,7) == "writeln"){
                        //alert(ccc);
                        writeInConsole(ccc.substring(8,ccc.indexOf(")")));
                        writeInConsole("<br>");
                    }
                    else if (ccc.substr(0,5) == "write"){  
                        writeInConsole(ccc.substring(6,ccc.indexOf(")")));
                    }
                        
                    
                    
                    /*var dlavyv = "";
                        for (var p=0;p<vertexes.length;++p)
                            dlavyv += vertexes[p]["parent_id"]+"+++";
                        alert(dlavyv);*/

                    // теперь с деревом
                    if (/*our_str.substr(0,3) == "n:="*/ our_str.substr(0,3).match(/[a-z]:=/g) != null){
                        if (procedures.length == 0){
                            // сделать jj номером выводимой вершины
                            var jj = 0;

                            if (vertexes[0]["marked"] == 1){
                                jj = findGreaterUnmarkedSon(fathers[0]);

                                while (jj == undefined && fathers.length > 0){
                                    fathers.shift();
                                    jj = findGreaterUnmarkedSon(fathers[0]);
                                }

                                fathers.unshift(jj);
                            }

                            vertexes[jj]["marked"] = 1;

                            var parent_id = vertexes[jj]["parent_id"];

                            var text3 = vertexes[jj]["func"]+"("+vertexes[jj]["val"]+")";

                            if (!jj){  // особый случай
                                drawLineAndText(325,50,325,100,text3);
                            } else{
                                drawLineAndText(vertexes[parent_id]["x"], vertexes[parent_id]["y"], vertexes[jj]["x"], vertexes[jj]["y"],text3);
                            }

                            //++jj;
                        }
                        else {   // а теперь случай с процедурами
                            // сделать jj номером выводимой вершины
                            var jj = 0;

                            if (vertexes[0]["marked"] == 1){
                                jj = findLeastUnmarkedSon(fathers[0]);

                                while (jj == undefined && fathers.length > 0){
                                    fathers.shift();
                                    jj = findLeastUnmarkedSon(fathers[0]);
                                }

                                fathers.unshift(jj);
                                //alert(fathers[0]);
                            }
                            
                            vertexes[jj]["marked"] = 1;

                            var parent_id = vertexes[jj]["parent_id"];

                            var text3 = vertexes[jj]["func"]+"("+vertexes[jj]["val"]+")";

                            if (!jj){  // особый случай
                                drawLineAndText(325,50,325,100,text3);
                            } else{
                                drawLineAndText(vertexes[parent_id]["x"], vertexes[parent_id]["y"], vertexes[jj]["x"], vertexes[jj]["y"],text3);
                            }

                            //++jj;
                        }
                    }
                    
                    
                    ii++;
                    
                    if (ii == kol_vo){
                        clearInterval(h);
                        setTimeout(function(){
                            document.getElementById('s'+(kol_vo-1)).style.background="none";
                            // обнуляем все переменные
                            varsEqZero();
                            stack = [];
                
                            assignment(varToAssign+":= "+resultVal+";");
                            showVariables();
                            
                            setTimeout(function(){
                                //document.getElementById('s0').style.background="none";
                                $(textarea).show();
                                $(program).hide();
                            }, pausetime*1000);
                        }, pausetime*1000);
                    }
                }, pausetime*1000);
                ///////////////////////////////////////////////////////////////////////////////
                
                
                /*var h = setInterval(function() {
                    runProg();  // выведем кусок мод тела
                    text+="\n\n";
                    
                    showVariables();
                    mod_body.innerHTML = enterReplace(text);
                    mod_body.scrollTop = mod_body.scrollHeight;   // скроллим вниз

                    if (targetStack.length == 0)
                        clearInterval(h);
                }, 1000);*/
                
                
                //mod_body.innerHTML = textarea.innerHTML;
                //mod_body.textContent = enterReplace(text);
	
 
                /*for(var i = 0; i<functions.length;++i){
                    func1 = functions[i];
                    alert(func1["name"]+"---"+func1["params"]+"---"+func1["ftext"]);
                }*/

                
                
                //$("#program").removeAttr("readonly");   
                
                      /* var h = setInterval(function() {
                    ++kol;
                    //var s1 = document.getElementById('s1');
                    switch(kol){
                        case 1: s1.style.background="#fe7";
                            break;
                        case 2: s2.style.background="#fe7";
                                $('#s2').fadeIn(inttime);
                                $('#s3').fadeIn(inttime);
                                $('#n').text(3);
                                context.beginPath();
                                context.moveTo(325,50);
                                context.lineTo(325,100);
                                context.stroke();
                                context.beginPath();
                                context.arc(325,100,10,0,2*Math.PI, true);
                                context.fill();
                                context.fillText("Fib(3)",355,100);
                            break;
                        case 3: s2.style.background="none";
                                s3.style.background="#fe7";
                            break;
                        case 4: s4.style.background="#fe7";
                                $('#s4').fadeIn(inttime);
                                $('#s5').fadeIn(inttime);
                                $('#n').text(2);
                                context.beginPath();
                                context.moveTo(325,100);
                                context.lineTo(225,200);
                                context.stroke();
                                context.beginPath();
                                context.arc(225,200,10,0,2*Math.PI, true);
                                context.fill();
                                context.fillText("Fib(2)",255,200);
                            break;
                        case 5: s4.style.background="none";
                                s5.style.background="#fe7";
                            break;
                        case 6: s6.style.background="#fe7";
                                $('#s6').fadeIn(inttime);
                                $('#s7').fadeIn(inttime);
                                $('#n').text(1);
                                context.beginPath();
                                context.moveTo(225,200);
                                context.lineTo(125,300);
                                context.stroke();
                                context.beginPath();
                                context.arc(125,300,10,0,2*Math.PI, true);
                                context.fill();
                                context.fillText("Fib(1)",155,300);
                            break;
                        case 7: s6.style.background="none";
                                s7.style.background="#fe7";
                                $('#f').text(1);
                            break;
                        case 8: $('#f').text(0);
                                $('#stack1').text(1);
                                $('#n').text(0);
                                s7.style.background="none";
                                s8.style.background="#fe7";
                                $('#s8').fadeIn(inttime);
                                $('#s9').fadeIn(inttime);
                                context.beginPath();
                                context.moveTo(225,200);
                                context.lineTo(325,300);
                                context.stroke();
                                context.beginPath();
                                context.arc(325,300,10,0,2*Math.PI, true);
                                context.fill();
                                context.fillText("Fib(0)",355,300);
                            break;
                        case 9: s8.style.background="none";
                                s9.style.background="#fe7";
                                $('#f').text(1);
                            break;
                        case 10: s9.style.background="none";
                                 s10.style.background="#fe7";
                                 $('#s10').fadeIn(inttime);
                                 $('#stack1').text(" ");
                                 $('#f').text(2);
                            break;
                        case 11: s5.style.background="none";
                                 s10.style.background="none";
                                 s11.style.background="#fe7";
                                 $('#s11').fadeIn(inttime);
                                 $('#s12').fadeIn(inttime);
                                 $('#n').text(1);
                                 $('#f').text(0);
                                 $('#stack1').text(2);
                                 context.beginPath();
                                 context.moveTo(325,100);
                                 context.lineTo(425,200);
                                 context.stroke();
                                 context.beginPath();
                                 context.arc(425,200,10,0,2*Math.PI, true);
                                 context.fill();
                                 context.fillText("Fib(1)",455,200);
                            break;
                        case 12: s11.style.background="none";
                                 s12.style.background="#fe7";
                                 $('#f').text(1);
                            break;
                        case 13: s12.style.background="none";
                                 s13.style.background="#fe7";
                                 $('#s13').fadeIn(inttime);
                                 $('#f').text(3);
                                 $('#stack1').text(" ");
                            break;
                        case 14: s13.style.background="none";
                                 s3.style.background="none";
                                 $('#aa').text(3);
                                 $('#n').text(0);
                                 $('#f').text(0);
                            break;
                        case 15: s1.style.background="none";
                            break;
                    }
                      
                    if (kol==15) clearInterval(h);
                }, pausetime*1000);*/
            };
        </script>
    </body>
</html>