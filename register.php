<?php
include 'includes/header.php';
include 'includes/db.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $country = $_POST['country'];
    $avatar = getRandomAvatar();

    $sql = "INSERT INTO users (username, email, password, country, avatar) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $email, $password, $country, $avatar);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<div class="flex justify-center items-center min-h-screen">
    <div class="card w-96 bg-base-200 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Register</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Username</span>
                    </label>
                    <input type="text" name="username" class="input input-bordered" required>
                </div>
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
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Country</span>
                    </label>
                    <select name="country" id="country-select" class="select select-bordered" required>
                        <option disabled selected>Select a country</option>
                    </select>
                </div>
                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
            <p class="text-center mt-4">Already have an account? <a href="login.php" class="link">Login</a></p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        axios.get('country_names.json')
            .then(function (response) {
                const countries = response.data.countries_names;
                const select = document.getElementById('country-select');
                countries.forEach(function (country) {
                    const option = document.createElement('option');
                    option.value = country;
                    option.textContent = country;
                    select.appendChild(option);
                });
            })
            .catch(function (error) {
                console.error('Error fetching country data:', error);
            });
    });
</script>