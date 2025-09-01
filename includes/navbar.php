<div class="navbar bg-base-100">
  <div class="flex-1">
    <a href="index.php">
      <img id="logo-image" src="assets/images/logo/for dark themes.png" alt="Buzzy Logo" class="h-7 ml-3 ">
    </a>
  </div>
  <div class="flex-none">
    <ul class="menu menu-horizontal px-1">
      <li><a href="index.php">Home</a></li>
      <li><a href="all_posts.php">All Posts</a></li>
      <li><a href="categories.php">Categories</a></li>
      <li><a href="about.php">About</a></li>
      <?php if (isset($_SESSION['user_id'])):
        if ($_SESSION['is_admin'] == 1): ?>
          <li><a href="admin">Admin</a></li>
        <?php endif; ?>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="create_post.php">Create Post</a></li>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
      <?php endif; ?>
    </ul>
    <div class="dropdown dropdown-end">
      <label tabindex="0" class="btn btn-ghost">
        <i data-lucide="swatch-book"></i>
      </label>
      <ul tabindex="0" class="menu dropdown-content z-[1] p-2 shadow bg-base-100 rounded-box w-52 mt-4">
        <li onclick="changeTheme('night')"><a>Night</a></li>
        <li onclick="changeTheme('sunset')"><a>Sunset</a></li>
        <li onclick="changeTheme('bumblebee')"><a>Bumblebee</a></li>
        <li onclick="changeTheme('garden')"><a>Garden</a></li>
      </ul>
    </div>
  </div>
</div>

<script>
  const logoImage = document.getElementById('logo-image');
  const darkLogo = 'assets/images/logo/for dark themes.png';
  const lightLogo = 'assets/images/logo/for light themes.png';

  function updateLogo(theme) {
    if (theme === 'night' || theme === 'sunset') {
      logoImage.src = darkLogo;
    } else {
      logoImage.src = lightLogo;
    }
  }

  function changeTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    updateLogo(theme);
  }

  document.addEventListener('DOMContentLoaded', (event) => {
    const savedTheme = localStorage.getItem('theme') || 'night';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateLogo(savedTheme);
  });
</script>