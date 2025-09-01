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
    $sql = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if (!$post) {
        // Post not found or does not belong to the user
        header("Location: profile.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $image = $_POST['image'];
    $post_id = $_POST['post_id'];

    $sql = "UPDATE posts SET title = ?, description = ?, category = ?, image = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $title, $description, $category, $image, $post_id, $user_id);
    $stmt->execute();

    header("Location: profile.php");
    exit();
}

$categories = ['Games', 'Cars', 'Movie', 'Anime'];
?>

<div class="container mx-auto p-4">
    <h2 class="text-3xl font-bold my-4">Edit Your Post</h2>
    <?php if (isset($post)): ?>
        <div class="card bg-base-100 shadow-xl p-6">
            <form method="POST">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Title</span>
                    </label>
                    <input type="text" name="title" class="input input-bordered"
                        value="<?php echo htmlspecialchars($post['title']); ?>" required>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Description</span>
                    </label>
                    <textarea name="description" class="textarea textarea-bordered"
                        required><?php echo htmlspecialchars($post['description']); ?></textarea>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Category</span>
                    </label>
                    <select name="category" class="select select-bordered">
                        <?php foreach ($categories as $category_name): ?>
                            <option value="<?php echo htmlspecialchars($category_name); ?>" <?php if ($post['category'] == $category_name)
                                   echo 'selected'; ?>>
                                <?php echo htmlspecialchars($category_name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Image URL</span>
                    </label>
                    <input type="text" name="image" class="input input-bordered"
                        value="<?php echo htmlspecialchars($post['image']); ?>">
                </div>
                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary">Update Post</button>
                    <a href="profile.php" class="btn btn-ghost mt-2">Cancel</a>
                </div>
            </form>
        </div>
    <?php else: ?>
        <p class="text-center text-2xl mt-10">Post not found or you don't have permission to edit it.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>