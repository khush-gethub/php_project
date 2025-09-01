<?php
include 'includes/header.php';
include 'includes/db.php';

$categories = ['Games', 'Cars', 'Movie', 'Anime'];
?>

<div class="container mx-auto p-4">
    <h2 class="text-3xl font-bold my-4">Categories</h2>
    <div class="tabs tabs-lifted">
        <?php foreach ($categories as $category): ?>
            <a class="tab <?php echo (isset($_GET['category']) && $_GET['category'] == $category) ? 'tab-active' : ''; ?>"
                href="?category=<?php echo $category; ?>"><?php echo $category; ?></a>
        <?php endforeach; ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-10">
        <?php
        if (isset($_GET['category'])) {
            $category = $_GET['category'];
            $sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE category = ? ORDER BY posts.id DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $category);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC";
            $result = $conn->query($sql);
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card bg-base-200 shadow-xl'>";
                echo "<figure><img src='" . $row["image"] . "' alt='" . $row["title"] . "' class='h-48 w-full object-cover' /></figure>";
                echo "<div class='card-body'>";
                echo "<h2 class='card-title'>" . $row["title"] . "</h2>";
                echo "<p>by " . $row["username"] . "</p>";
                echo "<p>" . substr($row["description"], 0, 100) . "...</p>";
                echo "<div class='card-actions justify-end'>";
                echo "<a href='post.php?id=" . $row["id"] . "' class='btn btn-primary group'>Read More <span class='transition-transform duration-300 group-hover:translate-x-1'>→</span></a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No posts found in this category.</p>";
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>