<?php
include 'partials/header.php';
$posts = mysqli_query($connection, "SELECT * FROM posts ORDER BY created_at DESC");
?>

<section class="search__bar">
    <form class="container search__bar-wrapper" action="<?= ROOT_URL ?>search.php" method="GET">
        <div class="search__bar-container">
            <i class="uil uil-search"></i>
            <input type="search" name="search" placeholder="Kerko postime...">
        </div>
        <button type="submit" class="search__submit"><i class="uil uil-search"></i></button>
    </form>
</section>

<section class="posts">
    <div class="container posts__container">
        <?php while($post = mysqli_fetch_assoc($posts)):
            $pid = (int) $post['id'];
            $cat = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM categories WHERE id=".(int)$post['category_id']));
            $usr = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE user_id=".(int)$post['user_id']));
            $lc  = (int) mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS t FROM likes WHERE post_id=$pid"))['t'];
            $cc  = (int) mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS t FROM comments WHERE post_id=$pid"))['t'];
        ?>
        <article class="post" id="post-<?= $post['id'] ?>">
            <div class="post__thumbnail">
                <img src="<?= ROOT_URL ?>images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="Miniatura e postimit">
            </div>
            <div class="post__info">
                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category__button">
                    <?= htmlspecialchars($cat['title'] ?? 'Pa kategori') ?>
                </a>
                <h3 class="post__title">
                    <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a>
                </h3>
                <p class="post__body"><?= htmlspecialchars(substr($post['body'], 0, 130)) ?>...</p>
                <div class="post__meta">
                    <span class="post__meta-item"><i class="uil uil-thumbs-up"></i> <?= $lc ?></span>
                    <span class="post__meta-item"><i class="uil uil-comment-dots"></i> <?= $cc ?></span>
                </div>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="<?= ROOT_URL ?>images/<?= htmlspecialchars($usr['avatar']) ?>" alt="">
                    </div>
                    <div class="post__author-info">
                        <h5>Nga: <?= htmlspecialchars($usr['username']) ?></h5>
                        <small><?= date('d M, Y', strtotime($post['created_at'])) ?></small>
                    </div>
                </div>
            </div>
        </article>
        <?php endwhile ?>
    </div>
</section>

<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
        $cats = mysqli_query($connection, "SELECT * FROM categories");
        while($c = mysqli_fetch_assoc($cats)):
        ?>
        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $c['id'] ?>" class="category__button">
            <?= htmlspecialchars($c['title']) ?>
        </a>
        <?php endwhile ?>
    </div>
</section>

<script>
// Rikthe scroll-in kur kthehesh nga nje post
const hash = window.location.hash;
if (hash && hash.startsWith('#post-')) {
    const el = document.querySelector(hash);
    if (el) {
        setTimeout(() => {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            el.style.outline = '2px solid var(--color-primary)';
            el.style.borderColor = 'var(--color-primary)';
            setTimeout(() => {
                el.style.outline = '';
                el.style.borderColor = '';
            }, 1800);
        }, 120);
    }
}
</script>

<?php include 'partials/footer.php'; ?>
