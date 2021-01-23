<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once("../tools/DB.php");

//TODO:添加action
$action = $_POST['action'];
if($action=="tzshow"){
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select id,top,title,postdate from tz order by top desc,postdate desc limit 10;";
    $db->query($sql);

    $db->close();
}
else if($action=="zpshow"){
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select id,top,title,postdate from zp where status=0  order by top desc,postdate desc limit 10;";
    $db->query($sql);

    $db->close();
}
else if($action=="dxzphshow"){
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select id,top,title,postdate from dxzph order by top desc,postdate desc limit 10;";
    $db->query($sql);

    $db->close();
}
else if($action=="zpqry"){
    $id = $_POST['id'];
    $db = new MySQL_DB();
    $db->connect();
    $sql = "SELECT * FROM zp where id=$id";
    $db->query($sql);
    $db->close();
}
else if($action=="tzqry"){
    $id = $_POST['id'];
    $db = new MySQL_DB();
    $db->connect();
    $sql = "SELECT * FROM tz where id=$id";
    $db->query($sql);
    $db->close();
}
else if($action=="dxzphqry"){
    $id = $_POST['id'];
    $db = new MySQL_DB();
    $db->connect();
    $sql = "SELECT * FROM dxzph where id=$id";
    $db->query($sql);
    $db->close();
}
else if($action=="tzGetCol"){
    $db = new MySQL_DB();
    $db->connect();
    $sql = "SELECT * FROM tz ";
    $num=$db->getColNum($sql);
    echo $num;
    $db->close();
}
else if($action=="dxzphGetCol"){
    $db = new MySQL_DB();
    $db->connect();
    $sql = "SELECT * FROM dxzph ";
    $num=$db->getColNum($sql);
    echo $num;
    $db->close();
}
else if($action=="zpGetCol"){
    $db = new MySQL_DB();
    $db->connect();
    $sql = "SELECT * FROM zp ";
    $num=$db->getColNum($sql);
    echo $num;
    $db->close();
}
else if($action=="tzShowPage"){
    $num = $_POST['pagenum'];
    $begin = ($num-1)*10;
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select * from tz order by top desc,postdate desc limit $begin,10";
    $db->query($sql);
    $db->close();
}
else if($action=="zpShowPage"){
    $num = $_POST['pagenum'];
    $begin = ($num-1)*10;
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select * from zp order by top desc,postdate desc limit $begin,10";
    $db->query($sql);
    $db->close();
}
else if($action=="dxzphShowPage"){
    $num = $_POST['pagenum'];
    $begin = ($num-1)*10;
    $db = new MySQL_DB();
    $db->connect();
    $sql = "select * from dxzph order by top desc,postdate desc limit $begin,10";
    $db->query($sql);
    $db->close();
}

