<?php // 1. 获取客户端利用post方式网络请求的body里的字段对应的value (这个字段// 是这里规定的, 前端必须遵守这个name2, pass2等key值)
        @$userName = @$_GET['userName'];
        if(empty($userName)){
            $userName = @$_POST['userName'];
        }
        if(empty($userName)){
            @$a = array();
            $a["msg"]="请输入姓名";
            $a["code"]=403;
            exit(json_encode($a,true));
        }
        @$passWord = @$_GET['password'];
        if(empty($passWord)){
            $passWord = @$_POST['password'];
        }
        if(empty($passWord)){
            @$a = array();
            $a["msg"]="请输入密码";
            $a["code"]=403;
            exit(json_encode($a,true));
        }
    
        @$vertifyPass= @$_GET['vertifyPass'];
        if(empty($vertifyPass)){
           $vertifyPass = @$_POST['vertifyPass'];
        }
        if(empty($vertifyPass)){
            @$a = array();
            $a["msg"]="请确认密码";
            $a["code"]=403;
            exit(json_encode($a,true));
        }

        if($vertifyPass!==$passWord)  {
            @$a = array();
            $a["msg"]="两次密码不一致";
            $a["code"]=403;
            exit(json_encode($a,true));
         }
    
    // 2. 建立数据库连接 (127.0.0.1 数据库所在的ip地址)
    // root 是数据库用户名(默认的)  "" 密码(默认是空)
    @$con = mysql_connect("127.0.0.1", "root", "");
    @$myCon = mysql_select_db("warron", $con);
    // 3. 先查询, 如果存在就不要在插入了
    @$select = "select userName from UserInfo where userName = '$userName'";
    @$seleResult = mysql_query($select);
    // 4. 如果查到了, 说明已经存在这个用户了
    if (mysql_num_rows($seleResult)) {
     @$a = array();
     $a['code'] = "403";
     $a['msg'] = "该用户已注册";
     exit(json_encode($a,true));
    }
    // 5. 如果没注册过
    else {
    // 6. 把数据都插入到mysql数据库中
     @$sql = "Insert Into UserInfo values('$userName', '$passWord', '0', '$userName','')";
     @$result = mysql_query($sql);
    
        if ($result == 1) { //代表插入成功
         @$a = array();
         $a['msg'] = "注册成功";
         $a['code'] = "200";
         $sql = "SELECT * FROM UserInfo  WHERE userName = "."'$$userName'";
         $result = mysql_query($sql);//将刚才登录的信息返回回去
        if ($result == 1) { //代表查询成功
         $row=mysql_featch_now($result);//5. 取出本条记录
         $a['data']['userName'] = $row[0];
         $a['data']['password'] = $row[1];
         $a['data']['age'] = $row[2];
         $a['data']['keyid'] = $row[3];
         $a['data']['headImg'] = $row[4];
        }
      echo json_encode($a);
     }
     else { // 8. 代表插入失败
         @$a = array();
         $a['msg'] = "亲，攻城狮正在努力攻城";
         $a['code'] = "403";
         echo json_encode($a);
     }
   }
?>
