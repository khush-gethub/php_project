<?php
include 'includes/header.php';
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password == $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<div class="flex justify-center items-center min-h-screen">
    <div class="card w-96 bg-base-200 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Login</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" name="email" class="input input-bordered" required>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" name="password" class="input input-bordered" required>
                </div>
                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            <p class="text-center mt-4">Don't have an account? <a href="register.php" class="link">Register</a></p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>