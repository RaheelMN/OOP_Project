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

//creating mysqli object and connecting with db
$conn = new mysqli('localhost','root','','test');

echo "<br>".get_class($conn)." class properties ";
echo "<pre>";
print_r(get_class_vars('mysqli'));
echo "</pre>";
echo "<br>".get_class($conn)." class methods ";
echo "<pre>";
print_r(get_class_methods('mysqli'));
echo "</pre>";

//if there is connection error
// if($conn->connect_error){
//     die("Failed to connect to db: ".$conn->connect_error);
// }

//query to db
$sql = "SELECT * FROM stock";
$result = $conn->query($sql);

echo "<br>".get_class($result)." class properties ";
echo "<pre>";
print_r(get_class_vars(get_class($result)));
echo "</pre>";
echo "<br>".get_class($result)." class methods ";
echo "<pre>";
print_r(get_class_methods(get_class($result)));
echo "</pre>";

$output = [];
$output['error']=false;
//check if $result has any records
if($result->num_rows > 0){
    //retreive records in associative array format from result object
    $output['records'] = $result->fetch_all(MYSQLI_ASSOC);
}else
    $output['error']= true;




//display result
if($output['error']){
    echo "<br>. No record found.";
}else{
    echo "<pre>";
    print_r($output['records']);
    echo "</pre>";
}

//free memory
$result->free();

//close db connection
$conn->close();
?>