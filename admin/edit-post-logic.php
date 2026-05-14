<?php
require 'config/database.php';

// kontrollojme nese butoni eshte shtyput
if(isset($_POST['submit'])) {
    // marja e vlerave nga forma
    $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
    $content = filter_var($_POST['content'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_featured = filter_var($_POST['is_featured'],FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
   
    $is_featured = $is_featured == 1 ?: 0;

    // kontrollojme nese te dhenat jane te plota
    if(!$title) {
        $_SESSION['edit-post'] = "Ju lutem vendosni nje titull per postin";
    }elseif(!$category_id) {
        $_SESSION['edit-post'] = "Ju lutem zgjidhni nje kategori per postin";
    }elseif(!$content) {
        $_SESSION['edit-post'] = "Ju lutem vendosni zhvillimin e postit";
    }else {        
        if($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;

            if($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }

            // krijojme nje emer unik per miniaturen
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            // kontrollojme nese file-i i ngarkuar eshte nje imazh
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);
            if(in_array($extension, $allowed_files)) {
                if($thumbnail['size'] < 2000000) {
                     // levizim i file-it te ngarkuar ne destinacionin e deshiruar
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                }               
            }else {
                $_SESSION['edit-post'] = "Ju lutem ngarkoni nje file imazhi (png, jpg, jpeg)";
            }
        }else {
        $_SESSION['edit-post'] = "Ju lutem ngarkoni nje miniaturë ne formatin png, jpg ose jpeg";  
        }
    }

    if($_SESSION['edit-post']) {
        header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
        die();
    }else{
        if($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
           $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;
        $query = "UPDATE posts SET title='$title', thumbnail='$thumbnail_to_insert', category_id=$category_id, content='$content', is_featured=$is_featured WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
    }
    if(mysqli_errno($connection)) {
        $_SESSION['edit-post'] = "Ndodhi nje gabim gjate perditesimit te postit";
        header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
        die();
    }
}

    

header('location: ' . ROOT_URL . 'admin/');
die();