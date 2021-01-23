<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once("../tools/DB.php");
session_start();
$action = $_POST['action'];
if($action=="add"){
    $title = $_POST['wjtitle'];

    $db = new MySQL_DB();
    $db->connect();
    $sql = "insert into wj(title) values ('$title');";

    if($db->insert($sql)==0) {
        //插入一个问题
        $sql = "select max(id) id from wj";
        $row = $db->getMaxId($sql);
        $id = $row['id'];

        $cnt=1;
        while(isset($_POST['wttitle'.$cnt])){
            $problem = $_POST["wttitle".$cnt];
            $sql = "insert into wt(id, problem) values ($id,'$problem'); ";
            if ($db->insert($sql) == 0) {
                //插入一个选项
                $sql = "select max(wtid) wtid from wt";
                $row = $db->getMaxId($sql);
                $wtid = $row['wtid'];

                $cnt_ans=1;
                while(isset($_POST['answer'.$cnt."_".$cnt_ans])) {
                    $ans = $_POST['answer'.$cnt."_".$cnt_ans];
                    echo $ans;
                    $sql = "insert into da(wtid, ans) values ($wtid,'$ans');";
                    $db->insert($sql);
                    $cnt_ans++;
                }
            }
            $cnt++;
        }
    }
    else{
        echo "error";
    }

    $db->close();
}
else if ($action=="del"){
    $id = $_POST['id'];
    $db = new MySQL_DB();
    $db->connect();
    echo $sql = "delete from wj where id = $id;";
    $db->delete($sql);
    $db->close();
}
else if($action=="qry"){
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select id,title from wj";
    $db->query($sql);
    $db->close();
}
else if($action=="qrywj"){
    $id = $_POST['id'];

    $db = new MySQL_DB();
    $db->connect();
    $sql = "select title from wj where id=$id";
    $row = $db->getMaxId($sql);
    $title = $row['title'];

    $db->close();
    echo $title;
}
else if ($action=="qrywt"){
    $id = $_POST['id'];

    $db = new MySQL_DB();
    $db->connect();
    $sql = "select wtid,problem from wt where id=$id ";
    $row = $db->query($sql);

    $db->close();
}
else if($action=="qryans"){
    $id = $_POST['id'];

    $db = new MySQL_DB();
    $db->connect();
    $sql = "select ans from da where wtid=$id ";
    $row = $db->query($sql);

    $db->close();
}
else if($action=="ans"){
    $id = $_POST['id'];


    $db = new MySQL_DB();
    $db->connect();
    $sql = "select wtid from wt where id=$id;";
    $arr = $db->getVector($sql,'wtid');
    $len = count($arr);

    for($i=0;$i<$len;$i++){
        $wtid = $arr[$i];
        $ans = $_POST["wttitle".$wtid];

        $sql = "update da set num=num+1 where wtid=$wtid and ans='$ans'";
        $db->update($sql);

    }

//    print_r($arr);
    $db->close();
//    print_r($_POST);
}
else if($action=="qryshujuBywtid"){
    $wtid = $_POST['wtid'];

    $db = new MySQL_DB();
    $db->connect();

    $sql = "select ans,num,problem from da,wt where da.wtid=$wtid and da.wtid=wt.wtid";
    $db->query($sql);

    $db->close();
}
else if ($action=="qryCan") {
    $uid = $_SESSION['uid'];

    $db = new MySQL_DB();
    $db->connect();
    $sql = "select title,id from wj where wj.id not in (select txwj.wjid from txwj where uid=$uid);";

    $db->query($sql);

    $db->close();
}
else if ($action=="qryHave"){
    $uid = $_SESSION['uid'];

    $db = new MySQL_DB();
    $db->connect();
    $sql = "select title,id from wj where wj.id in (select txwj.wjid from txwj where uid=$uid);";

    $db->query($sql);

    $db->close();
}
else if($action=="tx"){
    $wjid = $_POST['wjid'];
    $uid  = $_SESSION['uid'];

    $db = new MySQL_DB();
    $db->connect();
    $sql = "insert into txwj(uid,wjid) values ($uid,$wjid);";
    if($db->insert($sql)==0){
        echo "Success";
    }
    else echo "Fail";
}
else if ($action=="qryStudentHave"){
    $uid = $_SESSION['uid'];
    $wjid = $_POST['wjid'];

    $db = new MySQL_DB();
    $db->connect();
    $sql = "select count(*) flag from txwj where uid=$uid and wjid=$wjid;";

    $row=$db->getMaxId($sql);
    $flag = $row['flag'];
    if ($flag==0){
        echo 0;
    }
    else echo 1;

    $db->close();
}

?>