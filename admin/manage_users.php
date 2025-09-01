<?php include 'admin_header.php'; ?>

<h2 class="text-3xl font-bold my-4">Manage Users</h2>

<div class="overflow-x-auto">
  <table class="table w-full">
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Country</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT * FROM users";
      $result = $conn->query($sql);
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['country'] . "</td>";
        echo "<td>" . ($row['is_banned'] ? '<span class="badge badge-error">Banned</span>' : '<span class="badge badge-success">Active</span>') . "</td>";
        echo "<td>";
        if ($row['is_banned']) {
          echo "<a href='ban_user.php?id=" . $row['id'] . "&action=unban' class='btn btn-xs btn-success'>Unban</a>";
        } else {
          echo "<a href='ban_user.php?id=" . $row['id'] . "&action=ban' class='btn btn-xs btn-error'>Ban</a>";
        }
        echo "</td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<?php include 'admin_footer.php'; ?>