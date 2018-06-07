<?php /** file:reg.inc.php 用户注册*/

header('Content-type:text/html;charset=utf-8');

//只能在微信打开
$ref=$_SERVER['HTTP_REFERER'];  
if($ref==''){  
 echo '对不起，请从微信浏览器打开';
 exit();  
}else{  
$url=parse_url($ref);  
  if($url[host]!='www.dawin.top'){  
 // if($url !='http://www.dawin.top/yigong/regt.php'){ 
 // echo $_SERVER['HTTP_REFERER'];
 // echo $url[host];
  echo '请从官方路径访问';  
  exit();  
  }   
}		
			date_default_timezone_set('prc');/*设置时区*/
		//	@$username = htmlspecialchars($_POST['username']);
		   
		//	print_r($_POST); 
			echo  "本次查询信息的条件为：  " ;

 		    @$weekday = $_POST['weekday'];
			@$sevice  = $_POST['sevice'];
			@$skills  = $_POST['skills'];
			
			
			$Weeks   = " 1 ";
			$Service = " 1 ";
			$Skills  = " 1 ";
			
			//-1 for changing 'or' to 'and' at the end  
			if(count($weekday) >0){
				$sqlWeeks   = "(";
				echo '<font size=4 color=red> Weekday is : ';
				for($i=0;$i< count($weekday) -1 ;$i++){
					echo $weekday[$i]."  ";
					$sqlWeeks .= $weekday[$i]." = '1' or " ;
				}
				$sqlWeeks .= $weekday[$i]." = '1' ) ";
				echo $weekday[$i]."  |||</font>";
				$Weeks  = $sqlWeeks;
		    //echo $sqlWeeks."<br>";
			}
			
			//Start service sql
			if(count($sevice)>0){
				$sqlService   = "(";
				echo '<font size=4 color=blue> Service is : ';
				for($i=0;$i< count($sevice)-1;$i++){
					echo $sevice[$i]."  ";
					$position = $sevice[$i]*2-1;
					$sqlService .= "substring(service,".$position.",1)='1' or ";
				}
				$sqlService .= "substring(service,".($sevice[$i]*2-1).",1)='1' )";
				echo $sevice[$i]."  |||</font>";
				$Service = $sqlService;
			}
			
			//End Start service sql
			
			//Start skills SQL
			if (count($skills) > 0 ){
				$sqlSkills  = "(";
				echo '<font size=4 color=green> Skills is :   ';
				for($i=0;$i< count($skills)-1;$i++){
					echo $skills[$i]."  ";
					$position = $skills[$i]*2-1;
					$sqlSkills .= "substring(skills,".$position.",1)='1' or ";
				}
				echo $skills[$i]."  |||</font>";
				$sqlSkills .= "substring(skills,".($skills[$i]*2-1).",1)='1' )";		
				$Skills = $sqlSkills;
			}
			//End skills SQL
			echo ' <br/>';
			$sqlCritical = $Weeks."and".$Service."and".$Skills ;
			
 			include"common.php";
			mysqli_query($link,"set names 'utf8'");
			$sql_check = "SELECT * FROM userDetail WHERE ".$sqlCritical ;//$sqlWeeks.$sqlService.$sqlSkills;
			//echo $sql_check."<br>";
			$result_check=mysqli_query($link,$sql_check);


			if(!$result_check){  
				echo "<font size=4 color=red>数据查询失败！</font>";
				exit();				
			}  
			$rows=mysqli_num_rows($result_check);
			
			if($rows > 0){
				echo "<br/><font size=4 color=blue>==============本次查询结果为=================</font><br/>"; 
				echo  '<table width=800 border="1" bordercolor= "#a0c6e5"><tr>&nbsp<th width=60>Name</th>
														  <th width=80>Tel</th>
														  <th width=80>Career</th>
														  <th width=100>WorkDay</th>
														  <th width=200>Service</th>
														  <th>Skills</th>&nbsp</tr>' ;
				while($row=mysqli_fetch_array($result_check)){
	 
				  echo '<tr><td>'.$row[0].'</td>&nbsp';
				  echo '<td> '.$row[1].'  </td>&nbsp';				  
				  echo '<td> '.$row[10].'   </td>&nbsp';
				  echo '<td> '.$row[2].' '.$row[3].' '.$row[4].' '.$row[5].' '.$row[6].' '.$row[7].' '.$row[8].' '.$row[9].'  </td>&nbsp';
				  echo '<td> '.$row[11].'   </td>&nbsp';
				  echo '<td>'.$row[12].'</td>&nbsp</tr>';

			   }
			   echo "</table><br/>" ;
			   echo "<font size=4 color=blue>===========================================</font><br/>";
			}else{
				echo '<br/>';
				echo "<font size=4 color=red>没有找到合适的人员！</font>";  
				exit(); 
			}
			
			
			
		   // 释放结果集
			mysqli_free_result($result_check);
 
			mysqli_close($link);
		   
		/*	
		if(isset($_POST['reg'])){
		
			//添加数据需要先连接并选数据库，包含conn.inc.php文件连接数据库
			include"common.php";
			mysqli_query($link,"set names 'utf8'");
			$sql_2="SELECT * FROM userInfor WHERE phone = '$user_phone'";
			//校验手机号， 如果存在则说明已经注册， 手机号重复（比如换号）的几率很小
			
			
			$result_2=mysqli_query($link,$sql_2);
		//	$rows=mysql_fetch_array($result_2);
		    $rows=mysqli_num_rows($result_2);
   			mysqli_free_result($result_2);
	
			if($rows>0){
				echo "<script type='text/javascript'>alert('注册失败：该手机号码已存在');location='javascript:history.back()';</script>"; 

			}else{
				
				// echo "new user , prearing insert";
				
				//根据用户通过POST提交的数据组合插入数据库的SQL语句
				//if(strlen($username)>=2&&strlen($password)>=4){
				if(strlen($username)>=2&&strlen($user_phone)==11){	
				//$mydb= new mysqli("localhost","id3902494_root","qqqqqq123","id3902494_user"); 
				
			    //	$sql = "INSERT INTO user(username,password,regdate) VALUES(username,password)";				
				//$result=mysqli_query($link,$sql);
				
				
				$sql = "INSERT INTO user(username,password,regdate) VALUES ('$username', '$password', '$regdate')";
				if($result = mysqli_query($link,$sql)){
				
				
				//if ($mydb->query($sql_2) == TRUE) {
			//		echo "成功";
			//		echo "<script> alert('用户注册成功！'); </script>";
			//	    echo "<meta http-equiv='Refresh' content='0;URL=$url'>";
				}else{
					echo "失败";
					echo mysqli_error($link); 
				//	echo $username;
				//	echo $password;
				//	echo $regdate;
					
				}
				
				$sql_id="SELECT * FROM userInfor WHERE openid = '$userOpenid'";
				$result_id=mysqli_query($link,$sql_id);
				$rows_id=mysqli_num_rows($result_id);
				
				if($rows_id > 0){
					//update into table userinfor
					$sql = "UPDATE userInfor SET 
						username ='$username', birthdate = '$birthdate',
						shi_name='$shi_name',phone='$user_phone',sex='$userSex'
						WHERE openid = '$userOpenid' ";
				
				}else{
					//insert into table userinfor
					$sql = "INSERT INTO userInfor(username,openid,birthdate,shi_name,phone,sex) 
							VALUES ('$username', '$userOpenid', '$birthdate', '$shi_name' ,'$user_phone','$userSex')";
				
				}
				
					if($result = mysqli_query($link,$sql)){
					//if ($mydb->query($sql_2) == TRUE) {
					//	echo "成功";
					//	echo "<iframe src='https://www.wjx.cn/jq/4050278,i,t.aspx?width=760&source=iframe' width='799' height='800' frameborder='0' style='overflow:auto'></iframe>";
						$url = "wenjuan.html" ;
						echo "<meta http-equiv='Refresh' content='0;URL=$url'>";
					}else{
						echo "失败";
						echo mysqli_error($link); 
					}
					
				
				mysqli_free_result($result_id);
				}
			}
			
		}	*/
