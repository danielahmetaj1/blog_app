<?php
require 'config/database.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WriteX Blog</title>
    <!-- Stilizim custom-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <!--Ikona -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.2.0/css/line.css">
    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <nav>
        <div class="container nav__container">
            <a href="<?= ROOT_URL ?>" class="nav__logo">WriteX</a>
            <ul class="nav__items">

                <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                <li><a href="<?= ROOT_URL ?>signin.php">Sign In</a></li>
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="./images/avatar1.png" alt="">
                    </div>
                    <ul>
                        <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                        <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                    </ul>

                </li>
            </ul>
            <button id="close_nav-btn" aria-label="Close navigation menu"><i class="uil uil-multiply"
                    aria-hidden="true"></i></button>
            <button id="open_nav-btn" aria-label="Open navigation menu"><i class="uil uil-bars"
                    aria-hidden="true"></i></button>
        </div>
    </nav>
    <!--fund i navit-->