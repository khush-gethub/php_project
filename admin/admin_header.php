<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
  header("Location: ../login.php");
  exit();
}
include '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="en" data-theme="night">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body class="bg-base-100">
  <div class="navbar bg-base-100">
    <div class="flex-1">
      <a class="btn btn-ghost text-xl" href="index.php">Admin Panel</a>
    </div>
    <div class="flex-none">
      <ul class="menu menu-horizontal px-1">
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_posts.php">Manage Posts</a></li>
        <li><a href="../index.php">Back to Site</a></li>
      </ul>
    </div>
  </div>
  <div class="container mx-auto p-4">