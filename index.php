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
echo "<tr><td>�������� ��������</td>";
echo "<td>������</td>";
echo "<td></td>";
echo "<td>������� ���������</td>";	
echo "</tr>";	

echo "<tr><td rowspan='2'>�������� ������� robots.txt</td>";
echo "<td align='center' rowspan='2' class='col2'>OK</td>";
echo "<td>���������</td><td>���� robots.txt ������������</td></tr>";
echo "<tr><td>������������</td><td>��������� �� ���������</td></tr>";	
echo "</tr>";	
if($fh>=1)
{
	echo "<tr><td rowspan='2'>�������� �������� ��������� Host</td>";
	echo "<td align='center' rowspan='2' class='col2'>OK</td>";
	echo "<td>���������</td><td>��������� Host �������</td></tr>";
	echo "<tr><td>������������</td><td>��������� �� ���������</td></tr>";	
	echo "</tr>";	
	
	if($fh==1)
	{
		echo "<tr><td rowspan='2'>�������� ���������� �������� Host, ����������� � �����</td>";
		echo "<td align='center' rowspan='2' class='col2'>OK</td>";
		echo "<td>���������</td><td>� ����� ��������� 1 ��������� Host</td></tr>";
		echo "<tr><td>������������</td><td>��������� �� ���������</td></tr>";	
		echo "</tr>";	
	}
	else if($fh==2)
	{
		echo "<tr><td rowspan='2'>�������� ���������� �������� Host, ����������� � �����</td>";
		echo "<td align='center' rowspan='2' class='col1'>������</td>";
		echo "<td>���������</td><td>� ����� ��������� ��������� �������� Host</td></tr>";
		echo "<tr><td>������������</td><td>�����������: ��������� Host ������ ���� ������� � ����� ������ 1 ���.";
		echo "���������� ������� ��� �������������� ��������� Host � �������� ������ 1, ���������� � ��������������� ��������� ������� �����</td></tr>";	
		echo "</tr>";	
	}
}
else
{
	echo "<tr><td rowspan='2'>�������� �������� ��������� Host</td>";
	echo "<td align='center' rowspan='2' class='col1'>������</td>";
	echo "<td>���������</td><td>� ����� robots.txt �� ������� ��������� Host</td></tr>";
	echo "<tr><td>������������</td><td>�����������: ��� ����, ����� ��������� ������� �����, ����� ������ ����� �������� �������� ��������, ���������� ��������� ����� ��������� ������� � ��������� Host.";
	echo "� ������ ������ ��� �� ���������. ���������� �������� � ���� robots.txt ��������� Host. ��������� Host ������ � ����� 1 ���, ����� ���� ������.</td></tr>";	
	echo "</tr>";	
}

if($fz==1)
{
	echo "<tr><td rowspan='2'>�������� ������� ����� robots.txt</td>";
	echo "<td align='center' rowspan='2' class='col2'>OK</td>";
	echo "<td>���������</td><td>������ ����� robots.txt ���������� " . $res . " ��, ��� ��������� � �������� ���������� �����</td></tr>";
	echo "<tr><td>������������</td><td>��������� �� ���������</td></tr>";	
	echo "</tr>";	
}
else
{
	echo "<tr><td rowspan='2'>�������� ������� ����� robots.txt</td>";
	echo "<td align='center' rowspan='2' class='col1'>������</td>";
	echo "<td>���������</td><td>������ ����� robots.txt ���������� " . $res . " ��, ��� ��������� ���������� �����</td></tr>";
	echo "<tr><td>������������</td><td>�����������: ����������� ���������� ������ ����� robots.txt ���������� 32 ��. ";
	echo "���������� �������������� ���� robots.txt ����� �������, ����� ��� ������ �� �������� 32 ��</td></tr>";	
	echo "</tr>";
}

if($fs==1)
{
	echo "<tr><td rowspan='2'>�������� �������� ��������� Sitemap</td>";
	echo "<td align='center' rowspan='2' class='col2'>OK</td>";
	echo "<td>���������</td><td>��������� Sitemap �������</td></tr>";
	echo "<tr><td>������������</td><td>��������� �� ���������</td></tr>";	
	echo "</tr>";	
}
else
{
	echo "<tr><td rowspan='2'>�������� �������� ��������� Sitemap</td>";
	echo "<td align='center' rowspan='2' class='col1'>������</td>";
	echo "<td>���������</td><td>� ����� robots.txt �� ������� ��������� Sitemap</td></tr>";
	echo "<tr><td>������������</td><td>�����������: �������� � ���� robots.txt ��������� Sitemap</td></tr>";	
	echo "</tr>";		
}

if($fr==1)
{
	echo "<tr><td rowspan='2'>�������� ���� ������ ������� ��� ����� robots.txt</td>";
	echo "<td align='center' rowspan='2' class='col2'>OK</td>";
	echo "<td>���������</td><td>���� robots.txt ����� ��� ������ ������� 200</td></tr>";
	echo "<tr><td>������������</td><td>��������� �� ���������</td></tr>";	
	echo "</tr>";		
}
else
{
	echo "<tr><td rowspan='2'>�������� ���� ������ ������� ��� ����� robots.txt</td>";
	echo "<td align='center' rowspan='2' class='col1'>������</td>";
	echo "<td>���������</td><td>��� ��������� � ����� robots.txt ������ ���������� ��� ������ " . $rc1 . "</td></tr>";
	echo "<tr><td>������������</td><td>�����������: ���� robots.txt ������ �������� ��� ������ 200, ����� ���� �� ����� ��������������.";
	echo "���������� ��������� ���� ����� �������, ����� ��� ��������� � ����� robots.txt ������ ���������� ��� ������ 200</td></tr>";	
	echo "</tr>";		

}
echo "</table>";	
	unlink("robots.txt");
	$f=0;
}
else if($f==0)
{
echo "<table border=1>";
echo "<tr><td>�������� ��������</td>";
echo "<td>������</td>";
echo "<td></td>";
echo "<td>������� ���������</td>";	
echo "</tr>";	

echo "<tr><td rowspan='2'>�������� ������� robots.txt</td>";
echo "<td align='center' rowspan='2' class='col1'>������</td>";
echo "<td>���������</td><td>���� robots.txt �����������</td></tr>";
echo "<tr><td>������������</td><td>�����������: ������� ���� robots.txt � ���������� ��� �� �����.</td></tr>";	
echo "</tr>";
echo "</table>";
}

?>
</body>
</html>