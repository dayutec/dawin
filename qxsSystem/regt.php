<?php 

require_once 'weAPI.php';
$ai = new weAPI();
$openid = $ai->getOpenidApi();

?>

<html>
<head>
    <meta charset="utf-8">

    <title>栖霞寺义工信息登记</title>
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<style type="text/css"> 
.container { margin:0auto; width:device-width/*620px*/; }

fieldset {padding:18px; background-color:#F8F8FF;}
fieldset legend {
font-size: larger;
border:1px darkgray solid;
padding:10px;
background-color: white;
}
input[type="text"],
input[type="telephone"],
input[type="password"],
input[type="date"],
textarea {
display: block;
width:96%;
padding:2%;
margin:0020px0;
border:1px solid silver;/*为输入控件添加border，使之与label对齐*/
border-top: none;
font-size:20px;
}
textarea {
resize: none;/*不允许调整textarea的大小，但IE浏览器本身就不支持调整textarea的大小*/
}
label {
display: block;
width:93%;
padding:1%;
font-size:20px;
background-color: cornflowerblue; /* 橙色 #FE6714 */
color: aliceblue;
border:1px solid slategray;/*为label元素添加border元素使之与输入控件对齐*/
}
/*input[type="reset"], input[type="submit"]{
margin:10px30px;
background-color: darkorange;
color: white;
padding:5px;
height:45px;
width:80px;
border:0;
}
input[type="reset"], input[type="submit"]:hover {
cursor: pointer;
border-color: royalblue;
}
input[type="reset"], input[type="submit"]:active {
cursor: pointer;
border-color: black;
outline-color: cornflowerblue;

*/
}
</style> 	
</style> 	
</head>
<body>
<p style="vertical-align: middle;">信息登记共两个页面，因为平台原因部分信息会重复收集，敬请谅解！</p>
<p><p><p>
<div id="content" class="container" >
   
    <!--section width=360 style="text-align: center"><p-->
        
		   <form method="post" action="reg_yigong.php" name="myform" class="form" >
			<fieldset>
				<label>微信用户名</label>				   
				<input id="username" require type="text" name="username" placeholder="请输入至少2位的网络用名"/>
				<br/>
                <!--   网络密码 和 // 真实姓名 暂时不录入  ， 在问卷星里面录入 
				<label>网络密码</label>		
                <input id="pass" type="password" required name="pass" placeholder="密码必须大于4位"/><br/>
				-->
				<label>真实姓名</label>	
                <input id="shi_name" type="text" class="required" name="shi_name" placeholder="法名或者真实姓名" pattern="^([\u4e00-\u9fa5]+|([a-z]+\s?)+)$" /><br>
				
				<label>手机号码</label>
                <input id="user_phone" required type="telephone" name="user_phone" placeholder="手机号码" pattern="^1\d{10}$|^(0\d{2,3}-?|\(0\d{2,3}\))?[1-9]\d{4,7}(-\d{1,8})?$" class="required"/><br>
		
				<label>出生日期</label>
				<input id="dateBirth" type="date" class="required" name="dateBirth" /><br>
		
				<!-- 
				<label>性别</label>
				<select name ='sex' style="font-size:20px">
				<option>请选择性别</option>
				<option value = "1">男</option>
				<option value = "2">女</option>
				</select><br>
				<br>
				-->
				<label for="openid">此项不填</label>			
				<input id="openid" type="text"  style="font-size:14px" readonly="readonly" name="openid" value='<?php echo $openid;?>'>		
				</fieldset>
				<div style="text-align: center">
				<button style="width:80%; height:32px; border-radius: 15px;background-color:cornflowerblue; 
				        border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:24px; " type="submit" name="reg" value="提交">下一页</button> 
				</div>
			</form> 	
	<!--/section-->
	
	
    <footer style="text-align: center"><em>Designed by YY.</em></footer>
    </div>
</body>
</html>
