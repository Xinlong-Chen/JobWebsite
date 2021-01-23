<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once("../tools/DB.php");

session_start();
$action = $_POST['action'];
//status 0-已接受 1-正在审核 2-拒绝
if($action=="register"){
    $id = $_POST['id'];
    $uid = $_SESSION['uid'];
    $db = new MySQL_DB();
    $db->connect();
    $sql = "insert into registerZPH(userid,zphid,status) values ($uid,$id,1)";
    if($db->insert($sql)==-1) {
        echo "error";
    }
    else{
        echo "success";
    }
    $db->close();
}
else if($action=="qryCanReg"){
    $uid = $_SESSION['uid'];
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select * from dxzph where id not in (select zphid from registerZPH where userid=$uid);";
    $db->query($sql);
    $db->close();
}
else if($action=="qryHaveReg"){
    $uid = $_SESSION['uid'];
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select r.zphid,r.status,title from dxzph,registerZPH r
                where dxzph.id = r.zphid and userid=$uid;";
    $db->query($sql);
    $db->close();
}
else if ($action=="qryAllByZphid"){
    $zphid = $_POST['zphid'];

    $db = new MySQL_DB();
    $db->connect();

    $sql = "select d.id did,u.id uid,r.status,title,u.username 
                from dxzph d,registerZPH r,user u
                where d.id = r.zphid and r.userid=u.id and zphid=$zphid and status in (1)";
    $db->query($sql);

    $db->close();
}
else if($action=="qryAllReadyByZphid"){
    $zphid = $_POST['zphid'];

    $db = new MySQL_DB();
    $db->connect();

    $sql = "select d.id did,u.id uid,status,title,username
                from dxzph d,registerZPH r,user u
                where d.id = r.zphid and r.userid=u.id and zphid=$zphid and status in(0,2);";
//    echo $sql;
    $db->query($sql);

    $db->close();
}
else if($action=="qylist"){
    $zphid = $_POST['zphid'];

    $db = new MySQL_DB();
    $db->connect();

    $sql = "select username
                from dxzph d,registerZPH r,user u
                where d.id = r.zphid and r.userid=u.id and zphid=$zphid and status in(0);";
//    echo $sql;
    $db->query($sql);

    $db->close();
}
else if ($action=="pass"){
    $uid = $_POST['uid'];
    $did = $_POST['did'];
    echo $uid." ".$did;
    $db = new MySQL_DB();
    $db->connect();

    $sql = "update registerZPH set status = 0 where userid=$uid and zphid=$did;";
    $db->update($sql);

    $db->close();
}
else if($action=="refuse"){
    $uid = $_POST['uid'];
    $did = $_POST['did'];
    $db = new MySQL_DB();
    $db->connect();

    $sql = "update registerZPH set status = 2 where userid=$uid and zphid=$did;";
    $db->update($sql);

    $db->close();
}


?>