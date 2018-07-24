<html>
    <head>
        <meta charset="utf-8">
        <title>Тест</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <?php
            require_once "help_functions.php";
            printNavigation();  // вывели панель навигации
            printSidebarTest(0);   // вывели сайдбар для теста
        ?>
        
        <div id="pagetest">
           <div class="center">
            <br><h1>Авторизация</h1><br><br>
            
            <form action="test1.php" method="POST" class="formcenter">
                <label for="login">Логин</label><br>
                <input type="text" name="login" size="30"><br>
                <label for="login">Пароль</label><br>
                <input type="password" name="password" size="30"><br><br>
				<input type="submit" name="submit" value="Войти" id="submit"><br><br>
                <a href="register.php">Регистрация</a><br>
                <a href="forgot.php">Забыли пароль?</a><br>
            </form>
            
           </div>
        </div>
        
    </body>
</html>