<?php
include "includes/header.php";
include "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Check if the user is banned
$user_id = $_SESSION["user_id"];
$sql = "SELECT is_banned FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user["is_banned"]) {
    echo "<script>alert('You are banned and cannot create posts.'); window.location.href = 'index.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $category = $_POST["category"];
    $image = $_POST["image"]; // Assuming image is a URL for now
    $user_id = $_SESSION["user_id"];

    $sql =
        "INSERT INTO posts (title, description, category, image, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssi",
        $title,
        $description,
        $category,
        $image,
        $user_id,
    );

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }
}

$categories = ["Games", "Cars", "Movie", "Anime"];
?>

<div class="container mx-auto p-4">
    <h2 class="text-3xl font-bold my-4 mx-auto text-center">Create a New Post</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" class="max-w-3xl mx-auto">
        <div class="form-control">
            <label class="label">
                <span class="label-text">Title</span>
            </label>
            <input type="text" name="title" class="input input-bordered" required>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Description</span>
            </label>
            <textarea name="description" class="textarea textarea-bordered" required></textarea>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Category</span>
            </label>
            <select name="category" class="select select-bordered">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Image URL</span>
            </label>
            <input type="text" name="image" class="input input-bordered" required>
        </div>
        <div class="form-control mt-6">
            <button type="submit" class="btn btn-primary">Create Post</button>
        </div>
    </form>
</div>

<?php include "includes/footer.php"; ?>
