<html>
<head>
<title> Test </title>
<style type="text/css">
   td.col1 { background: red;}
   td.col2 { background: green;}
</style>
</head>
<body>
<?
#allow_url_include;
echo "<form>";
echo "<table border=1>";
echo "<tr>";
echo "<td>";
echo "<p>Enter URL: <input required type=\"text\" name=\"src\" value='http://google.com/' ></p>";
$src=$_GET['src'];
$src=$src."robots.txt";
if($_GET['src'])
{
if(file_get_contents($src))
{
	
	$arr=file_get_contents($src,FILE_USE_INCLUDE_PATH);
	if(strpos($arr,"Host"))
	{
		#echo "Host founded!";
		$fh=1;
		if(strpos($arr,"Host")!=strripos($arr,"Host",-1))
		{
			#echo "too much hosts in robots.txt!";
			$fh=2;
		}
	}
	else
	{
		$fh=0;
	}
	#echo "<br>";
	if(strpos($arr,"Sitemap"))
	{
		#echo "Sitemap!";
		$fs=1;
	}
	else
	{
		$fs=0;
	}
	#echo "<br>";
	
	$Headers = @get_headers($src);
	$rc="000";
	$rc=strstr($Headers[0]," ");
	$rc1=" ";
	#	echo "Responce code: ";
	for($i=1;$i<4;$i++)
	{
		#echo $rc[$i];
		$rc1=$rc1 . $rc[$i];
	}
	

	
	if(preg_match("|200|" , $rc))
	{
		$fr=1;
	}
	else
	{
		$fr=0;
	}
	#echo "<br>";
	
	$local="robots.txt";
	file_put_contents($local, file_get_contents($src));
	$res=filesize("robots.txt");
	$res/=1024;
	if($res>32)
	{
		#echo "Mass: " . $res . " kB (" . $res*1024 . " Byte) it's too much!";
		$fz=0;
	}
	else
	{
		#echo "Mass: " . $res . " kB (" . $res*1024 . " Byte) it's OK";
		$fz=1;
	}

	
$f=1;
}
else
{	
}
}
echo "</td>";
echo "</tr>";
echo "</table>";
?>

<input type="submit" name="submit" value='Search!'/>


<?
$ss=$_POST['submit'];
echo "</form>";

