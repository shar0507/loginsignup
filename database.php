<?php
$host="localhost";
$username="root";
$password="";
$dbname="login_db";


$mysqli= new mysqli($host, $username, $password, $dbname, 4306);
if($mysqli->connect_errno){
    die("Connection error:".$mysqli->connect_error);
}

return $mysqli;