<?php
include 'includes/header.php';
include 'includes/db.php';

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "SELECT posts.*, users.username, users.avatar FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
}
?>

<div class="container mx-auto p-4">
    <?php if (isset($post)):
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $current_user = $result->fetch_assoc();

            if ($current_user['is_banned']) {
                echo "<div class='alert alert-error'>You are banned from this site.</div>";
                die();
            }
        }

        ?>
        <div class="max-w-4xl mx-auto bg-base-200 shadow-xl rounded-lg overflow-hidden">
            <figure>
                <img src="<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>"
                    class="w-full h-96 object-cover">
            </figure>
            <div class="p-8">
                <h1 class="text-4xl font-bold mb-4"><?php echo $post['title']; ?></h1>
                <div class="flex items-center mb-6">
                    <div class="avatar mr-4">
                        <div class="w-12 h-12 rounded-full">
                            <img src="<?php echo $post['avatar']; ?>" alt="Author Avatar" />
                        </div>
                    </div>
                    <div>
                        <p class="text-lg font-semibold"><?php echo $post['username']; ?></p>
                        <p class="text-sm text-gray-500">Posted on:
                            <?php echo date('F j, Y', strtotime($post['created_at'])); ?></p>
                    </div>
                </div>
                <p class="text-lg leading-relaxed mb-8"><?php echo $post['description']; ?></p>

                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button class="btn btn-ghost" onclick="handleReaction('like', <?php echo $post['id']; ?>)">
                            <i data-lucide="thumbs-up"></i>
                            <span id="likes-count"><?php echo $post['likes']; ?></span>
                        </button>
                        <button class="btn btn-ghost" onclick="handleReaction('dislike', <?php echo $post['id']; ?>)">
                            <i data-lucide="thumbs-down"></i>
                            <span id="dislikes-count"><?php echo $post['dislikes']; ?></span>
                        </button>
                    </div>
                    <div class="badge badge-primary px-5 py-3"><?php echo $post['category']; ?></div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center text-2xl mt-10">Post not found.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>

<script>
    function handleReaction(reactionType, postId) {
        const formData = new URLSearchParams();
        formData.append('post_id', postId);
        formData.append('reaction_type', reactionType);

        axios.post('handle_reaction.php', formData)
            .then(function (response) {
                const data = response.data;
                if (data.error) {
                    alert(data.error);
                } else {
                    document.getElementById('likes-count').innerText = data.likes;
                    document.getElementById('dislikes-count').innerText = data.dislikes;
                }
            })
            .catch(function (error) {
                console.error('Error handling reaction:', error);
            });
    }
</script>