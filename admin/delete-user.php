<?php
require 'config/database.php';

if(isset($_GET['id'])){
    //zgjedh perdoruesin nga databaza
    $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE user_id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);


  // sigurohemi qe marim vetem nje user
  if(mysqli_num_rows($result)==1){
    $avatar_name = $user['avatar'];
    $avatar_path = '../images/' . $avatar_name;
    //vazhdojme me fshirjen e avatarit
    if($avatar_path){
        unlink($avatar_path);
    }
  }

  //selektojme te gjithe te dhenat e user dhe i fshijme ato

  //fshi perdorues nga databaza
  $delete_user_query = "DELETE FROM users WHERE user_id=$id";
  $delete_user_result = mysqli_query($connection,$delete_user_query);
if(mysqli_errno($connection)){
    $_SESSION['delete-user']="Nuk mund te fshinim perdoruesi '{$user['firstname']}' '{$user['lastname']}'";

}else{
    $_SESSION['delete-user-success'] = "'{$user['firstname']}' '{$user['lastname']}' perdoruesi u fshi me sukses.";
}
}

header('location: ' . ROOT_URL . 'admin/manage-users.php');
die(); 