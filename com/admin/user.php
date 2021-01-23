<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once("../tools/DB.php");


$action = $_POST['action'];
if($action=="getRole"){
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select * from role";
    $db->query($sql);
    $db->close();
}
else if($action=="add"){
//    $id = $_POST['id'];
//    if()
    if(empty($_POST['id'])) {
        $email =$_POST['email'];
        $password =$_POST['password'];
        $username =$_POST['username'];
        $role =$_POST['role'];

        $password = md5($password);

        $db = new MySQL_DB();
        $db->connect();
        $sql = "insert into user(username,password,email,rid) values ('$username','$password','$email',$role);";
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

        $email =$_POST['email'];
        $password =$_POST['password'];
        $username =$_POST['username'];
        $role = $_POST['role'];

        $password = md5($password);

        $db = new MySQL_DB();
        $db->connect();
        $sql = "update user set username='$username', password='$password',email='$email',rid=$role where id=$id;";
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
    $sql = "delete from user where id = $id;";
    $db->query($sql);
    $db->close();
}
else if($action=="edi"){
    $id = $_POST['id'];
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select id,username,email,password,rid from user where id=$id";
    $db->query($sql);
    $db->close();
}
else if($action=="qry"){
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select id,username,email,password,rname from user,role where user.rid = role.rid;";
    $db->query($sql);
    $db->close();
}
else if($action=="addQY"){
    $email =$_POST['email'];
    $password =$_POST['password'];
    $username =$_POST['username'];
    $role =3;
    $password = md5($password);

    $db = new MySQL_DB();
    $db->connect();
    $sql = "insert into user(username,password,email,rid) values ('$username','$password','$email',$role);";
    echo $sql . "\n";

    if ($db->insert($sql) == 0) {
        $sql = "select max(id) lastid from user";
        $row = $db->getMaxId($sql);
        $lastid = $row['lastid'];

        $qname = $_POST['qname'];
        $creditcode = $_POST['creditcode'];
        $address = $_POST['address'];
        $size = $_POST['size'];

        $sql = "insert into qy(qname,creditcode,address,size ,id) values ('$qname','$creditcode','$address','$size',$lastid)";
        if ($db->insert($sql) == 0){
            echo "Success!";
        }
        else{
            echo "企业信息插入失败！";
        }
    } else {
        echo "用户信息插入失败";
    }

    $db->close();
}