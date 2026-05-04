<?php 
require 'config/database.php';

//merrni te dhenat e formularit te regjistrimit nese butoni i regjistrimit u shtypet
 if(isset($_POST['submit'])){
    //merrni te dhanat e formularit
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];
    

    //kontrolloni vlerat e hyrjes
    if(!$firstname){
        $_SESSION['signup'] = "Please enter your First Name";
    }
    elseif(!$lastname){
        $_SESSION['signup'] = "Please enter your Last Name";
    }
    elseif(!$username){
        $_SESSION['signup'] = "Please enter your Username";
    }
    elseif(!$email){
        $_SESSION['signup'] = "Please enter a valid Email";
    }
    elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8){
        $_SESSION['signup'] = "Password should be at least 8 characters";
    }
    elseif(!$avatar['name']){
        $_SESSION['signup'] = "Please select an Avatar";
    }
    else{
        //kontrolloni nese fjalekalimet nuk perputhen
        if($createpassword !== $confirmpassword){
            $_SESSION['signup'] = "Passwords do not match";
        }
        else{
            //hash-oj fjalekalimet
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
             
            //kontrolloni nese emri i perdoruesit ose emaili ekziston ne bazin e te dhenave
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result) > 0){
                $_SESSION['signup'] = "Username or Email already exists";
            }
            else{
                //PUNO ME AVATAR
                //riemertoni avatarin
                $time = time(); //beni cdo emer imazhi unik duke perdorur kohen e tashme
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/' . $avatar_name;

                //sigurohuni qe skedari eshte nje imazh
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $avatar_name);
                $extension = end($extension);
                if(in_array($extension, $allowed_files)){
                    //sigurohuni qe imazhi nuk eshte shume i madh (1mb+)
                    if($avatar['size'] < 1000000){
                        //ngarko avatarin
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    }
                    else{
                        $_SESSION['signup'] = "File size should be less than 1mb";
                    }
                }
                else{
                    $_SESSION['signup'] = "File should be png, jpg, or jpeg";
                }
            }
        }
    }
    //ridrejtoni mbrapa ne faqen e regjistrimit nese ka nje gabim
    if(isset($_SESSION['signup'])){
        //kaloni te dhanat e formularit mbrapa ne faqen e regjistrimit
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }
    else{
        //futni perdoruesin e ri ne tabelen e perdoruesve
        $insert_user_query = "INSERT INTO users SET firstname='$firstname', 
        lastname='$lastname', username='$username', email='$email', password='$hashed_password', 
        role='author', avatar='$avatar_name' ";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        if(!mysqli_errno($connection)){
            //ridrejtoni ne faqen e hyrjes me nje mesazh suksesi
            $_SESSION['signup-success'] = "Registration successful. Please sign in.";
            header('location: ' . ROOT_URL . 'signin.php');
            die();
        }
    }
}
else{
    //nese butoni nuk u shtypet, kthehu mbrapa ne faqen e regjistrimit
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}