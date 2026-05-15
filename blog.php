<?php
include 'partials/header.php';
//bejm fetch te gjitha postimet
$query = "SELECT * FROM posts ORDER BY created_at DESC";
$posts = mysqli_query($connection, $query);
?>


    <!--=============fillimi i search =================-->
    <section class="search__bar">
        <form class="container search__bar-contaainer" action="<?= ROOT_URL ?>search.php" method="GET">
            <div>
                <i class="uil uil-search"></i>
                <input type="search" name="search" placeholder="Search">
            </div>
            <button type="submit" class="btn">Go</button>
        </form>
    </section>
<!--==========Fundi i search ===============-->


       <section class="posts">
            <div class="container posts__container">
                <?php while($post = mysqli_fetch_assoc($posts)): ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="./images/<?= $post['thumbnail'] ?>" alt="Post Thumbnail">
                    </div>
                    <div class="post__info">
                        <?php 
                    $category_id = (int) $post['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id=$category_id";
                    $category_result = mysqli_query($connection, $category_query);
                    $category = mysqli_fetch_assoc($category_result);
                    ?>
                        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
                        <h3 class="post__title">
                            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                        </h3>
                        <p class="post__body">
                        <?= substr($post['body'], 0, 150) . '...' ?>
                        </p>
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
                    </div>
                </article>
            <?php endwhile ?>
            </div>
        </section>
    <!-- =============fundi i postimeve=========-->

    <!-- =============kategorite e butonave=====-->
    <section class="category__buttons">
        <div class="container category__buttons-container">
            <?php 
            $all_categories_query = "SELECT * FROM categories";
            $all_categories_result = mysqli_query($connection, $all_categories_query);
            ?> 
            <?php while($category = mysqli_fetch_assoc($all_categories_result)): ?>
             <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>

            <?php endwhile ?>
    
        </div>
    </section>
    <!---Perfundimi i kategorive te butonave-->


<?php
include 'partials/footer.php';
?>