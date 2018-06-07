<?php
header("Content-Type:text/html;charset=utf-8");

/*
$string = strrev($_FILES['file']['name']);
$array = explode('.',$string);
echo $array[0]."<br/>";
echo $_FILES["file"]["name"]."<br/>";
echo $_FILES["file"]["type"]."<br/>";
echo "excel_file".$imagetype."<br/>";
print_r($_POST)."<br/>";

excel 93-2003后缀为 .xls  的  文件格式是   application/vnd.ms-excel 
excel2007格式后缀是 .xlsx  的文件格式是 application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
*/
$imagetype = $_FILES["file"]["type"];

if($imagetype=='application/vnd.ms-excel' || $imagetype=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
	echo "========================= Upload file information ===============================<br />";
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

	$filePath =  "./upload/".$_FILES["file"]["name"] ;
	echo $filePath ;
   /* if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
	*/
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
    //  }
    }
		echo "<br/>============================================<br/>" ;
		echo "<a href=\"index.html\" class =\"button\"><span><font size=5 color=blue>返回主页</font></span></a>";
		echo "<br/>============================================<br/>" ;
	
	require_once("excel2db.php");
	
		
  }
else
  {

  echo "Invalid file ,  jump to main page after 3s;" ;
  $url = "upload_excel.html" ;
  echo "<meta http-equiv='Refresh' content='3;URL=$url'>";
 // header("refresh:3;url=$url");
  //exit();
  }
  

 
  

  //被调用的文件如果不存在会报错，脚本中断。
//被调用文件在当前脚本中可重复执行。
//require(文件路径);
/*========================*/
//被调用的文件如果不存在会报错，脚本中断。
//被调用文件在当前脚本中仅执行一次。
//require_once(文件路径);
/*========================*/
//被调用的文件如果不存在不会报错，脚本继续。
//被调用文件在当前脚本中可重复执行。
//include(文件路径);
/*========================*/
//被调用的文件如果不存在不会报错，脚本继续。
//被调用文件在当前脚本中仅执行一次。
//include_once(文件路径);
//这4个函数均可引用PHP文件。

/** 
 * Detect upload file type 
 * 检测上传文件的excel文件类型
 * @param array $file            
 * @return bool $flag
 * @site www.jbxue.com
 */ 
/* 
function detectUploadFileMIME($file) {  
    // 1.through the file extension judgement 03 or 07  
    $flag = 0;  
    $file_array = explode ( ".", $file ["name"] );  
    $file_extension = strtolower ( array_pop ( $file_array ) );  
      
    // 2.through the binary content to detect the file  
    switch ($file_extension) {  
        case "xls" :  
            // 2003 excel  
            $fh = fopen ( $file ["tmp_name"], "rb" );  
            $bin = fread ( $fh, 8 );  
            fclose ( $fh );  
            $strinfo = @unpack ( "C8chars", $bin );  
            $typecode = "";  
            foreach ( $strinfo as $num ) {  
                $typecode .= dechex ( $num );  
            }  
            if ($typecode == "d0cf11e0a1b11ae1") {  
                $flag = 1;  
            }  
            break;  
        case "xlsx" :  
            // 2007 excel  
            $fh = fopen ( $file ["tmp_name"], "rb" );  
            $bin = fread ( $fh, 4 );  
            fclose ( $fh );  
            $strinfo = @unpack ( "C4chars", $bin );  
            $typecode = "";  
            foreach ( $strinfo as $num ) {  
                $typecode .= dechex ( $num );  
            }  
            echo $typecode;  
            if ($typecode == "504b34") {  
                $flag = 1;  
            }  
            break;  
    }  
      
    // 3.return the flag  
    return $flag;  
}   */
?>