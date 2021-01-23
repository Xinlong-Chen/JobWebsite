<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once("../tools/DB.php");

//status为招聘信息的状态 0-审核通过 1-正在审核 2-审核不通过
$action = $_POST['action'];
if($action=="adminadd"){
//    $id = $_POST['id'];
//    if()
    if(empty($_POST['id'])) {
        $Title = $_POST['InputTitle'];
        $Content = $_POST['markdown_textarea'];
        $top = $_POST['InputTop'];
//    echo $top;
        $PostTime = date('Y-m-d', time());

        $db = new MySQL_DB();
        $db->connect();
        $sql = "insert into zp(title, postdate,top,content,status) values ('$Title','$PostTime',$top,'$Content',0);";
        echo $sql . "\n";
        if ($db->insert($sql) == 0) {
            echo "Success";
        } else {
            echo "Error";
        }

        $db->close();
    }
    else{
        $id = $_POST['id'];
        $Title = $_POST['InputTitle'];
        $Content = $_POST['markdown_textarea'];
        $top = $_POST['InputTop'];
//    echo $top;
        $PostTime = date('Y-m-d', time());

        $db = new MySQL_DB();
        $db->connect();
        $sql = "update zp set title='$Title', postdate='$PostTime',top=$top,content='$Content',status=0 where id=$id;";
        echo $sql . "\n";
        $result=$db->update($sql);
        if($result==0){
            echo "Success！";
        }
        else {
            echo "异常！";
        }
    }
}
else if ($action=="del"){
    $id = $_POST['id'];
    $db = new MySQL_DB();
    $db->connect();
    $sql = "delete from zp where id = $id;";
    $db->query($sql);
    $db->close();
}
else if($action=="edi"){
    $id = $_POST['id'];
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select id,title,content,top from zp where id = $id;";
    $db->query($sql);
    $db->close();
}
else if($action=="qry"){
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select id,title from zp where status=0 order by postdate  desc;";
    $db->query($sql);
    $db->close();
}
else if($action=="qryQyZp"){
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select id,title,status from zp where status in (1,2) order by postdate  desc;";
    $db->query($sql);
    $db->close();
}
//企业增加数据
else if($action=="qyadd"){
//    $id = $_POST['id'];
//    if()
    if(empty($_POST['id'])) {
        $Title = $_POST['InputTitle'];
        $Content = $_POST['markdown_textarea'];
        $top = $_POST['InputTop'];
//    echo $top;
        $PostTime = date('Y-m-d', time());

        $db = new MySQL_DB();
        $db->connect();
        $sql = "insert into zp(title, postdate,top,content,status) values ('$Title','$PostTime',$top,'$Content',1);";
        echo $sql . "\n";
        if ($db->insert($sql) == 0) {
            echo "Success";
        } else {
            echo "Error";
        }

        $db->close();
    }
    else{
        $id = $_POST['id'];
        $Title = $_POST['InputTitle'];
        $Content = $_POST['markdown_textarea'];
        $top = $_POST['InputTop'];
//    echo $top;
        $PostTime = date('Y-m-d', time());

        $db = new MySQL_DB();
        $db->connect();
        $sql = "update zp set title='$Title', postdate='$PostTime',top=$top,content='$Content' where id=$id;";
        echo $sql . "\n";
        $result=$db->update($sql);
        if($result==0){
            echo "Success！";
        }
        else {
            echo "异常！";
        }
    }
}
else if($action=="unpass"){
    $id = $_POST['id'];
    $db = new MySQL_DB();
    $db->connect();

    $sql = "update zp set status=2 where id=$id";
    $db->update($sql);

    $db->close();
}
?>