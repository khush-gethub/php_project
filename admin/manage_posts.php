<?php include 'admin_header.php'; ?>

<h2 class="text-3xl font-bold my-4">Manage Posts</h2>

<div class="overflow-x-auto">
  <table class="table w-full">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id";
      $result = $conn->query($sql);
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['title'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['category'] . "</td>";
        echo "<td>";
        echo "<a href='../post.php?id=" . $row['id'] . "' class='btn btn-xs btn-info'>View</a>";
        echo " <a href='edit_post.php?id=" . $row['id'] . "' class='btn btn-xs btn-warning'>Edit</a>";
        echo " <a href='delete_post.php?id=" . $row['id'] . "' class='btn btn-xs btn-error'>Delete</a>";
        echo "</td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<?php include 'admin_footer.php'; ?>