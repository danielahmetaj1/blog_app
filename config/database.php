<?php
require_once __DIR__ . '/constants.php';


//lidhja me databaze
$connection= new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if(mysqli_errno($connection)){
    die(mysqli_error($connection));
}
