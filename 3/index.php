<?php
$out = '';
/* Init */

$table_bg = '';
$table_opt = array();
$output_loc = '';

if(isset($_POST['ok'])){
	if( isset( $_POST['table_bg'] ) ) {
		$table_bg = $_POST['table_bg'];
	}
	if( isset( $_POST['table_opt'] ) ) {
		$table_opt = $_POST['table_opt'];
	}
	if( isset( $_POST['output_loc'] ) ) {
		$output_loc = $_POST['output_loc'];
	}
}
$out .=  '<!DOCTYPE html>
<html lang=\'ru\'>
	<head>
		<title>Данные студентов</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
body {
	font-family: Arial, Verdana,  sans-serif; /* Семейство шрифтов */
	font-size: 11pt; /* Размер основного шрифта в пунктах  */
	color: #333; /* Цвет основного текста */'; 
	if($_FILES['incom_file']['tmp_name']=='') {
		$out .=  "Картинка не загружена<br/>";
	} elseif ( !move_uploaded_file($_FILES['incom_file']['tmp_name'], 'bg.jpg') ) {
		$out .= "Картинка не перезаписалась<br/>";
	}

	if( file_exists("bg.jpg") ) {
		$out .=  'background: url("bg.jpg") fixed; ';
	} else {
		$out .=   'background-color: #f0f0f0; ';
	}
$out .=   '/* Фон веб-страницы */}
h1 {
	color: #a52a2a; /* Цвет заголовка */
	font-size: 28pt; /* Размер шрифта в пунктах */
	font-family: Segoe Script, serif; /* Семейство шрифтов */
	font-weight: normal; /* Нормальное начертание текста  */
}

p {
	text-align: justify; /* Выравнивание по ширине */
	margin-left: 60px; /* Отступ слева в пикселах */
	margin-right: 10px; /* Отступ справа в пикселах */
	border-left: 1px solid #999; /* Параметры линии слева */
	border-bottom: 1px solid #999; /* Параметры линии снизу */
	padding-left: 10px; /* Отступ от линии слева до текста  */
	padding-bottom: 10px; /* Отступ от линии снизу до текста  */
}

table {';
	if( $table_bg == 'red' ){
		$out .=   'background-color: #EF3333; ';
	} elseif( $table_bg == 'blue' ){
		$out .=   'background-color: rgba(0, 117, 255, 0.49);';
	} elseif( $table_bg == 'green' ){
		$out .=   'background-color: #8AC56E; ';
	}
	else {
		$out .=   'background-color: #f0f0f0;'; 
	}

	if( in_array( 'bold', $table_opt ) ) {
		$out .=  'font-weight: 900;';
	}
	if( in_array( 'italic', $table_opt ) ) {
		$out .=  'font-style: italic;';
	}
		$out .=  '}';
	
		$out .=   '/* Фон таблицы */
table.jewel {
	min-width: 300px; /* Ширина таблицы */
	border: 1px solid #666; /* Рамка вокруг таблицы */
}

td {
	text-align: left;';
	if( in_array( 'hide', $table_opt ) ){
		$out .=  'visibility: hidden;';
	}
	$out .=  '
}

th {
	background: #009383; /* Цвет фона */
	color: #fff; /* Цвет текста */
	text-align: center; /* Выравнивание текста по центру */
}

#date{
	width: 200px;
}

#fio{
	width: 330px;
}

#no{
	width: 57px;
}

tr.odd {
	background: #ebd3d7; /* Цвет фона */
}

input[name="msg"]{
	height: 40px;
	width: 400px;
}

input[name="s_name"]{
	margin-left: 20px;
}

input[name="f_name"]{
	margin-left: 52px;
}

input[name="t_name"]{
	margin-left: 15px;
}

.log_header{
	font-weight: 600;
}



.log_box {
	font-size: 10pt;';
	if ( $output_loc == 'Справа' ) {
	$out .=  '
	float: left;
}
form {
	float: left;
}';
}
$out .=  '
.err_msg {
	color: red;
}
		</style>
	</head>
	<body>
		<h1> Данные студентов ФТФ</h1>
			<form id="send" enctype="multipart/form-data" action="index.php" method="post">
				
				<b>Фон таблицы:</b><br/>
				 <input type="radio" name="table_bg" value="red"/> Красный<br/>
				 <input type="radio" name="table_bg"  value="blue"/> Голубой<br/>
				 <input type="radio" name="table_bg" value="green"/> Зеленый<br/><br/>
				<b>Опции таблицы:</b><br/>
				<input type="checkbox" name="table_opt[]" value="bold"/>Жирный шрифт<br/>
				<input type="checkbox" name="table_opt[]" value="italic"/>Курсивный шрифт<br/>
				<input type="checkbox" name="table_opt[]" value="hide"/>Скрытые ячейки<br/><br/>
				<b>Расположение вывода: </b><br/>
				<select name="output_loc" form="send">
					<option>Внизу</option>
					<option>Справа</option>
				</select><br/><br/>
				<b>Фон страницы:</b><br/>
				<input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
				<input type="file" name="incom_file"/><br/> <br/>
				<input type="submit" name="ok" value="В путь!"/>
			</form>
				<br/>
			<div class="log_box">
			<div class="log_header">Вывод</div>';

// ВЫПОЛНЕНИЕ СКРИПТА

function file_dump_csv($file) 
{
$text=fopen('spisok.txt', "r");
$out = '<table>
	<tr>
	<td>Фамилия</td>
	<td>Имя</td>
	<td>Дата рождения</td>
	<td>Номер зачетки</td>
	</tr>';
while (!feof($text)) {
    $mass = explode(" ", fgets($text, 4096));
	$out .= '<tr>';
	for ($i=0; $i<=3; $i++){
		$out .= '<td>'.$mass[$i].'</td>';
		}
	$out .= '</tr>';
}
fclose($text);
 echo $out;

}

$out .= file_dump_csv('spisok.txt', "r");
$out .= '</div></body></html>';
echo $out;
?>