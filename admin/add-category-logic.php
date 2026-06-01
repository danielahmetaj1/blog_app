<?php
require 'config/database.php';

 
if(isset($_POST['submit'])){
    //merr te dhenat e formes
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $slug = filter_var($_POST['slug'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $created_at = filter_var($_POST['created_at'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //kontrolloni vlerat e hyrjes
    if(!$title){
        $_SESSION['add-category'] = "Ju lutem vendosni nje titull";

}
    elseif(!$slug){
        $_SESSION['add-category'] = "Ju lutem vendosni nje pershkrim";
    }
    elseif(!$created_at){
        $_SESSION['add-category'] = "Ju lutem vendosni daten e krijimit";
    }
    //ktheu ne add-category page nese ka probleme me vlerat e hyrjes
    if(isset($_SESSION['add-category'])){
      $_SESSION['add-category-data']= $_POST;
      header('location: ' . ROOT_URL . 'admin/add-category.php');
        die();
    }
    else{
        //shtoni kategorine ne databaze
        $query = "INSERT INTO categories (title, slug, created_at) VALUES ('$title', '$slug', '$created_at')";
        $result = mysqli_query($connection, $query);
        if(mysqli_errno($connection)){
            $_SESSION['add-category'] = "Kategoria nuk mund te shtohet";
            header('location: ' . ROOT_URL . 'admin/add-category.php');
            die();
        }
        else{
            $_SESSION['add-category-success'] = "Kategoria $title u shtua me sukses";
            header('location: ' . ROOT_URL . 'admin/manage-categories.php');
            die();
        }
    }

}