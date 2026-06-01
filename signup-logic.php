<?php 
require 'config/database.php';

//merr te dhenat e formularit te regjistrimit nese butoni i regjistrimit u shtyp
 if(isset($_POST['submit'])){
    //merr te dhenat e formularit
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];
    

    //kontrolloni vlerat e hyrjes
    if(!$firstname){
        $_SESSION['signup'] = "Ju lutem vendosni emrin tuaj";
    }
    elseif(!$lastname){
        $_SESSION['signup'] = "Ju lutem vendosni mbiemrin tuaj";
    }
    elseif(!$username){
        $_SESSION['signup'] = "Ju lutem vendosni username-in tuaj";
    }
    elseif(!$email){
        $_SESSION['signup'] = "Ju lutem vendosni nje email valid";
    }
    elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8){
        $_SESSION['signup'] = "Password duhet te jete te pakten 8 karaktere";
    }
    elseif(!$avatar['name']){
        $_SESSION['signup'] = "Ju lutem zgjidhni nje avatar";
    }
    else{
        //kontrolloni nese fjalekalimet nuk perputhen
        if($createpassword !== $confirmpassword){
            $_SESSION['signup'] = "Password-et nuk perputhen";
        }
        else{
            //hash-oj fjalekalimet
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
             
            //kontrolloni nese emri i perdoruesit ose emaili ekziston ne bazen e te dhenave
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' ";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result) > 0){
                $_SESSION['signup'] = "Username ose Email ekziston tashme";
            }
            else{
                //PUNO ME AVATAR
                //riemertoni avatarin
                $time = time(); //bej cdo emer imazhi unik duke perdorur kohen e tashme
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
                        $_SESSION['signup'] = "Madhesia e file duhet te jete me pak se 1mb";
                    }
                }
                else{
                    $_SESSION['signup'] = "File duhet te jete png, jpg, ose jpeg";
                }
            }
        }
    }
    //ridrejtoni mbrapa ne faqen e regjistrimit nese ka nje gabim
    if(isset($_SESSION['signup'])){
        //kaloni te dhenat e formularit mbrapa ne faqen e regjistrimit
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
            $_SESSION['signup-success'] = "Regjistrimi u krye me sukses. Ju lutem kycuni.";
            header('location: ' . ROOT_URL . 'signin.php');
            die();
        }
    }
}
else{
    //nese butoni nuk u shtyp, kthehu mbrapa ne faqen e regjistrimit
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}
