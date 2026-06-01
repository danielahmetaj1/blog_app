<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // merr te dhenat e formes
    $username_email = trim($_POST['username_email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username_email) {
        $_SESSION['signin'] = "Username ose email duhet te plotesohet";
    } elseif (!$password) {
        $_SESSION['signin'] = "Password duhet te plotesohet";
    } else {
        //merr te dhenat e perdoruesit nga databaza
        $fetch_user_query = "SELECT * FROM users WHERE username=? OR email=? LIMIT 1";
        $stmt = mysqli_prepare($connection, $fetch_user_query);
        mysqli_stmt_bind_param($stmt, 'ss', $username_email, $username_email);
        mysqli_stmt_execute($stmt);
        $fetch_user_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($fetch_user_result) == 1) {
            //merr rekordet ne nje assoc array
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password'];
            //verifiko passwordin me passwordin e hash-uar ne databaze
            if (password_verify($password, $db_password)) {
                session_regenerate_id(true);

                //ruaj id e perdoruesit ne session
                $_SESSION['user-id'] = $user_record['user_id'];
                $_SESSION['user_id'] = $user_record['user_id'];

                // vendos session nese user eshte admin
                unset($_SESSION['user_is_admin']);
                if (isset($user_record['role']) && $user_record['role'] === 'admin') {
                    $_SESSION['user_is_admin'] = true;
                }
                //login user
                header('location: ' . ROOT_URL . 'admin/');
                die();
            } else {
                $_SESSION['signin'] = "Ju lutem kontrolloni inputet";
            }
        } else {
            $_SESSION['signin'] = "Username ose email nuk ekziston";
        }
    }

    // per cdo problem tjeter, ridrejto ne signin page me te dhenat e login
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = ['username_email' => $username_email];
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }

} else {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}
