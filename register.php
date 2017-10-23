<html>
    <head>
        <meta charset="utf-8">
        <title>Теория: понятие рекурсии</title>
        <link rel="stylesheet" href="css/myStyle.css" type="text/css">
    </head>
    <body>
        <div id="navigation">
            <ul>
                <li><a href="theory1.html">Теория</a></li>
                <li><a href="illustration.html">Иллюстрация</a></li>
                <li><a href="test.php">Тест</a></li>
            </ul>
        </div>
        
        <div class="sidebar">
            
        </div>
        
        <div id="page">
           <div id="center">
            <br><h1>Регистрация</h1><br><br>
            
            <form action="registration.php" method="POST">
                <label for="firstName" class="sleva">Имя&nbsp;&nbsp;</label>
                <input type="text" name="firstName" size="30"><br>
                <label for="lastName" class="sleva">Фамилия&nbsp;&nbsp;</label>
                <input type="text" name="lastName" size="30"><br>
                <label for="login" class="sleva">Логин&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="login" size="30"><br>
                <label for="email" class="sleva">E-mail&nbsp;&nbsp;</label>
                <input type="text" name="email" size="30"><br>
                <label for="password" class="sleva">Пароль&nbsp;&nbsp;</label>
                <input type="text" name="password" size="30"><br>
                <label for="password2" class="sleva">Повторите пароль&nbsp;&nbsp;</label>
                <input type="text" name="password2" size="30"><br><br>
				<input type="submit" name="submit" value="Зарегистрироваться" id="submit"><br><br>
            </form>
           </div>
        </div>
        
    </body>
</html>