-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 16 2018 г., 11:35
-- Версия сервера: 5.7.14
-- Версия PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tests`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE `answers` (
  `ID_A` int(11) NOT NULL,
  `ID_Q` int(11) DEFAULT NULL,
  `Str_A` varchar(200) DEFAULT NULL,
  `Right_A` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`ID_A`, `ID_Q`, `Str_A`, `Right_A`) VALUES
(1, 1, 'объект, который частично определяется через другие известные объекты', 0),
(2, 1, 'объект, который частично определяется через самого себя', 1),
(3, 1, 'объект, который частично определяется через другие неизвестные объекты', 0),
(4, 2, 'требуется наличие некоторого условия, по достижении которого дальнейшее обращение не происходит', 1),
(5, 2, 'требуется наличие оператора цикла, по окончании которого дальнейшее обращение не происходит', 0),
(6, 3, '3,4,if n>1 then,Fib:=Fib(n-1)+Fib(n-2)', 1),
(7, 4, 'да', 1),
(8, 4, 'нет', 0),
(9, 5, 'прямой', 0),
(10, 5, 'косвенной', 1),
(11, 5, 'явной', 0),
(12, 5, 'опережающей', 0),
(13, 6, 'мощностью', 0),
(14, 6, 'количеством рекурсии', 0),
(15, 6, 'размерностью', 0),
(16, 6, 'глубиной', 1),
(17, 7, '1, 3, 5, 7, 9, 11, 13', 0),
(18, 7, '1, 1, 4, 9, 16, 25, 36', 0),
(19, 7, '1, 1, 2, 3, 5, 8, 13', 1),
(20, 7, '1, 2, 4, 8, 16, 32, 64', 0),
(21, 8, 'x<sub>n</sub> = x<sub>n-1</sub> - x<sub>n-2</sub>', 0),
(22, 8, 'x<sub>n</sub> = n * x<sub>n-1</sub>', 0),
(23, 8, 'x<sub>n</sub> = x<sub>n-1</sub> + x<sub>n-2</sub>', 1),
(24, 8, 'x<sub>n</sub> = x<sub>n-1</sub> + 1', 0),
(25, 9, '3', 0),
(26, 9, '4', 1),
(27, 9, '9', 0),
(28, 9, '10', 0),
(29, 10, 'способ сведения задачи к более простой', 0),
(30, 10, 'аргументы, для которых значения функции определены', 1),
(31, 10, 'частичное определение объекта через себя', 0),
(32, 10, 'основное самоподобие рекурсивной задачи', 0),
(33, 11, 'опережающую', 0),
(34, 11, 'хвостовую', 1),
(35, 11, 'косвенную', 0),
(36, 11, 'итерационную', 0),
(37, 12, '1', 1),
(38, 13, '3', 1),
(39, 14, '10', 1),
(40, 15, '10,Fib:=x2;', 1),
(41, 16, '1', 1),
(42, 17, '3,6,if n>1 then begin,Hanoi(n-1,c,b,a);', 1),
(43, 18, '49', 1),
(44, 19, '-32', 1),
(45, 20, '73', 1),
(46, 21, '70', 1),
(47, 22, '4,Factorial:=n*Factorial(n-1)', 1),
(48, 23, '4,if odd(n) then t:= x else t:= 1;', 1),
(49, 24, '3,5,if n>1 then begin,writeln(a, \'->\', b);', 1),
(50, 25, '15', 1),
(51, 26, '10', 1),
(52, 27, '7', 1),
(53, 28, '9', 1),
(54, 29, '-1', 1),
(55, 30, '110', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `ID_Q` int(11) NOT NULL,
  `Str_Q` varchar(1000) DEFAULT NULL,
  `Level_Q` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`ID_Q`, `Str_Q`, `Level_Q`) VALUES
(1, 'Что такое рекурсия?', 1),
(2, 'Как избавиться от бесконечного обращения рекурсивной подпрограммы к самой себе?', 1),
(3, '1) function Fib(n: integer): integer;<br />2) begin<br />3) &nbsp;&nbsp;if n>0 then<br />4) &nbsp;&nbsp;&nbsp;&nbsp;Fib:= Fib(n)+Fib(n-1)<br />5) &nbsp;&nbsp;else Fib:= 1;<br />6) end;<br /><br />Укажите сначала номера строк с ошибкой, а затем строки-замены через запятую (можно без пробелов, всего 2 ошибки).', 3),
(4, 'Возможно ли задачи, явно не содержащие в себе рекурсию, свести к рекурсивным?', 1),
(5, 'Вызов подпрограммы из неё же самой через другие функции называется ... рекурсией.', 1),
(6, 'Как называется максимальное количество незаконченных рекурсивных вызовов при выполнении одного рекурсивного вызова?', 1),
(7, 'Последовательностью Фибоначчи является', 1),
(8, 'Рекуррентное соотношение для n-ого числа Фибоначчи', 1),
(9, 'Сколько операций умножения требует вычисление x<sup>10</sup> при использовании "индийского алгоритма" возведения в степень?', 1),
(10, 'Базой рекурсии называется', 1),
(11, 'Какую рекурсию можно заменить на итерацию путём формальной и гарантированно корректной перестройки кода функции?', 1),
(12, 'function F(n: integer): integer;<br />begin<br />&nbsp;&nbspif n>1 then<br />&nbsp;&nbsp&nbsp;&nbspF:= F(n-1)*F(n-2)<br />&nbsp;&nbspelse F:= 1;<br />end;<br /><br />Вычислите, чему равно F(7).', 2),
(13, 'Дано неправильное решение:<br /><br />function Factorial(n: integer): integer;<br />begin<br />&nbsp;&nbspif n>1 then<br />&nbsp;&nbsp&nbsp;&nbspFactorial:= n+Factorial(n-1)<br />&nbsp;&nbspelse Factorial:= 1;<br />end;<br /><br />Найдите натуральное число, при котором программа выдаёт верный результат, причём глубина рекурсии отлична от 1.', 3),
(14, 'procedure P(n: integer);<br />begin<br />write(\'*\');<br />&nbsp;&nbspif n>0 then begin<br />&nbsp;&nbsp&nbsp;&nbspwrite(\'*\');<br />&nbsp;&nbsp&nbsp;&nbspP(n-8);<br />&nbsp;&nbsp&nbsp;&nbspP(n div 2);<br />&nbsp;&nbspend<br />end;<br /><br />Сколько символов * будет на экране при n=6?', 2),
(15, '1) &nbsp;function Fib(x1, x2, n: integer): integer;<br />2) &nbsp;var x3: integer;<br />3) &nbsp;begin<br />4) &nbsp;&nbsp;&nbspif n>1 then begin<br />5) &nbsp;&nbsp;&nbsp&nbsp;&nbspx3:= x1+x2;<br />6) &nbsp;&nbsp&nbsp;&nbsp;&nbspx1:= x2;<br />7) &nbsp;&nbsp&nbsp;&nbsp;&nbspx2:= x3;<br />8) &nbsp;&nbsp;&nbsp&nbsp;&nbspFib:= Fib(x1, x2, n-1)<br />9) &nbsp;&nbsp;&nbspend else<br />10) &nbsp;&nbsp&nbsp;&nbsp Fib:= x1;<br />11) end;<br /><br />Укажите сначала номер строки с ошибкой, а затем строку-замену через запятую (можно без пробелов, всего 1 ошибка).', 3),
(16, 'Дано неправильное решение:<br /><br />function pow(x, n: integer): integer;<br />var t: integer;<br />begin<br />if odd(n) then t:= 1 else t:= x;<br />&nbsp;&nbspif n=1 then pow:= x<br />&nbsp;&nbspelse pow:= t*sqr(pow(x, n div 2));<br />end;<br /><br />Найдите натуральное число n, при котором программа выдаёт верный результат, если x=2.', 3),
(17, '1) procedure Hanoi(n, a, b, c: integer);<br />2) begin<br />3) &nbsp;&nbsp;if n>0 then begin<br />4) &nbsp;&nbsp;&nbsp;&nbsp;Hanoi(n-1, a, c, b);<br />5) &nbsp;&nbsp;&nbsp;&nbsp;writeln(a, \'->\', b);<br />6) &nbsp;&nbsp;&nbsp;&nbsp;Hanoi(n-1, b, c, a);<br />7) &nbsp;&nbsp;end else<br />8) &nbsp;&nbsp;&nbsp;&nbsp;writeln(a, \'->\', b);<br />9) end;<br /><br />Укажите сначала номера строк с ошибкой, а затем строки-замены через запятую (можно без пробелов, всего 2 ошибки).', 3),
(18, 'procedure P(n: integer);<br />begin<br />writeln(n);<br />&nbsp;&nbspif n<5 then begin<br />&nbsp;&nbsp&nbsp;&nbspP(n+1);<br />&nbsp;&nbsp&nbsp;&nbspP(n+3);<br />&nbsp;&nbspend<br />end;<br /><br />Найдите сумму чисел, которые будут выведены при n=1.', 2),
(19, 'function G(n: integer): integer; forward;<br />function F(n: integer): integer;<br />begin<br />&nbsp;&nbspif n=1 then F:= 1<br />&nbsp;&nbspelse F:= 8*F(n-1)-8*G(n-1)<br />end;<br />function G(n: integer): integer;<br />begin<br />&nbsp;&nbspif n=1 then G:= 1<br />&nbsp;&nbspelse G:= F(n-1)+3*G(n-1)<br />end;<br /><br />Вычислите, чему равно F(3).', 3),
(20, 'procedure P(n: integer);<br />begin<br />writeln(n);<br />&nbsp;&nbspif n<6 then begin<br />&nbsp;&nbsp&nbsp;&nbspP(n+4);<br />&nbsp;&nbsp&nbsp;&nbspP(n+5);<br />&nbsp;&nbsp&nbsp;&nbspP(n*3);<br />&nbsp;&nbspend<br />end;<br /><br />Найдите сумму чисел, которые будут выведены при n=1?', 2),
(21, 'procedure P(n: integer);<br />begin<br />writeln(n);<br />&nbsp;&nbspif n<7 then begin<br />&nbsp;&nbsp&nbsp;&nbspP(n+3);<br />&nbsp;&nbsp&nbsp;&nbspP(n+5);<br />&nbsp;&nbsp&nbsp;&nbspP(n*2);<br />&nbsp;&nbspend<br />end;<br /><br />Найдите сумму чисел, которые будут выведены при n=2?', 2),
(22, '1) &nbsp;function Factorial(n: integer): integer;<br />2) &nbsp;begin<br />3) &nbsp;&nbsp;&nbspif n>1 then<br />4) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Factorial:= n+Factorial(n-1)<br />5) &nbsp;&nbsp;&nbsp;else Factorial:= 1;<br />6) &nbsp;end;<br /><br />Укажите сначала номер строки с ошибкой, а затем строку-замену через запятую (можно без пробелов, всего 1 ошибка).', 3),
(23, '1) &nbsp;function pow(x, n: integer): integer;<br />2) &nbsp;&nbsp;&nbsp;var t: integer;<br />3) &nbsp;begin<br />4) &nbsp;&nbsp;&nbsp;if odd(n) then t:= 1 else t:= x;<br />5) &nbsp;&nbsp;&nbsp;if n=1 then pow:= x<br />6) &nbsp;&nbsp;&nbsp;&nbsp;else pow:= t*sqr(pow(x, n div 2));<br />7) &nbsp;end;<br /><br />Укажите сначала номер строки с ошибкой, а затем строку-замену через запятую (можно без пробелов, всего 1 ошибка).', 3),
(24, '1) procedure Hanoi(n, a, b, c: integer);<br />2) begin<br />3) &nbsp;&nbsp;if n>0 then begin<br />4) &nbsp;&nbsp;&nbsp;&nbsp;Hanoi(n-1, a, c, b);<br />5) &nbsp;&nbsp;&nbsp;&nbsp;writeln(b, \'->\', a);<br />6) &nbsp;&nbsp;&nbsp;&nbsp;Hanoi(n-1, c, b, a);<br />7) &nbsp;&nbsp;end else<br />8) &nbsp;&nbsp;&nbsp;&nbsp;writeln(a, \'->\', b);<br />9) end;<br /><br />Укажите сначала номера строк с ошибкой, а затем строки-замены через запятую (можно без пробелов, всего 2 ошибки).', 3),
(25, 'function G(n: integer): integer; forward;<br />function F(n: integer): integer;<br />begin<br />&nbsp;&nbspif n=1 then F:= 1<br />&nbsp;&nbspelse F:= 3*F(n-1)+G(n-1)<br />end;<br />function G(n: integer): integer;<br />begin<br />&nbsp;&nbspif n=1 then G:= 1<br />&nbsp;&nbspelse G:= 5*F(n-1)-2*G(n-1)<br />end;<br /><br />Вычислите, чему равно F(3).', 3),
(26, 'procedure P(n: integer);<br />begin<br />write(\'*\');<br />&nbsp;&nbspif n>0 then begin<br />&nbsp;&nbsp&nbsp;&nbspwrite(\'*\');<br />&nbsp;&nbsp&nbsp;&nbspP(n-5);<br />&nbsp;&nbsp&nbsp;&nbspP(n div 3);<br />&nbsp;&nbspend<br />end;<br /><br />Сколько символов * будет на экране при n=7?', 2),
(27, 'procedure P(n: integer);<br />begin<br />write(\'*\');<br />&nbsp;&nbspif n>1 then begin<br />&nbsp;&nbsp&nbsp;&nbspwrite(\'*\');<br />&nbsp;&nbsp&nbsp;&nbspP(n-2);<br />&nbsp;&nbsp&nbsp;&nbspP(n-4);<br />&nbsp;&nbspend<br />end;<br /><br />Сколько символов * будет на экране при n=5?', 2),
(28, 'function F(n: integer): integer;<br />begin<br />&nbsp;&nbspif n>1 then<br />&nbsp;&nbsp&nbsp;&nbspF:= F(n-3)+2*F(n div 2)<br />&nbsp;&nbspelse F:= n;<br />end;<br /><br />Вычислите, чему равно F(8).', 2),
(29, 'function F(n: integer): integer;<br />begin<br />&nbsp;&nbspif n>1 then<br />&nbsp;&nbsp&nbsp;&nbspF:= F(n-2)-F(n div 3)<br />&nbsp;&nbspelse F:= n;<br />end;<br /><br />Вычислите, чему равно F(9).', 2),
(30, 'procedure P(n: integer);<br />begin<br />writeln(n);<br />&nbsp;&nbspif n<8 then begin<br />&nbsp;&nbsp&nbsp;&nbspP(n+5);<br />&nbsp;&nbsp&nbsp;&nbspP(n+6);<br />&nbsp;&nbsp&nbsp;&nbspP(n*3);<br />&nbsp;&nbspend<br />end;<br /><br />Найдите сумму чисел, которые будут выведены при n=2?', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `results`
--

CREATE TABLE `results` (
  `ID` int(11) NOT NULL,
  `Result` int(11) NOT NULL,
  `ID_U` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `results`
--

INSERT INTO `results` (`ID`, `Result`, `ID_U`, `Date`) VALUES
(1, 2, 20, '2018-02-26'),
(4, 5, 20, '2018-03-04'),
(3, 4, 20, '2018-03-03'),
(2, 4, 20, '2018-03-01');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Login` varchar(20) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `Login`, `Password`, `Email`, `FirstName`, `LastName`) VALUES
(1, 'artur', 'f1oyORtHY7', 'arthur157@mail.ru', 'Артур', 'Гумеров'),
(23, 'ivan', 'xxgYrTy9Qkt4c', 'vipivankov@mail.ru', 'Иван', 'Иванов'),
(22, 'ivan123', 'xxUwp/hOefGJU', 'ivan@mail.ru', 'Иван', 'Иванов'),
(21, 'Kau', 'xxnuA4WWAsH1o', 'kau@yandex.ru', 'Сергей', 'Комаревцев'),
(20, 'artur123', 'xxwddmriJc5TI', 'arthur157@mail.ru', 'Артур', 'Гумеров');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`ID_A`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`ID_Q`);

--
-- Индексы таблицы `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`,`Login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `answers`
--
ALTER TABLE `answers`
  MODIFY `ID_A` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `ID_Q` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT для таблицы `results`
--
ALTER TABLE `results`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Пользователь
-- CREATE USER 'usual'@'%' IDENTIFIED BY 'simple_password123';

-- GRANT USAGE ON *.* TO 'usual'@'%';

-- GRANT SELECT, INSERT, UPDATE ON `tests`.* TO 'usual'@'%';

-- FLUSH PRIVILEGES;
