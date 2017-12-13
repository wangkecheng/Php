<?php
    @$keyid = $_GET['keyId'];
    if(empty($keyid)){
        $keyid = $_POST['keyId'];
    }
    if(empty($keyid)){
        @$arr = array();
        $arr["msg"]="用户唯一标识为空";
        $arr["code"]=403;
        exit(json_encode($arr,true));
    }
    @$userName = $_GET['userName'];//姓名 也就是电话
    if(empty($userName)){
        $userName = $_POST['userName'];
    }
    @$nickName = $_GET['nickName'];//昵称
    if(empty($nickName)){
        $nickName = $_POST['nickName'];
    }
    @$address = $_GET['address'];//地址
    if(empty($address)){
        $address = $_POST['address'];
    }
    @$headImg = $_GET['headImg'];//头像
    if(empty($headImg)){
        $headImg = $_POST['headImg'];
    }
    @$partment=$_GET['partment'];//部门
    if(empty($partment)){
        $partMent = $_POST['partment'];
    }
    @$position=$_GET['position'];//职位
    if(empty($position)){
        $position = $_POST['position'];
    }
    //先查找一下本地是否存在该用户
    @$conn = mysql_connect("localhost","root","");
    @$myCon = mysql_select_db("warron",$conn);
    @$sql = "SELECT *FROM UserInfo WHERE keyid = "."'$userName'";
    @$result = mysql_query($sql);
    if($result == 0){
        @$arr = array();
        $arr["msg"]="未知错误,请联系服务人员";
        $arr["code"]=403;
        exit(json_encode($arr,true));
    }
    
//    @$row = mysql_fetch_row($result);//取出本条数据,现在要插入了
    @$sqlUserName;
    if(!empty($userName)){
        $sqlUserName = "userName = "."'$userName'".  ",";
    }
    $sqlNickName;
    if(!empty($nickName)){
        $sqlNickName = "nickName = "."'$nickName'".",";
    }
    $sqlAddress;
    if(!empty($address)){
        $sqlAddress = "address = "."'$address'".",";
    }
    $sqlHeadImg;
    if(!empty($headImg)){
        $sqlHeadImg = "headImg = "."'$headImg'".",";
    }
    $sqlPartment;
    if(!empty($partment)){
        $sqlPartment = "partment = "."'$partment'".",";
    }
    $sqlPosition;
    if(!empty($position)){
        $sqlPosition = "position = ". "'$position'"   .",";
    }
    @$updateSql = "UPDATE UserInfo SET ".    "$sqlUserName".  "$sqlNickName".  "$sqlAddress".   "$sqlHeadImg".  "$sqlPartment".  "$sqlPosition";
    $updateSql = substr($updateSql, 0, -1);//删除最后一个字符 ","
    $updateSql = $updateSql."where keyId = ". "'$keyid';";//拼接匹配语句
    @$updateResult = mysql_query($updateSql); 
    if($updateResult==1){
        @$a = array();
        $a["msg"]="设置用户信息成功";
        $a["code"]=200;
        $a["updateSql"]=$updateSql;
        exit(json_encode($a,true));
    }
    else{
        @$a = array();
        $a["msg"]="设置失败了";
        $a["code"]=403;
        exit(json_encode($a,true));
    }
    ?>
