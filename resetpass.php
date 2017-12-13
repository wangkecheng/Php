<?php
    @$userName = $_GET["userName"];
    if(empty($userName)){
        $userName = $_POST["userName"];
    }
    if(empty($userName)){
        @$a=array();
        $a["msg"]="请输入用户名";
        $a["code"]=401;
        exit(json_encode($a,true));
    }
    
    @$vertifycode = $_GET["vertifyCode"];
    if(empty($vertifycode)){
        $vertifycode = $_POST["vertifyCode"];
    }
    if(empty($vertifycode)){
        @$a=array();
        $a["msg"]="请输入验证码";
        $a["code"]=402;
        exit(json_encode($a,true));
    }
    
    @$passWord=$_GET["password"];
    if(empty($passWord)){
        $passWord = $_POST["password"];
    }
    if(empty($passWord)){
        @$a=array();
        $a["msg"]="请输入密码";
        $a["code"]=403;
        exit(json_encode($a,true));
    }
    @$vertifyPass=$_GET["vertifyPass"];
    if(empty($vertifyPass)){
        $vertifyPass=$_POST["vertifyPass"];
    }
    if(empty($vertifyPass)){
        @$a=array();
        $a["msg"]="请确认密码";
        $a["code"]=404;
        exit(json_encode($a,true));
    }
    if($vertifyPass!==$passWord)  {
        @$a = array();
        $a["msg"]="两次密码不一致";
        $a["code"]=405;
        exit(json_encode($a,true));
    }
    @$con = mysql_connect("localhost","root","");
    @$myCon = mysql_select_db("warron",$con);
    @$select = "Select userName from UserInfo where userName= "."'$userName'";
    @$selectResult=mysql_query($select);
    
    if(mysql_num_rows($selectResult)==1){//存在记录才更新
        
        @$updateSql = "Update UserInfo Set password=" ."'$passWord' where userName ="."'$userName'";
        @$result = mysql_query($updateSql);
        
        
        if($result==1){
            @$a = array();
            $a["msg"]="设置成功,请牢记您的密码";
            $a["code"]=200;
            exit(json_encode($a,true));
        }
        else{
            @$a = array();
            $a["msg"]="设置失败了";
            $a["code"]=403;
            exit(json_encode($a,true));
        }
    }else{
        @$a = array();
        $a["msg"]="该用户不存在,请注册";
        $a["code"]=403;
        exit(json_encode($a,true));
    }
    
    ?>


