<?php
    require_once("config.php");
    date_default_timezone_set(TIMEZONE);

    class DB{
        private $db_host;
        private $db_user;
        private $db_psd;
        private $db_name;
        public $conn;

        public function DB($dbhost = DB_HOST,$dbuser = DB_USER,$dbpwd = DB_PASSWORD,$dbname = DB_NAME){
            $this->db_host = $dbhost;
            $this->db_user = $dbuser;
            $this->db_psd = $dbpwd;
            $this->db_name = $dbname;
        }

        public function open(){
            $this->conn = new mysqli($this->db_host,$this->db_user,$this->db_psd,$this->db_name);
            if ($this->conn->connect_error){
                die("connect mysql failed." . $this->conn->connect_error);
            }
            $this->conn->query("SET CHARACTER SET utf8");
        }

        public function close(){
            if (empty($this->conn)) return FALSE;
            $this->conn->close();
        }

        public function dql($sql,$real = FALSE){
            $this->open();
            if ($real) $sql = $this->conn->real_escape_string($sql);
            $res = $this->conn->query($sql)
                    or die("query failed." . $this->conn->error);
            $this->close();
            return $res;
        }

        public function real($str){
            $this->open();
            $str = $this->conn->real_escape_string($str);
            $this->close();
            return $str;
        }

        public function dml($sql,$real = FALSE){
            $this->open();
            if ($real) $sql = $this->conn->real_escape_string($sql);
            $str = "";
            $res = $this->conn->query($sql)
                    or die("query failed." . $this->conn->error);
            if (!$res){
                $str = "Failed.";
            } else {
                if ($this->conn->affected_rows > 0){
                    $str = "Success " . $this->conn->affected_rows . " rows";
                } else {
                    $str = "Sucess,but nothing change.";
                }
            }
            $this->close();
            return $str;
        }
    }
?>