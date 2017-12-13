<?php
// 1. 获取GET网络请求网址里的key值对应的value
// 声明变量name1 和pass1 接收
  @$userName = $_GET['userName'];
     if(empty($userName)){
      $userName = $_POST['userName'];
     }
    if(empty($userName)){
        @$a = array();
        $a["msg"]="请输入姓名";
        $a["code"]=403;
        exit(json_encode($a,false));
    }
  @$passWord = $_GET['password'];
    if(empty($passWord)){
        $passWord = $_POST['password'];
    }
    if(empty($passWord)){
        @$a = array();
        $a["msg"]="请输入密码";
        $a["code"]=403;
        exit(json_encode($a,false));
    }
// 2. 建立数据库连接
// 参数1: 数据库所在的服务器的地址(本机127.0.0.1或者localhost)
// 参数2: MySql数据库的账户(默认root)
// 参数3: MySql数据库的密码(默认无)
    $con = mysql_connect("localhost", "root", "");
// 参数1: 自己建立的数据库的名字
    $myCon = mysql_select_db("warron", $con);
   
   // 3. 执行查询 利用用户名和密码进行匹配查找
    $sql = "SELECT * FROM UserInfo WHERE userName = "." '$userName'". " and password= "."'$passWord'";
   // 4. 接收结果
    @$result = mysql_query($sql);
// 4.2 如果查询结果为空的话
    if($result == 0) {
        @$a = array();
        $a['msg']='该账号尚未注册';
        $a['code']=403;
        echo json_encode($a);
    }
    else {
            @$row = mysql_fetch_row($result);//5. 取出本条记录
        if($row[1] !== $passWord){
            @$a = array();
            $a['msg']='密码错误';
            $a['code']=403;
            exit (json_encode($a));
        }else{
            @$a = array();
            $a['msg']='登录成功';
            $a['code']=200;
            $a['data']['userName'] = $row[0];
            $a['data']['password'] = $row[1];
            $a['data']['age'] = $row[2];
            $a['data']['keyid'] = $row[3];
            $a['data']['headImg'] = $row[4];
            $arr = json_encode($a,false);
            echo $arr;
        }
    }
 ?>
