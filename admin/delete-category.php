<?php 
require 'config/database.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    

    // updetojme category_id te posteve qe i perket kategorise te pa autorizuar
    $update_query = "UPDATE posts SET category_id=5 WHERE category_id=$id";
    $update_result = mysqli_query($connection, $update_query);
     if(!mysqli_errno($connection)){
//fshijme kategorine nga databaza
    $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
    $result = mysqli_query($connection, $query);
    $_SESSION['delete-category-success'] = "Kategoria u fshi me sukses.";
     }
    

}

header('location: ' . ROOT_URL . 'admin/manage-categories.php');
die();