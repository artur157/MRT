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
            printSidebarIllustration(3);    // вывели сайдбар для иллюстрации
        ?>
        
        <div id="page_ill">
            <div id="program">
<pre>var a: integer;
function F(n: integer): integer;
begin
  if n>1 then
    F:= F(n-1)+F(n-2)
  else
    F:= 1;
end;
begin
<span id="s1">  a:= F(3);</span>  
end. </pre>
            </div>
            
            <div id="variables">
                <p>&nbsp;&nbsp;&nbsp;&nbsp;a &nbsp;&nbsp;= &nbsp;&nbsp;<span id="aa" class="varr">0</span></p> 
                <p>&nbsp;&nbsp;&nbsp;&nbsp;n &nbsp;&nbsp;= &nbsp;&nbsp;<span id="n" class="varr">0</span></p> 
                <p>&nbsp;&nbsp;&nbsp;&nbsp;F &nbsp;&nbsp;= &nbsp;&nbsp;<span id="f" class="varr">0</span></p> 
                <div id="stack"> 
                    <span id="stack1"> </span>
                    <span id="stack2"> </span>
                    <span id="stack3"> </span>
                    <span id="stack4"> </span>
                    <span id="stack5"> </span>
                </div>  
            </div>
            
            <div id="mod_body">
<pre>
<span id="s2">n:= 3;</span>     
<span id="s3">F:= F(2)+F(1);</span>  
      
<span id="s4">n:= 2;</span>    
<span id="s5">F:= F(1)+F(0);</span>  
     
<span id="s6">n:= 1;</span>   
<span id="s7">F:= 1;</span>   
    
<span id="s8">n:= 0;</span>   
<span id="s9">F:= 1;</span> 

<span id="s10">F:= 1+1;</span>  
    
<span id="s11">n:= 1;</span>   
<span id="s12">F:= 1;</span> 
    
<span id="s13">F:= 2+1;</span>     
</pre>
            </div>
            
            <div id="scheme">
                <canvas id="sch" width="640" height="490"></canvas>  
            </div>
            
            <div id="console">
                  
            </div>
        </div>
        
        <script src="scripts/jquery-3.1.1.min.js"></script>
        <script>
            var pausetime = Number(document.getElementById("pausetime").value);
            var program = document.getElementById('program'),
                s1 = document.getElementById('s1')
                but = document.getElementById('but');
            var mod_body = document.getElementById("mod_body");
            
            var kol = 0;
            const inttime = 200;
            var canvas = document.getElementById("sch");
            var context = canvas.getContext("2d");
            
            context.fillStyle = "#9F5F9F";
            context.lineWidth=5;
            context.strokeStyle="#9F5F9F";
            context.font = "16pt sans-serif";
  
            for (var j=2;j<14;++j){
                $('#s'+j).hide();
            }
            
            but.onclick = function() {
                pausetime = Number(document.getElementById("pausetime").value);
                var h = setInterval(function() {
                    ++kol;
                    var s1 = document.getElementById('s1');
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
                            context.fillStyle = "#9F5F9F";
                                context.arc(325,100,10,0,2*Math.PI, true);
                                context.fill();
                            context.fillStyle = "#515";
                                context.fillText("F(3)",335,80);
                            break;
                        case 3: s2.style.background="none";
                                s3.style.background="#fe7";
                            break;
                        case 4: s3.style.background="none";
                                s4.style.background="#fe7";
                                $('#s4').fadeIn(inttime);
                                $('#s5').fadeIn(inttime);
                                $('#n').text(2);
                                context.beginPath();
                                context.moveTo(325,100);
                                context.lineTo(165,200);
                                context.stroke();
                                context.beginPath();
                            context.fillStyle = "#9F5F9F";
                                context.arc(165,200,10,0,2*Math.PI, true);
                                context.fill();
                            context.fillStyle = "#515";
                                context.fillText("F(2)",175,180);
                            break;
                        case 5: s4.style.background="none";
                                s5.style.background="#fe7";
                            break;
                        case 6: s5.style.background="none";
                                s6.style.background="#fe7";
                                $('#s6').fadeIn(inttime);
                                $('#s7').fadeIn(inttime);
                                $('#n').text(1);
                                context.beginPath();
                                context.moveTo(165,200);
                                context.lineTo(105,300);
                                context.stroke();
                                context.beginPath();
                            context.fillStyle = "#9F5F9F";
                                context.arc(105,300,10,0,2*Math.PI, true);
                                context.fill();
                            context.fillStyle = "#515";
                                context.fillText("F(1)",115,280);
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
                                context.moveTo(165,200);
                                context.lineTo(225,300);
                                context.stroke();
                                context.beginPath();
                            context.fillStyle = "#9F5F9F";
                                context.arc(225,300,10,0,2*Math.PI, true);
                                context.fill();
                            context.fillStyle = "#515";
                                context.fillText("F(0)",235,280);
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
                        case 11: s10.style.background="none";
                                 s11.style.background="#fe7";
                                 $('#s11').fadeIn(inttime);
                                 $('#s12').fadeIn(inttime);
                                 $('#n').text(1);
                                 $('#f').text(0);
                                 $('#stack1').text(2);
                                 context.beginPath();
                                 context.moveTo(325,100);
                                 context.lineTo(485,200);
                                 context.stroke();
                                 context.beginPath();
                            context.fillStyle = "#9F5F9F";
                                 context.arc(485,200,10,0,2*Math.PI, true);
                                 context.fill();
                            context.fillStyle = "#515";
                                 context.fillText("F(1)",495,180);
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
                                 $('#aa').text(3);
                                 $('#n').text(0);
                                 $('#f').text(0);
                            break;
                        case 15: s1.style.background="none";
                            break;
                    }
                      
                    if (kol==15) clearInterval(h);
                }, pausetime*1000);
            };
        </script>
    </body>
</html>