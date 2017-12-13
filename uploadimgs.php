<?php
    // 9. 接收用户头像图片
    // 9.1. 接收图片传到服务器上默认的临时文件路径以及名字 (uploadfile 给前台使用的字段
    @$keyid =  $_GET['keyId'];
    if(empty($keyid)){
        $keyid=$_POST['keyId'];
    }
    if(empty($keyid)){
        @$a=array();
        $a["msg"]="请上传用户唯一表示keyId";
        $a["code"]=403;
        exit(json_encode($a,true));
    }
  
    @$destination_folder = $_SERVER["DOCUMENT_ROOT"]."/imgsFile/";//获取根路径下的downloads文件夹下的路径
    if(!file_exists($destination_folder)){
        mkdir("$destination_folder", 0700);//检查是否有该文件夹，如果没有就创建，并给予最高权限 linux创建文件夹给最高权限有时候会出错
    }
    $tp = array("image/gif","image/jpeg","image/jpg","image/png","application/octet-stream"); //允许上传的文件格式
     $index = 0;
     @$resultArr=array();
     $resultArr["data"] = array();
     @$flag = 0;
   
    foreach($_FILES as $key=>$value){
        
        if(in_array($value['type'],$tp)){//检查上传文件是否是允许上传的类型
            @$fileExtension="";
            switch($value['type']){
                case "image/gif":$fileExtension = "gif";break;
                case "image/jpeg":$fileExtension = "jpeg";break;
                case "image/jpg":$fileExtension = "jpg";break;
                case "image/png":$fileExtension = "png";break;
                case "application/octet-stream":$fileExtension = "jpg";break;
            }
            $name = $destination_folder.time().'_'.$index.'_'.$value["name"].'_'.$keyid.".".$fileExtension;
            $resultArr["name"] = $name;
            @$result = move_uploaded_file($value["tmp_name"], $name); //将上传的文件移动到新位置
            if($result){
                $flag=1;
                @$msgT = $resultArr["msg"]==''?"上传成功":$resultArr["msg"];
                $resultArr["msg"]=$msgT;
                $resultArr["file"]=$_FILES;
                $resultArr["code"]=200;
                @$url=array("url"=>$name);
                array_push($resultArr["data"],$url);
            } else {
                     $resultArr["code"]=403;//上传失败
                if($flag==1){
                     $resultArr["code"]=200;//如果之前存在上传成功的图片，那么要显示上传成功
                     $resultArr["msg"]=$resultArr["msg"]."第".$index."张图片上传失败";//增加一条提示信息
                }
            }
        }else{
            @$warring= "warning".$resultArr["msg"];//添加一条提示信息提示图片格式不对
            @$type=$value['type'];
            $resultArr["msg"]=$warring." 第".$index."张图片的格式"."'$type'"."不对";
        }
        $index += 1;
    }
    exit(json_encode($resultArr,true));
    ?>
