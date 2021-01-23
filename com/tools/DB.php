<?php
abstract class AbsDataBase{
    abstract public function connect();
    abstract public function query($sql);
    abstract public function close();
}

class MySQL_DB extends AbsDataBase{
    var $database_connection;

    public function connect(){
        $hostname = "localhost:3306";
        $database = "user";
        $username = "root";
        $password = "";
        try{
            @$this->database_connection = mysqli_connect($hostname,$username,$password,$database);
            // 检测连接
        }
        catch (Exception $e){
//            echo "异常！";
            return -1;
        }
        finally {
            if (!$this->database_connection) {
//                die("Connection failed: " . mysqli_connect_error());
                return -1;
            }
            return 0;
//            echo "连接成功！" . "<br>";
        }
    }

    public function query($sql){
        try {
            mysqli_query($this->database_connection, 'set names utf8');
            $result = mysqli_query($this->database_connection, $sql);
//            echo
            if (mysqli_num_rows($result) > 0) {
                // 输出数据
                while ($row = mysqli_fetch_assoc($result)) {
                    echo json_encode($row,JSON_UNESCAPED_UNICODE).'&_cxllovezjh';//转化为json串传输
                }
            }
            else {
//                echo "0 结果";
            }
        }
        catch (Exception $e){
            return -1;
        }
        return 0;
    }

    public function insert($sql){
        try{
            mysqli_query($this->database_connection, 'set names utf8');
            if (mysqli_query($this->database_connection, $sql)) {
//                echo "新记录插入成功";
                return 0;
            } else {
//                echo "Error: " . $sql . "<br>" . mysqli_error($this->database_connection);
                return -1;
            }
        }
        catch (Exception $e){
            return -1;
        }
        return 0;
    }

    public function update($sql){
        try {
            mysqli_query($this->database_connection, 'set names utf8');
            mysqli_query($this->database_connection, $sql);
        }
        catch (Exception $e){
            return -1;
        }
        return 0;
    }

    public function getColNum($sql){
        try {
            mysqli_query($this->database_connection, 'set names utf8');
            $result = mysqli_query($this->database_connection, $sql);
            return mysqli_num_rows($result);
        }
        catch (Exception $e){
//            echo "异常！连接未建立！";
            return -1;
        }
        return 0;
    }

    public function getVector($sql,$arrti){
        $arr = array();
        try {
            mysqli_query($this->database_connection, 'set names utf8');
            $result = mysqli_query($this->database_connection, $sql);
            if (mysqli_num_rows($result) > 0) {
                // 输出数据
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($arr,$row[$arrti]);
                }
            }
        }
        catch (Exception $e){
//            echo "异常！连接未建立！";
            return -1;
        }
        return $arr;
    }

    public function getMaxId($sql){
        try {
            mysqli_query($this->database_connection, 'set names utf8');
            $result = mysqli_query($this->database_connection, $sql);
//            return mysqli_num_rows($result);
            if (mysqli_num_rows($result) > 0) {
                // 输出数据
                while ($row = mysqli_fetch_assoc($result)) {
                    return $row;
                }
            }

        }
        catch (Exception $e){
//            echo "异常！连接未建立！";
            return -1;
        }
        return 0;
    }

    public function delete($sql){
        try {
            mysqli_query($this->database_connection, 'set names utf8');
            $result = mysqli_query($this->database_connection, $sql);
//            echo
        }
        catch (Exception $e){
            return -1;
        }
        return 0;
    }

    public function login($username,$password){
        try {
            mysqli_query($this->database_connection, 'set names utf8');
            $sql = "select rid from user where username='$username' and password='$password'";
//            echo $sql;
            $result = mysqli_query($this->database_connection, $sql);
            if(mysqli_num_rows($result)==1){
                if (mysqli_num_rows($result) > 0) {
                    // 输出数据
                    while ($row = mysqli_fetch_assoc($result)) {
                        return $row['rid'];
                    }
                }
            }
            else return -1;
//            echo
        }
        catch (Exception $e){
            return -1;
        }
        return 0;
    }



    public function close(){
        try {
            mysqli_close($this->database_connection);
            return 0;
            echo "关闭连接！";
        }
        catch (Exception $e){
//            echo "异常！连接未建立！";
            return -1;
        }
    }
}

?>