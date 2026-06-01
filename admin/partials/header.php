<?php
require_once __DIR__ . '/../../config/constants.php';

if (!isset($_SESSION['user-id'])) {
    $_SESSION['signin'] = 'Ju lutem kycuni per te aksesuar panelin.';
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}

require __DIR__ . '/../../partials/header.php';