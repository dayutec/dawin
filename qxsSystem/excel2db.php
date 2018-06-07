<?php
header("Content-Type:text/html;charset=utf-8");
require_once './ClassLibrary/PHPExcel-1.8/Classes/PHPExcel.php';

/**对excel里的日期进行格式转化*/
function GetData($val){
$jd = GregorianToJD(1, 1, 1970);
$gregorian = JDToGregorian($jd+intval($val)-25569);
return $gregorian;/**显示格式为 “月/日/年” */
}





if (!isset($filePath)){
	$filePath = './excelFiles/3_3_2.xls';
}
echo "<br/>===================update file  ".$filePath."  to database===================<br/>";
$PHPExcel = new PHPExcel();

/**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/
$PHPReader = new PHPExcel_Reader_Excel2007();
if(!$PHPReader->canRead($filePath)){
$PHPReader = new PHPExcel_Reader_Excel5();
if(!$PHPReader->canRead($filePath)){
echo 'no Excel';
return ;
}
}

$PHPExcel = $PHPReader->load($filePath);
/**读取excel文件中的第一个工作表*/
$currentSheet = $PHPExcel->getSheet(0);
/**取得最大的列号*/
$allColumn = $currentSheet->getHighestColumn();

//var_dump($allColumn);
//var_dump(ord($allColumn));

$highestColumnNum = PHPExcel_Cell::columnIndexFromString($allColumn);
$usefullColumnNum = $highestColumnNum;
//var_dump($usefullColumnNum);

/**取得一共有多少行*/
$allRow = $currentSheet->getHighestRow();
//var_dump($allRow);

//------解决方案--------------------
//for($i='A'; $i!='AP'; $i++) echo $i;

//ABCDEFGHIJKLMNOPQRSTUVWXYZAAABACADAEAFAGAHAIAJAKALAMANAO

echo "</br>";

// PHPExcel循环读取excel,列数超过z,比较出有关问题 ,var_dump('B'<'AP') ;  结果是 bool(false)


//=============alter3.1================= 加一是为了提高 后面for 循环使用！= 的下标  
//++$allColumn; 




//			 read phone number 
include"common.php";
mysqli_query($link,"set names 'utf8'");

//检查签到表里是否有该用户的phone 信息，  没有的话则插入数据

	$sql_checkdata = "SELECT COUNT(Phone) FROM `userDetail`"; 
	$result = mysqli_query($link,$sql_checkdata);	
	//$rows =  mysqli_num_rows($result);
	$row =  mysqli_fetch_row($result);