?>


<html>
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width,inital-scale=1.0;">
    <title>义工信息CX</title>
	<style type="text/css">
		body {color:black}
		h5 {color:#000fff}
		p.ex {color:rgb(0,0,255)}
</style>
</head>
<body>
			注释：<br/>
		    WorkDay / Service /Skills 表格位对应参考
			<br/>
			<table border="1" bordercolor="#a0c6e5" style="border-collapse:collapse;"><tr><h5>WorkDay 星期位图对照表</h5></tr>
			<tr><td>星期一</td><td>星期二</td><td> 星期三</td><td> 星期四</td><td> 星期五</td><td> 星期六</td><td> 星期日</td><td> 公共假日 </td></tr>
			<tr><td>Mon </td><td>   Tue</td><td>   Wen </td><td>  The </td><td>  Frd  </td><td>   Sat  </td><td>  Sun  </td><td>  Pubday</td></tr></table>
			
			<table border="1" bordercolor="#a0c6e5" style="border-collapse:collapse;"><tr><h5>Service位图对照表, 根据表格的位置查找服务项目</h5></tr>
			<tr><td>值班</td><td>&nbsp斋堂&nbsp</td><td>&nbsp销售&nbsp</td><td>网站后台</td><td>新媒宣传</td><td>电脑维修</td><td>活动主持</td><td>&nbsp摄影&nbsp</td><td>养生保健
			           </td><td>讲解接待</td><td>培训讲解</td><td>网络义工</td><td>电器维修</td><td>&nbsp其他&nbsp</td></tr>
			<tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10
			</td><td>11</td><td>12</td><td>13</td><td>14</td></tr></table>
			
			<table border="1" bordercolor="#a0c6e5" style="border-collapse:collapse;"><tr><h5>Skills位图对照表,根据的位置查找对应的技能爱好</h5></tr>
			<tr><td>手工制作</td><td>平面设计</td><td>网站管理</td><td>&nbsp编辑&nbsp</td><td>活动报道</td><td>活动策划</td><td>&nbsp驾驶&nbsp</td><td>计算机&nbsp</td><td>&nbsp法律&nbsp
						</td><td>&nbsp财务&nbsp</td><td>&nbsp摄影&nbsp</td><td>文艺表演</td><td>&nbsp外语&nbsp</td><td>&nbsp其他&nbsp</td></tr>
			<tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10
				  </td><td>11</td><td>12</td><td>13</td><td>14</td></tr>
			</table><br/>
			
</body>
</html>
