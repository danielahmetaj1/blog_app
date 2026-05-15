<?php
include 'partials/header.php';

//bejme fetch post nga databaza nese id eshte i vendosur ne url
if(isset($_GET['id'])){
    $id = (int) filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
}
else{
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

   <!---==============fillimi i single post ===================-->
    <section class="singlepost">
        <div class="container singlepost__container">
            <h2><?= $post['title'] ?></h2>
            <div class="post__author">
                        <?php 
                    //bejme fetch te userit qe ka shkruar postin
                    $user_id = (int) $post['user_id'];
                    $user_query = "SELECT * FROM users WHERE user_id=$user_id";
                    $user_result = mysqli_query($connection, $user_query);
                    $user = mysqli_fetch_assoc($user_result);
                    ?>
                        <div class="post__author-avatar">
                            <img src="./images/<?= $user['avatar'] ?>" alt="Author Avatar">
                        </div>
                        <div class="post__author-info">
                             <h5>By: <?= $user['username'] ?></h5>
                            <small>
                                 <?= date('M d, Y - H:i', strtotime($post['created_at'])) ?> 
                            </small>
                        </div>
                    </div>
                    <div class="singlepost__thumbnail">
                        <img src="./images/<?= $post['thumbnail'] ?>" >
                    </div>
                    <p>
                    <?= $post['body'] ?>
                    </p>
        </div>
    </section>
<!--==============perfundimi i single post -->
<?php
include 'partials/footer.php';
?>