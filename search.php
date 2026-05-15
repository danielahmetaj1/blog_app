<?php
include 'partials/header.php';

$search = trim($_GET['search'] ?? '');

if(!$search){
    header('Location: ' . ROOT_URL . 'blog.php');
    exit;
}

$safe_search = mysqli_real_escape_string($connection, $search);
$query = "SELECT * FROM posts WHERE title LIKE '%$safe_search%' OR body LIKE '%$safe_search%' ORDER BY created_at DESC";
$posts = mysqli_query($connection, $query);
$posts_count = $posts ? mysqli_num_rows($posts) : 0;
?>

<section class="search__bar">
    <form class="container search__bar-contaainer" action="<?= ROOT_URL ?>search.php" method="GET">
        <div>
            <i class="uil uil-search"></i>
            <input type="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search">
        </div>
        <button type="submit" class="btn">Go</button>
    </form>
</section>

<section class="posts">
    <div class="container posts__container">
        <div class="search__results">
            <h2>Search results for "<?= htmlspecialchars($search) ?>"</h2>
            <p><?= $posts_count ?> result<?= $posts_count === 1 ? '' : 's' ?> found.</p>
        </div>

        <?php if($posts_count > 0): ?>
            <?php while($post = mysqli_fetch_assoc($posts)): ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="./images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="Post Thumbnail">
                    </div>
                    <div class="post__info">
                        <?php 
                            $category_id = (int) $post['category_id'];
                            $category_query = "SELECT * FROM categories WHERE id=$category_id";
                            $category_result = mysqli_query($connection, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                        ?>
                        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= htmlspecialchars($category['title']) ?></a>
                        <h3 class="post__title">
                            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a>
                        </h3>
                        <p class="post__body">
                            <?= htmlspecialchars(substr($post['body'], 0, 150)) . '...' ?>
                        </p>
                        <div class="post__author">
                            <?php 
                                $user_id = (int) $post['user_id'];
                                $user_query = "SELECT * FROM users WHERE user_id=$user_id";
                                $user_result = mysqli_query($connection, $user_query);
                                $user = mysqli_fetch_assoc($user_result);
                            ?>
                            <div class="post__author-avatar">
                                <img src="./images/<?= htmlspecialchars($user['avatar'] ?? 'avatar1.jpg') ?>" alt="Author Avatar">
                            </div>
                            <div class="post__author-info">
                                <h5>By: <?= htmlspecialchars($user['username'] ?? 'Unknown') ?></h5>
                                <small><?= date('M d, Y - H:i', strtotime($post['created_at'])) ?></small>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endwhile ?>
        <?php else: ?>
            <div class="empty__search-message">
                <p>No posts matched your search. Try a different keyword.</p>
            </div>
        <?php endif ?>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
