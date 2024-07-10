<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 


$db_host = 'localhost';
$db_user = 'u2203040005';
$db_pass = 'u2203040005';
$db_name = 'dbu2203040005';

$connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
    echo '<b>Database Error:</b> ' . mysqli_connect_error();
    exit;
}
?>