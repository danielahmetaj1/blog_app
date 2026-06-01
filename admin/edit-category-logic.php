<?php
require 'config/database.php';

if(isset($_POST['submit'])){
    $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $slug = filter_var($_POST['slug'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // kontrollojme te dhenat
    if(!$title || !$slug) {
        $_SESSION['edit-category'] = "Ju lutem plotesoni te gjitha fushat.";
           
    }else{
        $query = "UPDATE categories SET title='$title', slug='$slug' WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);

        if(!$result){
            $_SESSION['edit-category'] = "Dicka shkoi gabim. Ju lutem provoni perseri.";
        }else{
            $_SESSION['edit-category-success'] = "Kategoria u perditesua me sukses.";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage-categories.php');
die();
