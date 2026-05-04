<?php
require_once __DIR__ . '/../../config/constants.php';

if (!isset($_SESSION['user-id'])) {
    $_SESSION['signin'] = 'Please sign in to access the dashboard.';
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}

require __DIR__ . '/../../partials/header.php';