if($f==1)
{
echo "<table border=1>";
echo "<tr><td>Название проверки</td>";
echo "<td>Статус</td>";
echo "<td></td>";
echo "<td>Текущее состояние</td>";	
echo "</tr>";	

echo "<tr><td rowspan='2'>Проверка наличия robots.txt</td>";
echo "<td align='center' rowspan='2' class='col2'>OK</td>";
echo "<td>Состояние</td><td>Файл robots.txt присутствует</td></tr>";
echo "<tr><td>Рекомендации</td><td>Доработки не требуются</td></tr>";	
echo "</tr>";	
if($fh>=1)
{
	echo "<tr><td rowspan='2'>Проверка указания директивы Host</td>";
	echo "<td align='center' rowspan='2' class='col2'>OK</td>";
	echo "<td>Состояние</td><td>Директива Host указана</td></tr>";
	echo "<tr><td>Рекомендации</td><td>Доработки не требуются</td></tr>";	
	echo "</tr>";	
	
	if($fh==1)
	{
		echo "<tr><td rowspan='2'>Проверка количества директив Host, прописанных в файле</td>";
		echo "<td align='center' rowspan='2' class='col2'>OK</td>";
		echo "<td>Состояние</td><td>В файле прописана 1 директива Host</td></tr>";
		echo "<tr><td>Рекомендации</td><td>Доработки не требуются</td></tr>";	
		echo "</tr>";	
	}
	else if($fh==2)
	{
		echo "<tr><td rowspan='2'>Проверка количества директив Host, прописанных в файле</td>";
		echo "<td align='center' rowspan='2' class='col1'>Ошибка</td>";
		echo "<td>Состояние</td><td>В файле прописано несколько директив Host</td></tr>";
		echo "<tr><td>Рекомендации</td><td>Программист: Директива Host должна быть указана в файле толоко 1 раз.";
		echo "Необходимо удалить все дополнительные директивы Host и оставить только 1, корректную и соответствующую основному зеркалу сайта</td></tr>";	
		echo "</tr>";	
	}
}
else
{
	echo "<tr><td rowspan='2'>Проверка указания директивы Host</td>";
	echo "<td align='center' rowspan='2' class='col1'>Ошибка</td>";
	echo "<td>Состояние</td><td>В файле robots.txt не указана директива Host</td></tr>";
	echo "<tr><td>Рекомендации</td><td>Программист: Для того, чтобы поисковые системы знали, какая версия сайта является основных зеркалом, необходимо прописать адрес основного зеркала в директиве Host.";
	echo "В данный момент это не прописано. Необходимо добавить в файл robots.txt директиву Host. Директива Host задётся в файле 1 раз, после всех правил.</td></tr>";	
	echo "</tr>";	
}

if($fz==1)
{
	echo "<tr><td rowspan='2'>Проверка размера файла robots.txt</td>";
	echo "<td align='center' rowspan='2' class='col2'>OK</td>";
	echo "<td>Состояние</td><td>Размер файла robots.txt составляет " . $res . " кБ, что находится в пределах допустимой нормы</td></tr>";
	echo "<tr><td>Рекомендации</td><td>Доработки не требуются</td></tr>";	
	echo "</tr>";	
}
else
{
	echo "<tr><td rowspan='2'>Проверка размера файла robots.txt</td>";
	echo "<td align='center' rowspan='2' class='col1'>Ошибка</td>";
	echo "<td>Состояние</td><td>Размер файла robots.txt составляет " . $res . " кБ, что превышает допустимую норму</td></tr>";
	echo "<tr><td>Рекомендации</td><td>Программист: Максимально допустимый размер файла robots.txt составляем 32 кб. ";
	echo "Необходимо отредактировть файл robots.txt таким образом, чтобы его размер не превышал 32 Кб</td></tr>";	
	echo "</tr>";
}

if($fs==1)
{
	echo "<tr><td rowspan='2'>Проверка указания директивы Sitemap</td>";
	echo "<td align='center' rowspan='2' class='col2'>OK</td>";
	echo "<td>Состояние</td><td>Директива Sitemap указана</td></tr>";
	echo "<tr><td>Рекомендации</td><td>Доработки не требуются</td></tr>";	
	echo "</tr>";	
}
else
{
	echo "<tr><td rowspan='2'>Проверка указания директивы Sitemap</td>";
	echo "<td align='center' rowspan='2' class='col1'>Ошибка</td>";
	echo "<td>Состояние</td><td>В файле robots.txt не указана директива Sitemap</td></tr>";
	echo "<tr><td>Рекомендации</td><td>Программист: Добавить в файл robots.txt директиву Sitemap</td></tr>";	
	echo "</tr>";		
}

if($fr==1)
{
	echo "<tr><td rowspan='2'>Проверка кода ответа сервера для файла robots.txt</td>";
	echo "<td align='center' rowspan='2' class='col2'>OK</td>";
	echo "<td>Состояние</td><td>Файл robots.txt отдаёт код ответа сервера 200</td></tr>";
	echo "<tr><td>Рекомендации</td><td>Доработки не требуются</td></tr>";	
	echo "</tr>";		
}
else
{
	echo "<tr><td rowspan='2'>Проверка кода ответа сервера для файла robots.txt</td>";
	echo "<td align='center' rowspan='2' class='col1'>Ошибка</td>";
	echo "<td>Состояние</td><td>При обращении к файлу robots.txt сервер возвращает код ответа " . $rc1 . "</td></tr>";
	echo "<tr><td>Рекомендации</td><td>Программист: Файл robots.txt должны отдавать код ответа 200, иначе файл не будет обрабатываться.";
	echo "Необходимо настроить сайт таким образом, чтобы при обращении к файлу robots.txt сервер возвращает код ответа 200</td></tr>";	
	echo "</tr>";		

}
echo "</table>";	
	unlink("robots.txt");
	$f=0;
}
else if($f==0)
{
echo "<table border=1>";
echo "<tr><td>Название проверки</td>";
echo "<td>Статус</td>";
echo "<td></td>";
echo "<td>Текущее состояние</td>";	
echo "</tr>";	

echo "<tr><td rowspan='2'>Проверка наличия robots.txt</td>";
echo "<td align='center' rowspan='2' class='col1'>Ошибка</td>";
echo "<td>Состояние</td><td>Файл robots.txt отсутствует</td></tr>";
echo "<tr><td>Рекомендации</td><td>Программист: Создать файл robots.txt и разместить его на сайте.</td></tr>";	
echo "</tr>";
echo "</table>";
}

?>
</body>
</html>