<?php
header('Content-type:text/html;charset=utf-8');

require_once 'weAPI.php';
$ai = new weAPI();
$user_id = $ai->getOpenidApi();

//功能：计算两个时间戳之间相差的日时分秒
//$begin_time  开始时间戳
//$end_time 结束时间戳
function timediff($begin_time,$end_time)
{
      if($begin_time < $end_time){
         $starttime = $begin_time;
         $endtime = $end_time;
      }else{
         $starttime = $end_time;
         $endtime = $begin_time;
      }
	//  echo  $starttime." starttime <br/>" ;
	//  echo  $endtime." endtime <br/>" ;
      //计算天数
      $timediff = $endtime-$starttime;
      $days = intval($timediff/86400);
	//  echo  $timediff." timediff <br/>" ;
	//  echo  $days." days <br/>" ;
      //计算小时数
      $remain = $timediff%86400;
      $hours = intval($remain/3600);
      //计算分钟数
      $remain = $remain%3600;
      $mins = intval($remain/60);
	//  echo  $mins." mins <br/>" ;
      //计算秒数
      $secs = $remain%60;
	//  echo  $secs." secs <br/>" ;
      $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
      return $res;
}


//功能：计算两个时间戳之间相差的日时分秒
//$begin_time  开始时间戳
//$end_time 结束时间戳
function daydiff($begin_time,$end_time)
{
      if($begin_time < $end_time){
         $starttime = date('Y-m-d' ,$begin_time);
         $endtime = date('Y-m-d' ,$end_time);
      }else{
         $starttime = date('Y-m-d' ,$end_time);
         $endtime = date('Y-m-d' ,$begin_time);
      }
	  // 截取日期部分，摒弃时分秒
	  $s = substr($starttime,0,10);
	//  echo  $s." secs <br/>" ;
	  $e = substr($endtime,0,10);
	//  echo  $e." secs <br/>" ;
	  
	  if($s==$e){
		  $res = 0 ;
		}else{
		//  $timediff = $endtime-$starttime;
		//  $res = intval($timediff/86400);
		$res = 99999 ;
		}
	  
     // $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
      return $res;
}



/*添加数据需要先连接并选数据库，包含conn.inc.php文件连接数据库*/
			include"common.php";
			mysqli_query($link,"set names 'utf8'");

//检查签到表里是否有该用户  有的话则更新数据  没有的话则插入数据
$q = "SELECT * FROM userInfor WHERE openid= '$user_id' "; //SQL插入语句
        mysqli_query($link,"SET NAMES utf8");

        $rs = mysqli_query($link,$q); //获取数据集
        if(!$rs){
                exit(json_encode(array('status'=>"Get ID ",'code'=>"1",'error'=>mysqli_error($link))));
        }
        
        if(mysqli_num_rows($rs)){//该用户有数据 则更新其签到信息
            $last_time="";
            $total_day="";
			$total_score="";
             while($row = mysqli_fetch_row($rs)) {
			$user_shi_name=$row[3];
			$total_score=$row[7];
            $last_time=$row[8];
            $total_day=$row[9];
        }
            //根据上次签到时间和这次签到时间作比较判断有没有漏签和今日是否已签到
		//	echo $last_time."<br/>";
            $current_total_day=intval($total_day)+1;
            $current_day  = time();
			$current_date = date('Y-m-d H:i:s',time());
			$last_day = strtotime($last_time);
			/*
			echo $last_day ."<br/>";
			echo $current_day."<br/>" ;
			*/
            $ary = daydiff($last_day,$current_day);
			/*
			echo  $ary[day]." day <br/>" ;
			echo  $ary[hour]." hour <br/>" ;
			echo  $ary[min]." mins<br/>";
			echo  $ary[sec]." secs<br/>"   ;
			*/
        if($ary==0){//今天已签到
		    
			 echo '<p style="font-size:24pt;color:red;text-align:center">今天已签到,点击左上角X返回<p>';
             //exit(json_encode(array('status'=>"success",'code'=>"2")));
             mysqli_close($link);//关闭连接    
             
        }else {//今天没有签
		
			$total_score = $total_score + 3 ;
			
            $usdateq = "UPDATE userInfor SET total_score = '$total_score' , last_sign_time='$current_date', total_day='$current_total_day' WHERE openid= '$user_id'"; //更新
            mysqli_query($link,"SET NAMES utf8");
            $ustaters = mysqli_query($link,$usdateq); //获取数据集
            if($ustaters ==1){
				
                //exit(json_encode(array('status'=>"Success",'code'=>"3")));
				//echo "签到成功!!!!";
				echo '<p style="font-size:24pt;color:red;text-align:center">签到成功!!!!<p>';
			}else{
                exit(json_encode(array('status'=>"Failed",'code'=>"4")));

            }
			mysqli_close($link);//关闭连接
            

        }
		
		//显示签到天数和积分
		echo '<p style="font-size:24pt;color:red;text-align:center">欢迎： '.$user_shi_name.' 师兄，您的<p>';
		

		echo '<p style="font-size:24pt;color:red;text-align:center">签到总积分为 ： '.$total_score.'<p>';
		echo '<p>';
		echo '<p style="font-size:24pt;color:red;text-align:center">签到总天数为 ：'.$total_day.'<p>';
		echo '<p>';
		echo '<p style="font-size:24pt;color:red;text-align:center">上次签到时间 ：'.$last_time.'<p>';

		exit();
    }else{//没有该用户记录
	
	    echo '<p style="font-size:24pt;color:red;text-align:center">当前用户没有注册，请先登记<p>';
      
    }

 

        mysqli_close($link);//关闭连接


?>