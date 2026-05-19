<?php
include 'config/database.php';

header('Content-Type: application/json');

if (!isset($_POST['post_id']) || !isset($_POST['platform'])) {
    echo json_encode(['success' => false]);
    exit;
}

$post_id    = (int) $_POST['post_id'];
$platform   = mysqli_real_escape_string($connection, $_POST['platform']);
$ip_address = mysqli_real_escape_string($connection, $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');

mysqli_query($connection, "INSERT INTO shares (post_id, platform, ip_address) VALUES ($post_id, '$platform', '$ip_address')");

$count_result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM shares WHERE post_id=$post_id");
$count = mysqli_fetch_assoc($count_result)['total'];

echo json_encode(['success' => true, 'count' => $count]);
