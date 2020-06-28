<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Добавление книги </title>
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
	$query ="select name_s, number_s FROM subject GROUP BY number_s";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	
	if(!isset($_POST['v_sub'])) {
		$_POST['v_sub']= "ЦОС";
	}
	if(!isset($_POST['v_sem'])) {
		$_POST['v_sem']= "4";
	}
	if(!isset($_POST['book'])) {
		$_POST['book']="";
	}
	if(!isset($_POST['b_vol'])) {
		$_POST['b_vol']="1";
	}
	?>
	
	
	<form method="post">
	Выбор предмета: <br>
	<select name=v_sub size=1>
	<?php
	// проверка результата
	if(mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result))
		{
		print '<option value='.$row[0].''.($_POST['v_sub']==$row[0] ? ' selected="selected"' : "").'>'.$row[0].' ('.$row[1].')</option>';
		$m_sem[]=$row[1];
		}
	} else {echo "Данные не найдены =(";}
	
	// закрываем подключение
	mysqli_close($link);
	?>
	</select>
	<br>Выбор семестра: <br>
	<select name=v_sem size=1>
	<?php
	foreach ($m_sem as $value){
		print '<option value='.$value.''.($_POST['v_sem']==$value ? ' selected="selected"' : "").'>'.$value.'</option>';}
	?>
	</select>
	<br> Название: <br>
	<input name="book" type="text" value="<?=$_POST['book']?>" required>
	<br> Количество: <br>
	<input name="b_vol" type="text" value="<?=$_POST['b_vol']?>">
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
	$subject=$_POST['v_sub'];
	$query ="SELECT id_s from subject WHERE name_s='$subject' and number_s='$semestr'";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	
	// проверка результата
	if(mysqli_num_rows($result)) {
		while ($row = mysqli_fetch_array($result))
		{
			$id_s=$row[0];
		}
	} else {echo "Соответствие предмета и семестра не найдено =(";}
	 
	// закрываем подключение
	mysqli_close($link);
	?>

	<?php
	if(!$_POST['book']=="" and isset($id_s)) {
	require_once 'connection.php'; // подключаем скрипт
	 
	// подключаемся к серверу
	$link = mysqli_connect($host, $user, $password, $database) 
		or die("Ошибка " . mysqli_error($link));
	
	// кодировка
	mysqli_set_charset($link, "utf8");
	
	$book=$_POST['book'];
	$b_vol=$_POST['b_vol'];
	 
	// выполняем операции с базой данных
	$result = $link->query("INSERT INTO books (name_b, volume_b, id_s) VALUES ('$book', '$b_vol', '$id_s')");
	
	if ($result == true){
	echo "Книга занесена в базу данных";
	}else{
	echo "Книга не занесена в базу данных";
	}
	 
	// закрываем подключение
	mysqli_close($link);
	}
	?>	
	
	<p>Другое:</p>
	<p><a href="subject.php">Выбор по предмету</a></p>
	<p><a href="semestr.php">Выбор по семестру</a></p>
	
</body>
</html>