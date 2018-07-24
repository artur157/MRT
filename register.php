<html>
    <head>
        <meta charset="utf-8">
        <title>Регистрация</title>
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
            <br><h1>Регистрация</h1><br><br>
            
            <form action="registration.php" method="POST" class="formcenter">
                <label for="firstName">Имя</label><br>
                <input type="text" name="firstName" size="30"><br>
                <label for="lastName">Фамилия</label><br>
                <input type="text" name="lastName" size="30"><br>
                <label for="login">Логин</label><br>
                <input type="text" name="login" size="30"><br>
                <label for="email">E-mail</label><br>
                <input type="text" name="email" size="30"><br>
                <label for="password">Пароль</label><br>
                <input type="password" name="password" size="30"><br>
                <label for="password2">Повторите пароль</label><br>
                <input type="password" name="password2" size="30"><br><br>
				<input type="submit" name="submit" value="Зарегистрироваться" id="submit"><br><br>
            </form>
           </div>
        </div>
        
    </body>
</html>