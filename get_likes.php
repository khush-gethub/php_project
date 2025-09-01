<?php
include 'includes/db.php';

$post_id = $_GET['post_id'];

$sql = "SELECT likes, dislikes FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$counts = $result->fetch_assoc();

echo json_encode($counts);
?>