<?php include 'admin_header.php'; ?>

<h2 class="text-3xl font-bold my-4">Admin Dashboard</h2>

<div class="stats shadow">

  <div class="stat">
    <div class="stat-figure text-primary">
      <i data-lucide="users"></i>
    </div>
    <div class="stat-title">Total Users</div>
    <div class="stat-value">
      <?php
      $sql = "SELECT COUNT(*) as count FROM users";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      echo $row['count'];
      ?>
    </div>
  </div>

  <div class="stat">
    <div class="stat-figure text-secondary">
      <i data-lucide="file-text"></i>
    </div>
    <div class="stat-title">Total Posts</div>
    <div class="stat-value">
      <?php
      $sql = "SELECT COUNT(*) as count FROM posts";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      echo $row['count'];
      ?>
    </div>
  </div>

</div>

<?php include 'admin_footer.php'; ?>