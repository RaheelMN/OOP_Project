<?php

//include database class
require_once 'database.php';


//create database object
$obj = new database();
// $obj->insert('students',['st_name'=>'akbar','st_age'=>32,'st_city'=>'peshawar']);
// $obj->update('students',['st_name'=>'amir','st_age'=>22,'st_city'=>'peshawar'],"st_id = 6");
// $obj->delete('students',"st_id = 6");
// $obj->sql("SELECT * FROM students");
$obj->select('students',"*",NULL,NULL,NULL,3);
$ans = $obj->getResults();
echo "<pre>";
print_r($ans);
echo "</pre>";
$pagination = $obj->pagination('students',NULL,NULL,3);
echo $pagination;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OOP_Project</title>
</head>
<body>
    
</body>
</html>