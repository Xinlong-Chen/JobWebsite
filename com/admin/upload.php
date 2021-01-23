<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once("../tools/DB.php");

$path = '../../upload/';

$action=$_POST['action'];
if($action=="add") {
    $id=$_POST['id'];
    if(empty($id)) {
        $name = $_FILES['userfile']['name'];
        if (strlen($name) > 98) {
            echo strlen($name);
            return;
        }
        $title = $_POST['title'];
        $name = iconv("UTF-8", "UTF-8", $name);
        //echo $name."&cxllovezjh";
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $path . $name)) {


            $db = new MySQL_DB();
            $db->connect();
            $sql = "insert into file(title,filename) values ('$title','$name')";
            $ans = $db->insert($sql);
            $db->close();
            if ($ans == -1) {
                echo 0;
                return;
            }
            echo 1;
        } else {
            echo 0;
        }
    }

    else{
        echo "exid";
        $name = $_FILES['userfile']['name'];
        if (strlen($name) > 98) {
            echo strlen($name);
            return;
        }
        $title = $_POST['title'];
        $name = iconv("UTF-8", "UTF-8", $name);
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $path . $name)) {
            $db = new MySQL_DB();
            $db->connect();

            $sql = "select filename from file where id=$id";
            $result = mysqli_query($db->database_connection, $sql);
            $filename="";
            if (mysqli_num_rows($result) > 0) {
                // 输出数据
                while ($row = mysqli_fetch_assoc($result)) {
                    $filename=$row['filename'];
                    break;
                }
            }
            if($filename==""){
                return 0;
            }

            $filepath = "../../upload/".$filename;
            echo $filepath;
            unlink($filepath);

            $sql = "update file set title='$title',filename='$name' where id = $id;";
            $ans = $db->insert($sql);
            $db->close();
            if ($ans == -1) {
                echo 0;
                return;
            }
            echo 1;
        } else {
            echo 0;
        }
    }
}
else if($action=="qry") {
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select * from file";
    $db->query($sql);
    $db->close();
}
else if($action=="edi"){
    $id = $_POST['id'];
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select * from file where id=$id";
    $db->query($sql);
    $db->close();
}
else if ($action=="del"){
    $id = $_POST['id'];
    $db = new MySQL_DB();
    $db->connect();

    try {
        mysqli_query($db->database_connection, 'set names utf8');
        $sql = "select filename from file where id=$id";
        $result = mysqli_query($db->database_connection, $sql);
        $filename="";
        if (mysqli_num_rows($result) > 0) {
            // 输出数据
            while ($row = mysqli_fetch_assoc($result)) {
                $filename=$row['filename'];
                break;
            }
        }
        if($filename==""){
            return -1;
        }

        $filepath = "../../upload/".$filename;
        echo $filepath;
        unlink($filepath);
        $sql = "delete from file where id = $id;";
        $db->delete($sql);
        $db->close();
    }
    catch (Exception $e){
//            echo "异常！连接未建立！";
        return -1;
    }
    return 0;
}

?>