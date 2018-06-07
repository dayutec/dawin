<?php 
header('Content-type:text/html;charset=utf-8');

require_once 'weAPI.php';

	$today=date("Y-m-d");
	echo "今天是 " . $today . "<br>";

	$mon=date("n");//m 01 ,n 1
	$day=date("j");//d 01,j 1
	//echo "今天是 " . $mon . $day. "<br>";
	//SQL 获取今天的寿星数量
	include"common.php";
	mysqli_query($link, "set character set 'utf8'");//读库 
	//mysqli_query($link,"set names 'utf8'");//写库
	$sql_checkdata = "select * from userInfor where month(birthdate)= '$mon' and day(birthdate)='$day'"; 
	$result=mysqli_query($link,$sql_checkdata);	
	$rows=mysqli_num_rows($result);
   		
	if($rows>0){
		echo "number of people is ".$rows."<br>"; 
		//如果今天有生日吉人就送上祝福,否则什么也不做.		
		$ai = new weAPI();		
		$keys = $ai->get_basic_token();	
		
		while($row=mysqli_fetch_row($result)){
			$openid = $row[2];
			$name = $row[3];
			$ret = $ai->send_user_message($keys,$openid,$name);
		}
	}else
	{
		echo "number of people is ".$rows."<br>";
	}
	mysqli_free_result($result);

//$res = $ai->send_message("123");
//$openid = 'oLXNo0tBkOteRdvwY556EyBWAcF0';


//$ret = $ai->send_user_message($keys,$openid,"123");




//$run = include 'birth_config_timer.php';
	
//	if($run){
		
		//$time=600; //8*60*60;
	   // sleep($time);
	
		//$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		//file_get_contents($url);
		
	//	$baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);
		//$url = $this->__CreateOauthUrlForCode($baseUrl);
	//	Header("Location: $url");
//		exit();
		
		
//	}
	mysqli_close($link);//关闭连接
?>