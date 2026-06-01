<?php
include 'config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user-id'])) {
    echo json_encode(['success' => false, 'message' => 'Duhet te jeni te kycur per te pelqyer postime.']);
    exit;
}

if (!isset($_POST['post_id'])) {
    echo json_encode(['success' => false, 'message' => 'Kerkese e pavlefshme.']);
    exit;
}

$post_id = (int) $_POST['post_id'];
$user_id = (int) $_SESSION['user-id'];

// Kontrollo nese eshte pelqyer me pare
$check = mysqli_query($connection, "SELECT id FROM likes WHERE post_id=$post_id AND user_id=$user_id");

if (mysqli_num_rows($check) > 0) {
    // Hiq pelqimin
    mysqli_query($connection, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");
    $liked = false;
} else {
    // Pelqe
    mysqli_query($connection, "INSERT INTO likes (post_id, user_id) VALUES ($post_id, $user_id)");
    $liked = true;
}

$count_result = mysqli_query($connection, "SELECT COUNT(*) AS total FROM likes WHERE post_id=$post_id");
$count = mysqli_fetch_assoc($count_result)['total'];

echo json_encode(['success' => true, 'liked' => $liked, 'count' => $count]);
