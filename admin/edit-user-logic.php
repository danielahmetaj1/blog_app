<?php
include 'config/database.php';
if(isset($_POST['submit'])){
    //merr te dhenat e formes
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    if(!$firstname || !$lastname){
        $_SESSION['edit-user'] = "Ju lutem jepni nje input valid";
    }else{
        // perditeso perdoruesin ne databaze
        $query = "UPDATE users SET firstname='$firstname', lastname='$lastname', role='$is_admin' WHERE user_id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
        if(mysqli_errno($connection)){
            $_SESSION['edit-user'] = " Ndodhi nje gabim ne perditesimin e perdoruesit";
        }else{
            $_SESSION['edit-user-success'] = "Perdoruesi $firstname $lastname u perditesua me sukses";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage-users.php');
die();