//	echo $row ;
	$numOfExistRecord = $row[0];
	echo "Num of existed Record is :".$numOfExistRecord." allRows in Excel file is ".($allRow-1)." <br/> ";
	if($allRow -1 >$numOfExistRecord){
		echo "Number of records need to be updated :".($allRow - $numOfExistRecord -1)."<br>"; 
	
	
	//Start from new record
	for($currentRow = $numOfExistRecord+2;$currentRow <= $allRow;$currentRow++){
	/**从第二行开始输出，因为excel表中第一行为列名*/ 
	//for($currentRow = 2;$currentRow <= $allRow;$currentRow++){

		$currentColumn= 'G' ;
		$address=$currentColumn.$currentRow;
		$Name=$currentSheet->getCell($address)->getValue();
		echo $Name."</br>";

		//get Phone
		$currentColumn= 'H' ;
		$address=$currentColumn.$currentRow;
		$Phone=$currentSheet->getCell($address)->getValue();
		echo $Phone."</br>";
		
		$currentColumn= 'W' ;
		$address=$currentColumn.$currentRow;
		$mon=$currentSheet->getCell($address)->getValue();
		$currentColumn= 'X' ;
		$address=$currentColumn.$currentRow;
		$tue=$currentSheet->getCell($address)->getValue();
		$currentColumn= 'Y' ;
		$address=$currentColumn.$currentRow;
		$wen=$currentSheet->getCell($address)->getValue();
		$currentColumn= 'Z' ;
		$address=$currentColumn.$currentRow;
		$thu=$currentSheet->getCell($address)->getValue();
		$currentColumn= 'AA' ;
		$address=$currentColumn.$currentRow;
		$frd=$currentSheet->getCell($address)->getValue();
		$currentColumn= 'AB' ;
		$address=$currentColumn.$currentRow;
		$sat=$currentSheet->getCell($address)->getValue();
		$currentColumn= 'AC' ;
		$address=$currentColumn.$currentRow;
		$sun=$currentSheet->getCell($address)->getValue();
		$currentColumn= 'AD' ;
		$address=$currentColumn.$currentRow;
		$pub=$currentSheet->getCell($address)->getValue();
		
		$currentColumn= 'P' ;
		$address=$currentColumn.$currentRow;
		$career = $currentSheet->getCell($address)->getValue();
		
	//	echo $mon." ".$tue." ".$wen." ".$thu." ".$frd." ".$sat." ".$sun." ".$pub."  ".$career." </br>";
		
		for($currentColumn= 'AM';$currentColumn != 'BA' ; $currentColumn++){
		//$val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();/**ord()将字符转为十进制数*/
		$address=$currentColumn.$currentRow;  
				//读取到的数据，保存到数组$arr中  
		$val=$currentSheet->getCell($address)->getValue(); 
		//echo $val." ";
		$services[] = $val;		
		}
		
		$services = implode(",",$services);
	//	echo $services."</br>";
		
		for($currentColumn= 'BA';$currentColumn != 'BO' ; $currentColumn++){
		//$val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();/**ord()将字符转为十进制数*/
		$address=$currentColumn.$currentRow;  
				//读取到的数据，保存到数组$arr中  
		$val=$currentSheet->getCell($address)->getValue(); 
		//echo $val." ";
		$skills[] = $val;	
			
		}
	//	echo "</br>";
		$skills = implode(",",$skills);
		echo $skills."</br>";
	   //查询skills 的语句
	//   SELECT * FROM `userDetail` WHERE `skills` LIKE '_,_,_,_,1,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_' ;

	//SELECT * FROM `userDetail` WHERE `skills` LIKE '_,_,_,_,1,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_' 
	//                              or `skills` LIKE '_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,1,_'
	//                              or `skills` LIKE '_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,_,1';
	//echo "</br>";
	//SELECT * FROM `userDetail` WHERE substring(skills,7,1)='1' or substring(skills,9,1)='1' ;
		//$sql_insertdata = "UPDATE userDetail SET Phont = '$Phone' , Mon='$mon', Tue='$tue' WHERE openid= '$user_id'"; 
		$sql_insertdata = "INSERT INTO userDetail(name,Phone,Mon,Tue,Wen,Thu,Frd,Sat,Sun,Pubday,career,service,skills) 
						   VALUES ('$Name','$Phone', '$mon', '$tue','$wen','$thu','$frd','$sat','$sun','$pub','$career','$services','$skills') ";
		$result=mysqli_query($link,$sql_insertdata);	
		if($result ==1){
					
			echo '<p style="font-size:12pt;color:red;text-align:center">插入成功!!!!<p>';
		}else{
			echo json_encode(array('status'=>"Failed",'code'=>"4",'error'=>mysqli_error($link)));
			echo "</br>";
		}
		unset($services);
		unset($skills);
	}
}else{
	echo "No need to update database ,as number is :".($allRow - $numOfExistRecord -1)."<br>"; 
}	
	
	mysqli_close($link);//关闭连接
	//exit();
	echo "<br/>===========================End update excel to database=============================================<br/>";
	echo "<br/>============================================<br/>" ;
	echo "<a href=\"index.html\" class =\"button\"><span><font size=5 color=blue>Main page</font></span></a>";
	echo "<br/>============================================<br/>" ;
?>

<!--html>
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width,inital-scale=1.0;">
    <title>上传Excel文件</title>
</head>

<body>

		<h3>更新数据库结束，请返回主页面</h3>  
		<form action="index.html" method="post" enctype="multipart/form-data" >
		<input type="submit" name="submit" value="Main page" />
		</form>
	
	
</body>
</html-->

