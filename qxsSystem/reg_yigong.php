<?php /** file:reg.inc.php 用户注册*/

header('Content-type:text/html;charset=utf-8');

//只能在微信打开
$ref=$_SERVER['HTTP_REFERER'];  
if($ref==''){  
echo '对不起，请从微信浏览器打开';  
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


//header("Content-Type:text/html; charset=gbk");
			
			date_default_timezone_set('prc');/*设置时区*/
		//	@$username = htmlspecialchars($_POST['username']);
		    @$username = $_POST['username'];
			@$password = $_POST['pass'];
			$password = MD5($password);
			$regdate = date('Y-m-d H:i:s',time());
			
			@$birthdate = $_POST['dateBirth'];
			@$shi_name = $_POST['shi_name'];
			@$userOpenid = $_POST['openid'];
			//@$userOpenid = $openid ;//$_POST['openid'];
			@$user_phone = $_POST['user_phone'];
			@$userSex = $_POST['sex'];

			//$url="login.php";
			$url="https://mp.weixin.qq.com/s/swmv5PjxxrAQOFF7Tj4kOw";
			
		if(isset($_POST['reg'])){
		
			/*添加数据需要先连接并选数据库，包含conn.inc.php文件连接数据库*/
			include"common.php";
			mysqli_query($link,"set names 'utf8'");
			$sql_2="SELECT * FROM userInfor WHERE phone = '$user_phone'";
			/*校验手机号， 如果存在则说明已经注册， 手机号重复（比如换号）的几率很小*/
			
			
			$result_2=mysqli_query($link,$sql_2);
		//	$rows=mysql_fetch_array($result_2);
		    $rows=mysqli_num_rows($result_2);
   			mysqli_free_result($result_2);
	
			if($rows>0){
				echo "<script type='text/javascript'>alert('注册失败：该手机号码已存在');location='javascript:history.back()';</script>"; 

			}else{
				
				// echo "new user , prearing insert";
				
				/*根据用户通过POST提交的数据组合插入数据库的SQL语句*/
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
						$url = "regWenjuan.html" ;
						echo "<meta http-equiv='Refresh' content='0;URL=$url'>";
					}else{
						echo "失败";
						echo mysqli_error($link); 
					}
					
				
				mysqli_free_result($result_id);
				}
			}
			
		}	
?>
