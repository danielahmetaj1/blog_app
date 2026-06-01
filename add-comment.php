<?php
include 'config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user-id'])) {
    echo json_encode(['success' => false, 'message' => 'Duhet te jeni te kycur per te komentuar.']);
    exit;
}

if (!isset($_POST['post_id']) || empty(trim($_POST['body'] ?? ''))) {
    echo json_encode(['success' => false, 'message' => 'Komenti nuk mund te jete bosh.']);
    exit;
}

$post_id = (int) $_POST['post_id'];
$user_id = (int) $_SESSION['user-id'];
$body    = mysqli_real_escape_string($connection, trim($_POST['body']));

mysqli_query($connection, "INSERT INTO comments (post_id, user_id, body) VALUES ($post_id, $user_id, '$body')");

// Merr komentin e ri te futur me informacionin e perdoruesit
$comment_id = mysqli_insert_id($connection);
$result = mysqli_query($connection,
    "SELECT c.id, c.body, c.created_at, u.username, u.avatar
     FROM comments c
     JOIN users u ON c.user_id = u.user_id
     WHERE c.id = $comment_id"
);
$comment = mysqli_fetch_assoc($result);
$comment['created_at'] = date('d M, Y - H:i', strtotime($comment['created_at']));

echo json_encode(['success' => true, 'comment' => $comment]);
