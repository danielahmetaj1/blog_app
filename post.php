<?php
include 'partials/header.php';

if (isset($_GET['id'])) {
    $id = (int) filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $result = mysqli_query($connection, "SELECT * FROM posts WHERE id=$id");
    $post = mysqli_fetch_assoc($result);
    if (!$post) { header('location: ' . ROOT_URL . 'blog.php'); die(); }
} else {
    header('location: ' . ROOT_URL . 'blog.php'); die();
}

$author      = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE user_id=".(int)$post['user_id']));
$like_count  = (int) mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS t FROM likes WHERE post_id=$id"))['t'];
$share_count = (int) mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS t FROM shares WHERE post_id=$id"))['t'];

$user_liked = false;
if (isset($_SESSION['user-id'])) {
    $uid = (int) $_SESSION['user-id'];
    $user_liked = mysqli_num_rows(mysqli_query($connection, "SELECT id FROM likes WHERE post_id=$id AND user_id=$uid")) > 0;
}

$comments_result = mysqli_query($connection,
    "SELECT c.id, c.body, c.created_at, u.username, u.avatar
     FROM comments c JOIN users u ON c.user_id = u.user_id
     WHERE c.post_id = $id ORDER BY c.created_at DESC"
);
$comment_count = mysqli_num_rows($comments_result);
$comments = [];
while ($row = mysqli_fetch_assoc($comments_result)) $comments[] = $row;

$post_url       = urlencode(ROOT_URL . 'post.php?id=' . $id);
$post_title_enc = urlencode($post['title']);
?>

<section class="singlepost">
    <div class="container singlepost__container">

        <a href="<?= ROOT_URL ?>blog.php#post-<?= $id ?>" class="singlepost__back" id="back-btn">
            <i class="uil uil-arrow-left"></i> Kthehu te Blog
        </a>

        <h2><?= htmlspecialchars($post['title']) ?></h2>

        <div class="post__author">
            <div class="post__author-avatar">
                <img src="<?= ROOT_URL ?>images/<?= htmlspecialchars($author['avatar']) ?>" alt="">
            </div>
            <div class="post__author-info">
                <h5>Nga: <?= htmlspecialchars($author['username']) ?></h5>
                <small><?= date('d M, Y · H:i', strtotime($post['created_at'])) ?></small>
            </div>
        </div>

        <div class="singlepost__thumbnail">
            <img src="<?= ROOT_URL ?>images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="Miniatura e postimit">
        </div>

        <p><?= nl2br(htmlspecialchars($post['body'])) ?></p>

        <!-- Interactions -->
        <div class="post__interactions">
            <button class="interaction__btn <?= $user_liked ? 'liked' : '' ?>"
                    id="like-btn" data-post-id="<?= $id ?>"
                    title="<?= !isset($_SESSION['user-id']) ? 'Kycu per te pelqyer' : '' ?>">
                <i class="uil uil-thumbs-up"></i>
                <span id="like-count"><?= $like_count ?></span>
                <span>Pelqim<?= $like_count !== 1 ? 'e' : '' ?></span>
            </button>

            <a href="#comments-section" class="interaction__btn">
                <i class="uil uil-comment-dots"></i>
                <span id="comment-count-bar"><?= $comment_count ?></span>
                <span>Koment<?= $comment_count !== 1 ? 'e' : '' ?></span>
            </a>

            <div class="share__group">
                <span class="share__label"><i class="uil uil-share-alt"></i> Shperndaj</span>
                <div class="share__buttons">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $post_url ?>"
                       target="_blank" rel="noopener" class="share__btn share__btn--facebook"
                       data-platform="facebook" data-post-id="<?= $id ?>" title="Facebook">
                        <i class="uil uil-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?= $post_url ?>&text=<?= $post_title_enc ?>"
                       target="_blank" rel="noopener" class="share__btn share__btn--twitter"
                       data-platform="twitter" data-post-id="<?= $id ?>" title="Twitter">
                        <i class="uil uil-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?url=<?= $post_url ?>"
                       target="_blank" rel="noopener" class="share__btn share__btn--linkedin"
                       data-platform="linkedin" data-post-id="<?= $id ?>" title="LinkedIn">
                        <i class="uil uil-linkedin"></i>
                    </a>
                    <button class="share__btn share__btn--copy"
                            data-platform="copy" data-post-id="<?= $id ?>" title="Kopjo linkun">
                        <i class="uil uil-copy"></i>
                    </button>
                </div>
                <span id="share-count" class="share__count"><?= $share_count ?> shperndarje</span>
            </div>
        </div>

        <!-- Comments -->
        <div class="comments__section" id="comments-section">

            <h4 class="comments__title">
                <i class="uil uil-comments"></i>
                Komente (<span id="comment-count"><?= $comment_count ?></span>)
            </h4>

            <?php if (isset($_SESSION['user-id'])): ?>
            <form class="comment__form" id="comment-form">
                <input type="hidden" name="post_id" value="<?= $id ?>">
                <textarea name="body" id="comment-body" placeholder="Shkruaj komentin tend..." rows="3" required></textarea>
                <button type="submit" class="btn">Posto Komentin</button>
            </form>
            <?php else: ?>
            <p class="comment__login-notice">
                <a href="<?= ROOT_URL ?>signin.php">Kycu</a> per te lene koment.
            </p>
            <?php endif; ?>

            <div class="comment__list" id="comment-list">
                <?php foreach ($comments as $c): ?>
                <div class="comment__item">
                    <div class="comment__avatar">
                        <img src="<?= ROOT_URL ?>images/<?= htmlspecialchars($c['avatar']) ?>" alt="">
                    </div>
                    <div class="comment__body">
                        <div class="comment__meta">
                            <strong><?= htmlspecialchars($c['username']) ?></strong>
                            <small><?= date('d M, Y · H:i', strtotime($c['created_at'])) ?></small>
                        </div>
                        <p><?= nl2br(htmlspecialchars($c['body'])) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </div>

    </div>
</section>

<script>
const POST_ID   = <?= $id ?>;
const ROOT_URL  = '<?= ROOT_URL ?>';
const IS_LOGGED = <?= isset($_SESSION['user-id']) ? 'true' : 'false' ?>;
const POST_URL  = '<?= ROOT_URL ?>post.php?id=<?= $id ?>';
</script>
<script src="<?= ROOT_URL ?>js/post-interactions.js"></script>

<?php include 'partials/footer.php'; ?>
