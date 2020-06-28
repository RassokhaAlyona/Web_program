<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Выбор по семестру </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>


	<?php
	require_once 'connection.php'; // подключаем скрипт
	 
	// подключаемся к серверу
	$link = mysqli_connect($host, $user, $password, $database) 
		or die("Ошибка " . mysqli_error($link));
	
	// кодировка
	mysqli_set_charset($link, "utf8");
	 
	// выполняем операции с базой данных
	$query ="select number_s FROM subject GROUP BY number_s";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	
	if(!isset($_POST['v_sem'])) {
		$_POST['v_sem']= "4";
	}
	?>
	
	Выбор семестра: <br>
	<form method="post">
	<select name=v_sem size=1>
	<?php
	// проверка результата
	if(mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result))
		{
		print '<option value='.$row[0].''.($_POST['v_sem']==$row[0] ? ' selected="selected"' : "").'>'.$row[0].'</option>';
		}
	} else {echo "Данные не найдены =(";}
	 
	// закрываем подключение
	mysqli_close($link);
	?>
	</select>
	<p><input type="submit" /></p>
	</form>	
	
	<?php
	require_once 'connection.php'; // подключаем скрипт
	 
	// подключаемся к серверу
	$link = mysqli_connect($host, $user, $password, $database) 
		or die("Ошибка " . mysqli_error($link));
	
	// кодировка
	mysqli_set_charset($link, "utf8");
	 
	// выполняем операции с базой данных
	$semestr=$_POST['v_sem'];
	$query ="select subject.number_s, subject.name_s, books.name_b FROM subject, books WHERE subject.id_s=books.id_s and subject.number_s='$semestr'";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	
	// проверка результата
	if(mysqli_num_rows($result)) {
	
	// построение таблицы
	print "<table border='1'>";
	
	print "<thead>";
	print "<tr>";
	print "<td>Семестр</td>";
	print "<td>Предмет</td>";
	print "	<td>Книга</td>";
	print "</tr>";
	print "</thead>";
	
	print "<tbody>";
	while ($row = mysqli_fetch_array($result))
	{
		print "<tr>";
		print '<td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td>';
		print "</tr>";
	}
	print "</tbody>";
	print "</table>";
	
	} else {echo "Данные не найдены =(";}
	 
	// закрываем подключение
	mysqli_close($link);
	?>
	
	<p>Другое:</p>
	<p><a href="subject.php">Выбор по предмету</a></p>
	<p><a href="create.php">Добавление книги</a></p>
	
</body>
</html>