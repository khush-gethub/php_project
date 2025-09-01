<?php
include 'admin_header.php';

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $image = $_POST['image'];
    $post_id = $_POST['post_id'];

    $sql = "UPDATE posts SET title = ?, description = ?, category = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $description, $category, $image, $post_id);
    $stmt->execute();

    header("Location: manage_posts.php");
    exit();
}

$categories = ['Games', 'Cars', 'Movie', 'Anime'];
?>

<h2 class="text-3xl font-bold my-4">Edit Post</h2>

<form method="POST">
    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
    <div class="form-control">
        <label class="label">
            <span class="label-text">Title</span>
        </label>
        <input type="text" name="title" class="input input-bordered" value="<?php echo $post['title']; ?>" required>
    </div>
    <div class="form-control">
        <label class="label">
            <span class="label-text">Description</span>
        </label>
        <textarea name="description" class="textarea textarea-bordered"
            required><?php echo $post['description']; ?></textarea>
    </div>
    <div class="form-control">
        <label class="label">
            <span class="label-text">Category</span>
        </label>
        <select name="category" class="select select-bordered">
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category; ?>" <?php if ($post['category'] == $category)
                       echo 'selected'; ?>>
                    <?php echo $category; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-control">
        <label class="label">
            <span class="label-text">Image URL</span>
        </label>
        <input type="text" name="image" class="input input-bordered" value="<?php echo $post['image']; ?>">
    </div>
    <div class="form-control mt-6">
        <button type="submit" class="btn btn-primary">Update Post</button>
    </div>
</form>

<?php include 'admin_footer.php'; ?>