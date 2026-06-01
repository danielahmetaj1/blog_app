<?php 
require 'config/database.php';

// nese butoni i submit u shtyp 
 if(isset($_POST['submit'])){
    //merr te dhenat e formes
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $role = ((int) $is_admin === 1) ? 'admin' : 'author';
    $avatar = $_FILES['avatar'];
    

    //validate input values
    if(!$firstname){
        $_SESSION['add-user'] = "Ju lutem vendosni emrin";
    }
    elseif(!$lastname){
        $_SESSION['add-user'] = "Ju lutem vendosni mbiemrin";
    }
    elseif(!$username){
        $_SESSION['add-user'] = "Ju lutem vendosni username-in";
    }
    elseif(!$email){
        $_SESSION['add-user'] = "Ju lutem vendosni nje email valid";
    }
    // elseif(!$is_admin){
      //  $_SESSION['add-user'] = "Ju lutem zgjidhni rolin";
    //}
    elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8){
        $_SESSION['add-user'] = "Password duhet te jete te pakten 8 karaktere";
    }
    elseif(!$avatar['name']){
        $_SESSION['add-user'] = "Ju lutem zgjidhni nje avatar";
    }
    else{
        //kontrollo nese password-et nuk perputhen
        if($createpassword !== $confirmpassword){
            $_SESSION['add-user'] = "Password-et nuk perputhen";
        }
        else{
            //hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
             
            //kontrollo nese username ose email ekziston tashme ne databaze
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result) > 0){
                $_SESSION['add-user'] = "Username ose Email ekziston tashme";
            }
            else{
                //PUNO ME AVATAR
                //riemerto avatarin
                $time = time(); //bej cdo emer imazhi unik duke perdorur kohen e tashme
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                //sigurohu qe skedari eshte nje imazh
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $avatar_name);
                $extension = end($extension);
                if(in_array($extension, $allowed_files)){
                    //sigurohu qe imazhi nuk eshte shume i madh (1mb+)
                    if($avatar['size'] < 1000000){
                        //ngarko avatarin
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    }
                    else{
                        $_SESSION['add-user'] = "Madhesia e file duhet te jete me pak se 1mb";
                    }
                }
                else{
                    $_SESSION['add-user'] = "File duhet te jete png, jpg, ose jpeg";
                }
            }
        }
    }
    //ridrejto mbrapa ne faqen e signup nese ka nje gabim
    if(isset($_SESSION['add-user'])){
        //kaloji te dhenat e formes mbrapa ne faqen e signup
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . '/admin/add-user.php');
        die();
    }
    else{
        //futi perdoruesin e ri ne tabelen e perdoruesve
        $insert_user_query = "INSERT INTO users SET firstname='$firstname', 
        lastname='$lastname', username='$username', email='$email', password='$hashed_password', 
        role='$role', avatar='$avatar_name' ";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        if(!mysqli_errno($connection)){
            //ridrejto te faqja e signin me nje mesazh suksesi
            $_SESSION['add-user-success'] = "Regjistrimi u krye me sukses. Ju lutem kycuni.";
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }
}
else{
    //nese butoni nuk u shtyp, kthehu mbrapa ne faqen e signup
    header('location: ' . ROOT_URL . 'admin/add-user.php');
    die();
}
