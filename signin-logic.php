<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // merr te dhenat e formes
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (!$username_email) {
        $_SESSION['signin'] = "Username ose email duhet te plotesohet";
    } elseif (!$password) {
        $_SESSION['signin'] = "Password duhet te plotesohet";
    } else {
        //merr te dhenat e perdoruesit nga databaza
        $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if (mysqli_num_rows($fetch_user_result) == 1) {
            //merr rekordet ne nje assoc array
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password'];
            //verifiko passwordin me passwordin e hash-uar ne databaze
            if (password_verify($password, $db_password)) {
                //ruaj id e perdoruesit ne session
                $_SESSION['user_id'] = $user_record['id'];
                // vendos session nese user eshte admin
                if ($user_record['role'] == 'admin') {
                    $_SESSION['user_is_admin'] = true;
                }
                //login user
                header('location: ' . ROOT_URL . 'admin/');
            }else {
            $_SESSION['signin'] = "Ju lutem kontrolloni inputet";
        }
        } else {
            $_SESSION['signin'] = "Username ose email nuk ekziston";
        }
    }

    // per cdo problem tjeter,ridrejto ne signin page me te dhenat e login
    if(isset($_SESSION['signin'])){
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }

} else {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}
