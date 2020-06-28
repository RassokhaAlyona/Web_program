<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Выбор по предмету </title>
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
	$query ="select name_s FROM subject GROUP BY name_s";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	
	if(!isset($_POST['v_sub'])) {
		$_POST['v_sub']= "ЦМПТ";
	}
	?>
	
	Выбор предмета: <br>
	<form method="post">
	<select name=v_sub size=1>
	<?php
	// проверка результата
	if(mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result))
		{
		print '<option value='.$row[0].''.($_POST['v_sub']==$row[0] ? ' selected="selected"' : "").'>'.$row[0].'</option>';
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
	$subject=$_POST['v_sub'];
	$query ="select subject.name_s, subject.number_s, books.name_b FROM subject, books WHERE subject.id_s=books.id_s and subject.name_s='$subject'";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	
	// проверка результата
	if(mysqli_num_rows($result)) {
	
	// построение таблицы
	print "<table border='1'>";
	
	print "<thead>";
	print "<tr>";
	print "<td>Предмет</td>";
	print "<td>Семестр</td>";
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
	<p><a href="semestr.php">Выбор по семестру</a></p>
	<p><a href="create.php">Добавление книги</a></p>
	
</body>
</html>