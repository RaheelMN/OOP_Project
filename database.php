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
                echo "<br>this is constructor function. Connection successful";
                return true;
            }
        }
    }

    //close db connection
    function __destruct(){
        if($this->conn){
            $this->mysqli->close();
            $this->conn = false;
            echo "<br>this is destructor function. Connection close";
        }
            
    }
}



?>