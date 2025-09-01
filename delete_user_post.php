<?php
include 'includes/header.php';
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "DELETE FROM posts WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
}

header("Location: profile.php");
exit();
?>