<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once("../tools/DB.php");


$action = $_POST['action'];
if($action=="add"){
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
        $sql = "insert into tz(title, postdate,top,content) values ('$Title','$PostTime',$top,'$Content');";
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
        $sql = "update tz set title='$Title', postdate='$PostTime',top=$top,content='$Content' where id=$id;";
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
    $sql = "delete from tz where id = $id;";
    $db->query($sql);
    $db->close();
}
else if($action=="edi"){
    $id = $_POST['id'];
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select id,title,content,top from tz where id = $id;";
    $db->query($sql);
    $db->close();
}
else if($action=="qry"){
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select id,title from tz order by postdate desc;";
    $db->query($sql);
    $db->close();
}

?>