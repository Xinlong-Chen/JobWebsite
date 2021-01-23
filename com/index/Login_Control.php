<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once("../tools/DB.php");

//TODO:添加action
$action = $_POST['action'];
session_start();
if($action=="login"){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password = md5($password);
    $db = new MySQL_DB();
    $db->connect();
    $ans = $db->login($username,$password);

    if ($ans!=-1) {
        $sql = "select id from user where username='$username'";
        $row = $db->getMaxId($sql);
        $uid = $row['id'];
        $_SESSION["rid"]=$ans;
        $_SESSION["uid"]=$uid;
    }
    echo $ans;
    $db->close();
}
else if($action=="qryLogin"){
    if(isset($_SESSION['rid'])){
        if(!empty($_SESSION['rid'])) {
//            var_dump($_SESSION['rid']);
            echo $_SESSION['rid'];
            return;
        }
    }
    echo -1;
}
else if($action=="qryAdmin"){
    if(isset($_SESSION['rid'])){
        if($_SESSION['rid']==1){
            echo 1;
            return ;
        }
    }
    echo -1;
}
else if($action=="qryStudent"){
    if(isset($_SESSION['rid'])){
        if($_SESSION['rid']==2){
            echo 1;
            return ;
        }
    }
    echo -1;
}
else if ($action=="qryQY"){
    if(isset($_SESSION['rid'])){
        if($_SESSION['rid']==3){
            echo 1;
            return ;
        }
    }
    echo -1;
}
else if ($action=="exit"){
    $_SESSION=array();
    session_unset();
    session_destroy();
}

?>