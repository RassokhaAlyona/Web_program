<?
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

?>

