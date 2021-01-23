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
        $sql = "insert into dxzph(title, postdate,top,content) values ('$Title','$PostTime',$top,'$Content');";
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
        $sql = "update dxzph set title='$Title', postdate='$PostTime',top=$top,content='$Content' where id=$id;";
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
    $sql = "delete from dxzph where id = $id;";
    $db->query($sql);
    $db->close();
}
else if($action=="edi"){
    $id = $_POST['id'];
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select id,title,content,top from dxzph where id = $id;";
    $db->query($sql);
    $db->close();
}
else if($action=="qry"){
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select id,title from dxzph order by postdate desc;";
    $db->query($sql);
    $db->close();
}
else if($action=="sendemail"){
    $id = $_POST['id'];

    $db = new MySQL_DB();
    $db->connect();
    $sql = "select title from dxzph where id=$id;";
    $row = $db->getMaxId($sql);
    $title = $row['title'];

    $sql = "select email from user where rid=3;";
    $vector = $db->getVector($sql,'email');
    $length = count($vector);
    $body = "<p>贵司：</p>".
        "<p>我校将举办主题为\""
        .$title.
        "\"的大型招聘会，如你司想要参加，可登录我校就业网报名</p>".
        "<p style='float: right;'>哈尔滨理工大学就业处    ".date('Y-m-d')."</p>";
    echo $body;
    include_once ("../tools/Mail/sendmail.php");
    sendmany($vector,$title,$body);
    $db->close();
}

?>