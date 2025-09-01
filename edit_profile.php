<?php
include 'includes/header.php';
include 'includes/db.php';
include 'includes/functions.php'; // For getRandomAvatar if needed

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    // User not found, redirect or show error
    header("Location: profile.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $country = $_POST['country'];

    $sql = "UPDATE users SET username = ?, email = ?, country = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $email, $country, $user_id);

    if ($stmt->execute()) {
        // Update session username if changed
        $_SESSION['username'] = $username;
        header("Location: profile.php");
        exit();
    } else {
        $error = "Error updating profile: " . $stmt->error;
    }
}

// Fetch countries for dropdown
$countries_json = file_get_contents('country_names.json');
$countries_data = json_decode($countries_json, true);
$countries = $countries_data['countries_names'];

?>

<div class="container mx-auto p-4">
    <h2 class="text-3xl font-bold my-4">Edit Profile</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    <div class="card bg-base-100 shadow-xl p-6">
        <form method="POST">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Username</span>
                </label>
                <input type="text" name="username" class="input input-bordered"
                    value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" name="email" class="input input-bordered"
                    value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Country</span>
                </label>
                <select name="country" class="select select-bordered" required>
                    <?php foreach ($countries as $country_name): ?>
                        <option value="<?php echo htmlspecialchars($country_name); ?>" <?php echo ($user['country'] == $country_name) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($country_name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="profile.php" class="btn btn-ghost mt-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>