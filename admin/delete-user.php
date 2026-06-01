<?php
require 'config/database.php';

if(isset($_GET['id'])){
    //zgjedh perdoruesin nga databaza
    $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE user_id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);


  // sigurohemi qe marrim vetem nje user
  if(mysqli_num_rows($result)==1){
    $avatar_name = $user['avatar'];
    $avatar_path = '../images/' . $avatar_name;
    //vazhdojme me fshirjen e avatarit
    if($avatar_path){
        unlink($avatar_path);
    }
  }

  //selektojme te gjitha te dhenat e user dhe i fshijme ato
$thumbnails_query = "SELECT thumbnail FROM posts WHERE user_id=$id";
$thumbnails_result = mysqli_query($connection, $thumbnails_query);
if(mysqli_num_rows($thumbnails_result) > 0){
    while($thumbnail = mysqli_fetch_assoc($thumbnails_result)){
        $thumbnail_path = '../images/' . $thumbnail['thumbnail'];
        if($thumbnail_path){
            unlink($thumbnail_path);
        }
    }
}


  //fshi perdoruesin nga databaza
  $delete_user_query = "DELETE FROM users WHERE user_id=$id";
  $delete_user_result = mysqli_query($connection,$delete_user_query);
if(mysqli_errno($connection)){
    $_SESSION['delete-user']="Nuk mund te fshinim perdoruesin '{$user['firstname']}' '{$user['lastname']}'";

}else{
    $_SESSION['delete-user-success'] = "Perdoruesi '{$user['firstname']}' '{$user['lastname']}' u fshi me sukses.";
}
}

header('location: ' . ROOT_URL . 'admin/manage-users.php');
die();
