<?php
include 'admin_header.php';

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "DELETE FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
}

header("Location: manage_posts.php");
exit();
?>