<?php
include "includes/header.php";
include "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Check if user is banned
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user["is_banned"]) {
    echo "<script>alert('You are banned and cannot view your profile.'); window.location.href = 'index.php';</script>";
    exit();
}

// Fetch user's posts
$sql_posts = "SELECT * FROM posts WHERE user_id = ? ORDER BY id DESC";
$stmt_posts = $conn->prepare($sql_posts);
$stmt_posts->bind_param("i", $user_id);
$stmt_posts->execute();
$user_posts_result = $stmt_posts->get_result();
?>

<div class="container mx-auto p-4">
    <h2 class="text-3xl font-bold my-4">Profile</h2>
    <div class="card lg:card-side bg-base-100 shadow-xl mb-8">
        <figure><img src="<?php echo $user[
            "avatar"
        ]; ?>" alt="Avatar" class="w-48 h-48 rounded-full"></figure>
        <div class="card-body">
            <h2 class="card-title"><?php echo $user["username"]; ?></h2>
            <p>Email: <?php echo $user["email"]; ?></p>
            <p>Country: <?php echo $user["country"]; ?></p>
            <div class="card-actions justify-end">
                <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>

    <h3 class="text-2xl font-bold my-4">Your Posts</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php if ($user_posts_result->num_rows > 0) {
            while ($post = $user_posts_result->fetch_assoc()) {
                echo "<div class='card bg-base-200 shadow-xl'>";
                echo "<figure><img src='" .
                    $post["image"] .
                    "' alt='" .
                    $post["title"] .
                    "' /></figure>";
                echo "<div class='card-body'>";
                echo "<h2 class='card-title'>" . $post["title"] . "</h2>";
                echo "<p>" . substr($post["description"], 0, 100) . "...</p>";
                echo "<div class='card-actions justify-end'>";
                echo "<a href='post.php?id=" .
                    $post["id"] .
                    "' class='btn btn-info btn-sm'>View</a>";
                echo "<a href='edit_user_post.php?id=" .
                    $post["id"] .
                    "' class='btn btn-warning btn-sm'>Edit</a>";
                echo "<a href='delete_user_post.php?id=" .
                    $post["id"] .
                    "' class='btn btn-error btn-sm'>Delete</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>You haven't created any posts yet.</p>";
        } ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
