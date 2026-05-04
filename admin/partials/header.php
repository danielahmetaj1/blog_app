<?php
require '../partials/header.php';

// kontrollon statusin e s
if(isset($_SESSION['user-id'])){
    header('location: ' . ROOT_URL . 'singin.php');
    die();
}