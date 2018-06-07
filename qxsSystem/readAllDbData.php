<?php

header('Content-type:text/html;charset=utf-8');
 
//(0)数据库配置信息  

$db_host ="qdm166130555.my3w.com";
$db_user = "qdm166130555";
$db_pwd="qqqqqqA123";
$db_name="qdm166130555_db";



$link = @mysql_connect($db_host,$db_user,$db_pwd);  

//(2)选择当前数据库  
if(!mysql_select_db($db_name))  
{  
    echo "<font size=7 color=red>选择数据库{$db_name}失败！</font>";  
    exit();  
}  
  
//(3)设置MySQL返回的数据字符集  
mysql_query("set names utf8");   //设置当前编程环境的字符集。与header("content-type:text/html;charset=utf-8");保持一致。  
  
//(4)执行SQL语句  

//$sql = "INSERT INTO user(username,password,regdate) VALUES ('设置当前', 'password', '2018-04-16')";
//$result = mysql_query($sql,$link);  


$sql = "select * from user ";  
$result = mysql_query($sql,$link);  
if(!$result)  
{  
    echo "<font size=7 color=red>数据查询失败！</font>";  
    exit();  
}  
  
//(5)从结果集中取出数据  
//$arr = mysql_fetch_row($result);  
   while($row=mysql_fetch_row($result)){
 
      echo '<tr><td>'.$row[0].'</td>&nbsp';
      echo '<td>'.$row[1].'</td>&nbsp</tr>';
	  echo '<td>'.$row[2].'</td>&nbsp</tr>';
      echo '<td>'.$row[3].'</td>&nbsp</tr>';
	  echo '<br>';
   }
   
$today=strtotime(date("Y-m-d"));

$sql = "select * from userInfor where UNIX_TIMESTAMP(birthdate) <=".$today; 
$result = mysql_query($sql,$link);  
if(!$result)  
{  
    echo "<font size=7 color=red>数据查询失败！</font>";  
    exit();  
}  
  
//(5)从结果集中取出数据  
//$arr = mysql_fetch_row($result);  
   while($row=mysql_fetch_row($result)){
 
      echo '<tr><td>'.$row[0].'</td>&nbsp';
      echo '<td>'.$row[1].'</td>&nbsp</tr>';
	  echo '<td>'.$row[2].'</td>&nbsp</tr>';
      echo '<td>'.$row[3].'</td>&nbsp</tr>';
	  echo '<td>'.$row[4].'</td>&nbsp</tr>';
	  echo '<td>'.$row[5].'</td>&nbsp</tr>';
	  echo '<td>'.$row[6].'</td>&nbsp</tr>';
	  echo '<br>';
   }  
   
?>