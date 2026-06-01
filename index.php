<?php
include 'partials/header.php';

$featured_result = mysqli_query($connection, "SELECT * FROM posts WHERE is_featured=1 LIMIT 1");
$featured = mysqli_fetch_assoc($featured_result);

$posts = mysqli_query($connection, "SELECT * FROM posts ORDER BY created_at DESC LIMIT 9");
?>

<?php if($featured): ?>
<?php
    $fid   = (int) $featured['id'];
    $f_cat = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM categories WHERE id=".(int)$featured['category_id']));
    $f_usr = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE user_id=".(int)$featured['user_id']));
    $f_lc  = (int) mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS t FROM likes WHERE post_id=$fid"))['t'];
    $f_cc  = (int) mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS t FROM comments WHERE post_id=$fid"))['t'];
?>
<section class="featured">
    <div class="container featured__container">
        <div class="post_thumbnail">
            <img src="<?= ROOT_URL ?>images/<?= htmlspecialchars($featured['thumbnail']) ?>" alt="Postim i vecuar">
        </div>
        <div class="post_info">
            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $featured['category_id'] ?>" class="category__button">
                <?= htmlspecialchars($f_cat['title'] ?? 'Pa kategori') ?>
            </a>
            <h2 class="post__title">
                <a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= htmlspecialchars($featured['title']) ?></a>
            </h2>
            <p class="post__body"><?= htmlspecialchars(substr($featured['body'], 0, 280)) ?>...</p>
            <div class="post__meta">
                <span class="post__meta-item"><i class="uil uil-thumbs-up"></i> <?= $f_lc ?></span>
                <span class="post__meta-item"><i class="uil uil-comment-dots"></i> <?= $f_cc ?></span>
            </div>
            <div class="post__author">
                <div class="post__author-avatar">
                    <img src="<?= ROOT_URL ?>images/<?= htmlspecialchars($f_usr['avatar']) ?>" alt="">
                </div>
                <div class="post__author-info">
                    <h5>Nga: <?= htmlspecialchars($f_usr['username']) ?></h5>
                    <small><?= date('d M, Y', strtotime($featured['created_at'])) ?></small>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif ?>

<section class="posts <?= $featured ? '' : 'section__extra-margin' ?>">
    <div class="container posts__container">
        <?php while($post = mysqli_fetch_assoc($posts)):
            $pid = (int) $post['id'];
            $cat = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM categories WHERE id=".(int)$post['category_id']));
            $usr = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE user_id=".(int)$post['user_id']));
            $lc  = (int) mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS t FROM likes WHERE post_id=$pid"))['t'];
            $cc  = (int) mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS t FROM comments WHERE post_id=$pid"))['t'];
        ?>
        <article class="post">
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

<?php include 'partials/footer.php'; ?>
