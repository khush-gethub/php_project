<?php
include "includes/db.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["error" => "You must be logged in to react."]);
    exit();
}

$user_id = $_SESSION["user_id"];

// Check if the user is banned
$sql = "SELECT is_banned FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user["is_banned"]) {
    echo json_encode(["error" => "You are banned and cannot react to posts."]);
    exit();
}

$post_id = $_POST["post_id"];
$reaction_type = $_POST["reaction_type"];

// Check if the user has already reacted
$sql = "SELECT * FROM post_reactions WHERE user_id = ? AND post_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $post_id);
$stmt->execute();
$result = $stmt->get_result();
$existing_reaction = $result->fetch_assoc();

if ($existing_reaction) {
    // User has already reacted
    if ($existing_reaction["reaction_type"] == $reaction_type) {
        // User is clicking the same button again, so undo the reaction
        $sql = "DELETE FROM post_reactions WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $existing_reaction["id"]);
        $stmt->execute();

        // Decrement the corresponding count in the posts table
        $sql =
            "UPDATE posts SET " .
            $reaction_type .
            "s = " .
            $reaction_type .
            "s - 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
    } else {
        // User is changing their reaction
        $sql = "UPDATE post_reactions SET reaction_type = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $reaction_type, $existing_reaction["id"]);
        $stmt->execute();

        // Decrement the old reaction count and increment the new one
        $other_reaction = $reaction_type == "like" ? "dislike" : "like";
        $sql =
            "UPDATE posts SET " .
            $reaction_type .
            "s = " .
            $reaction_type .
            "s + 1, " .
            $other_reaction .
            "s = " .
            $other_reaction .
            "s - 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
    }
} else {
    // New reaction
    $sql =
        "INSERT INTO post_reactions (user_id, post_id, reaction_type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $user_id, $post_id, $reaction_type);
    $stmt->execute();

    // Increment the corresponding count in the posts table
    $sql =
        "UPDATE posts SET " .
        $reaction_type .
        "s = " .
        $reaction_type .
        "s + 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
}

// Return the updated counts
$sql = "SELECT likes, dislikes FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$counts = $result->fetch_assoc();

echo json_encode($counts);
?>
