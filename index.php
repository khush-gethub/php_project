<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<div class="hero min-h-[40rem] rounded-box overflow-hidden">
  <div class="hero-overlay"></div>
  <div class="hero-content text-center text-neutral-content">
    <div class="max-w-md">
      <?php if (isset($_SESSION['user_id'])): ?>
        <h1 class="mb-5 text-5xl font-bold">Welcome back, <?php echo $_SESSION['username']; ?>!</h1>
        <p class="mb-5">Explore the latest posts from your college community.</p>
        <a href="all_posts.php" class="btn btn-primary">View All Posts</a>
      <?php else: ?>
        <h1 class="mb-5 text-7xl font-bold">Welcome to Buzzy</h1>
        <p class="mb-5">Connect with your peers, share your thoughts, and explore a world of ideas.</p>
        <a href="register.php" class="btn btn-primary">Get Started</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="container mx-auto p-4">
  <h2 class="text-3xl font-bold my-4">Latest Posts</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php
    $sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC LIMIT 6";
    $result = $conn->query($sql);

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