<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once("tools/DB.php");
$title = "test";

$db = new MySQL_DB();
$db->connect();
$sql = "insert into wj(title) values ('$title');";
//插入一个问卷
if($db->insert($sql)==0){
    //插入一个问题
    $sql = "select max(id) id from wj";
    $row = $db->getMaxId($sql);
    $id = $row['id'];
    $problem="question1";
    $sql = "insert into wt(id, problem) values ($id,'$problem'); ";
    if($db->insert($sql)==0){
        //插入一个选项
        $sql = "select max(wtid) wtid from wt";
        $row = $db->getMaxId($sql);
        $wtid = $row['wtid'];

        $ans="1";
        $sql = "insert into da(wtid, ans) values ($wtid,'$ans');";
        $db->insert($sql);

        $ans="2";
        $sql = "insert into da(wtid, ans) values ($wtid,'$ans');";
        $db->insert($sql);

        $ans="3";
        $sql = "insert into da(wtid, ans) values ($wtid,'$ans');";
        $db->insert($sql);

        $ans="4";
        $sql = "insert into da(wtid, ans) values ($wtid,'$ans');";
        $db->insert($sql);
    }

    $problem="question2";
    $sql = "insert into wt(id, problem) values ($id,'$problem'); ";
    if($db->insert($sql)==0){
        //插入一个选项
        $sql = "select max(wtid) wtid from wt";
        $row = $db->getMaxId($sql);
        $wtid = $row['wtid'];

        $ans="1";
        $sql = "insert into da(wtid, ans) values ($wtid,'$ans');";
        $db->insert($sql);

        $ans="2";
        $sql = "insert into da(wtid, ans) values ($wtid,'$ans');";
        $db->insert($sql);

        $ans="3";
        $sql = "insert into da(wtid, ans) values ($wtid,'$ans');";
        $db->insert($sql);

        $ans="4";
        $sql = "insert into da(wtid, ans) values ($wtid,'$ans');";
        $db->insert($sql);
    }
}

$db->close();


?>
