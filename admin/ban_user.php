<?php
include 'admin_header.php';

if (isset($_GET['id']) && isset($_GET['action'])) {
    $user_id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'ban') {
        $sql = "UPDATE users SET is_banned = 1 WHERE id = ?";
    } elseif ($action == 'unban') {
        $sql = "UPDATE users SET is_banned = 0 WHERE id = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

header("Location: manage_users.php");
exit();
?>