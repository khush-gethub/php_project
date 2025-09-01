<?php
include 'includes/header.php';
include 'includes/db.php';
?>

<div class="container mx-auto p-4">
    <h2 class="text-3xl font-bold my-4">All Posts</h2>
    <form method="GET" class="flex gap-2 my-4">
        <input type="text" name="search" placeholder="Search posts..." class="input input-bordered w-full mb-5"
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <select name="category" class="select select-bordered">
            <option value="">All Categories</option>
            <option value="Games" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Games') ? 'selected' : ''; ?>>Games</option>
            <option value="Cars" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Cars') ? 'selected' : ''; ?>>Cars</option>
            <option value="Movie" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Movie') ? 'selected' : ''; ?>>Movie</option>
            <option value="Anime" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Anime') ? 'selected' : ''; ?>>Anime</option>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php
        $search = isset($_GET['search']) && $_GET['search'] != '' ? "%" . $_GET['search'] . "%" : null;
        $category = isset($_GET['category']) && $_GET['category'] != '' ? $_GET['category'] : null;

        $sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id";
        $params = [];
        $types = "";

        $whereClauses = [];
        if ($search) {
            $whereClauses[] = "(title LIKE ? OR description LIKE ?)";
            $params[] = $search;
            $params[] = $search;
            $types .= "ss";
        }
        if ($category) {
            $whereClauses[] = "category = ?";
            $params[] = $category;
            $types .= "s";
        }

        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $sql .= " ORDER BY posts.id DESC";

        if (!empty($params)) {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
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
            echo "<p>No posts found.</p>";
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>