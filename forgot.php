<html>
    <head>
        <meta charset="utf-8">
        <title>Забыли пароль?</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <?php
            require_once "help_functions.php";
            printNavigation();        // вывели панель навигации
            printSidebarTest(0);   // вывели сайдбар для теста
        ?>
        
        <div id="pagetest">
           <div class="center">
            <br><h1>Новый пароль</h1><br><br>
            
            <form action="forgot_done.php" method="POST" class="formcenter">
                <label for="login" >Логин</label><br>
                <input type="text" name="login" size="30"><br>
                <label for="email" >E-mail</label><br>
                <input type="text" name="email" size="30"><br><br>
				<input type="submit" name="submit" value="Получить новый пароль" id="submit"><br><br>
            </form>
           </div>
        </div>
        
    </body>
</html>