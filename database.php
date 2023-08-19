<?php

//set default execption handling function
set_exception_handler('myExceptionHandler');

//define default exeption handling function
function myExceptionHandler(\Exception|string $e):void{
    if(gettype($e)=='object'){
        echo "<br> myException: ".$e->getMessage();
    }else
    echo "<br> myException: ".$e;
}

//set default error handling funtion
set_error_handler('myErrorHandler');

//define default error handling function
function myErrorHandler(int $errno,string $errstr,string $errfile,int $errline){

    $error_msg = "-- myErrorHandler -- Error[$errno] in line: ".$errline."-- File Name: " .$errfile." -- Message:  ".$errstr;
    echo "<br> myError: ".$error_msg;

}

class database{

    private $server_name = "localhost";
    private $user_name = "root";
    private $password = "";
    private $db_name = "test";
    private $conn=false;
    private $mysqli = "";
    private $result = [];

    //create db connection
    public function __construct(){
        if(!$this->conn){
            $this->mysqli = new mysqli($this->server_name,$this->user_name,$this->password,$this->db_name);
            if($this->mysqli->connect_error){
                array_push($result,$this->mysqli->connect_error);
                return false;         
            }else{
                $this->conn = true;
                return true;
            }
        }
    }

    public function insert(string $table,array $row){
        if($this->checkTable($table)){
            $col_names = implode(',',array_keys($row));
            $col_values = implode("','",array_values($row));
            $sql = "INSERT INTO $table ($col_names) VALUES ('$col_values');";
            if( $this->mysqli->query($sql)){
                array_push($this->result,$this->mysqli->insert_id);
                return true;
            }else{
                array_push($this->result,$this->mysqli->error);
                return false;                
            }
        }
    }

    public function update(string $table,array $data,string $where=null){
        if($this->checkTable($table)){
            $args = [];
            foreach($data as $key => $value){
                $args[]= "$key = '$value'";
            }
            $str = implode(',',$args);
            $sql = "UPDATE $table SET $str";
            if($where != null){
                $sql .= " WHERE $where ;";
            }
            if( $this->mysqli->query($sql)){
                array_push($this->result,$this->mysqli->affected_rows);
                return true;
            }else{
                array_push($this->result,$this->mysqli->error);
                return false;                
            }
        }
    } 

    public function delete(string $table,string $where=NULL){
        if($this->checkTable($table)){

            $sql = "DELETE FROM $table";

            if($where != null){
                $sql .= " WHERE $where ;";
            }            
            if( $this->mysqli->query($sql)){
                array_push($this->result,$this->mysqli->affected_rows);
                return true;
            }else{
                array_push($this->result,$this->mysqli->error);
                return false;                
            }
        }
    } 
    
    public function sql(string $sql){
          $records= $this->mysqli->query($sql);
        if($records){
            $this->result = $records->fetch_all(MYSQLI_ASSOC);
            return true;
        }else{
            array_push($this->result,$this->mysqli->error);
            return false;                
        }
    }      

    public function select(string $table,string $rows = "*",string $join = null, string $where = null, string $orderby =NULL, int $limit=NULL){

        if($this->checkTable($table)){
            $sql = "SELECT $rows FROM $table";
            if($join != NULL){
                $sql .= " JOIN  $join";
            }
            if($where != NULL){
                $sql .= " WHERE $where";
            }
            if($orderby != NULL){
                $sql .= " ORDER BY $orderby";
            }
            if($limit != NULL){
                $sql .= " LIMIT 0, $limit";
            }
            $records= $this->mysqli->query($sql);
            if($records){
                $this->result = $records->fetch_all(MYSQLI_ASSOC);
                return true;
            }else{
                array_push($this->result,$this->mysqli->error);
                return false;                
            }
        }else return false;
    }  

    public function getResults():array{
        $val = $this->result;
        $this->result = array();
        return $val;
    }
    private function checkTable(string $table):bool {
        $sql = "SHOW TABLES FROM {$this->db_name} LIKE '$table'";
        $result = $this->mysqli->query($sql);
        if($result){
            if($result->num_rows>0){
                return true;
            }else{
                array_push($this->result,$table." doesnot exists");
                return false;
            }
        }
    }
    //close db connection
    function __destruct(){
        if($this->conn){
            $this->mysqli->close();
            $this->conn = false;
        }
            
    }
}



?>