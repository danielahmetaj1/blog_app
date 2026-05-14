<?php
include 'partials/header.php';
//fetch postet qe jane featured
$featured_query = "SELECT * FROM posts WHERE is_featured=1";
$featured_result = mysqli_query($connection, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);
?>

<?php if(mysqli_num_rows($featured_result)==1): ?>
    <section class="featured">
        <div class="container featured__container">
            <div class="post_thumbnail">
                <img src="./images/<?= $featured['thumbnail'] ?>">
            </div>
            <div class="post_info">
                <?php 
                $category_id = $featured['category_id'];
                $category_query = "SELECT * FROM categories WHERE id=$category_id";
                $category_result = mysqli_query($connection, $category_query);
                $category = mysqli_fetch_assoc($category_result);
                ?>
                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
                <h2 class="post__title"><a href="post.html"><?= $featured['title'] ?></a></h2>
                <p class="post__body">
                 <?= substr($featured['body'], 0, 300) . '...' ?>
                </p>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="./images/avatar2.jpg" alt="">
                    </div>
                    <div class="post__author-info">
                        <h5>By: John Doe</h5>
                        <small>June 10, 2024 - 10:00</small>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <?php endif ?>
    <!-- =============fundi i feature post=========-->



    <section class="posts">
        <div class="container posts__container">
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/blog2.jpeg" alt="Post Thumbnail">
                </div>
                <div class="post__info">
                    <a href="" class="category__button">Wild Life</a>
                    <h3 class="post__title">
                        <a href="post.html">Lorem ipsum dolor sit amet</a>
                    </h3>
                    <p class="post__body">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Iure corporis placeat dolorem blanditiis ab molestias beatae voluptates
                        consequuntur, hic corrupti quisquam totam illum minima eaque, tempore accusantium eum dolore
                        ducimus!
                    </p>
                    <div class="post__author">
                        <div class="post__author-avatar">
                            <img src="./images/avatar3.jpg" alt="Author Avatar">
                        </div>
                        <div class="post__author-info">
                            <h5>By: Jane Doe</h5>
                            <small>June 12, 2024 - 14:30</small>
                        </div>
                    </div>
                </div>
            </article>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/blog2.jpeg" alt="Post Thumbnail">
                </div>
                <div class="post__info">
                    <a href="" class="category__button">Wild Life</a>
                    <h3 class="post__title">
                        <a href="post.html">Lorem ipsum dolor sit amet</a>
                    </h3>
                    <p class="post__body">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Iure corporis placeat dolorem blanditiis ab molestias beatae voluptates
                        consequuntur, hic corrupti quisquam totam illum minima eaque, tempore accusantium eum dolore
                        ducimus!
                    </p>
                    <div class="post__author">
                        <div class="post__author-avatar">
                            <img src="./images/avatar3.jpg" alt="Author Avatar">
                        </div>
                        <div class="post__author-info">
                            <h5>By: Jane Doe</h5>
                            <small>June 12, 2024 - 14:30</small>
                        </div>
                    </div>
                </div>
            </article>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/blog2.jpeg" alt="Post Thumbnail">
                </div>
                <div class="post__info">
                    <a href="" class="category__button">Wild Life</a>
                    <h3 class="post__title">
                        <a href="post.html">Lorem ipsum dolor sit amet</a>
                    </h3>
                    <p class="post__body">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Iure corporis placeat dolorem blanditiis ab molestias beatae voluptates
                        consequuntur, hic corrupti quisquam totam illum minima eaque, tempore accusantium eum dolore
                        ducimus!
                    </p>
                    <div class="post__author">
                        <div class="post__author-avatar">
                            <img src="./images/avatar3.jpg" alt="Author Avatar">
                        </div>
                        <div class="post__author-info">
                            <h5>By: Jane Doe</h5>
                            <small>June 12, 2024 - 14:30</small>
                        </div>
                    </div>
                </div>
            </article>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/blog2.jpeg" alt="Post Thumbnail">
                </div>
                <div class="post__info">
                    <a href="" class="category__button">Wild Life</a>
                    <h3 class="post__title">
                        <a href="post.html">Lorem ipsum dolor sit amet</a>
                    </h3>
                    <p class="post__body">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Iure corporis placeat dolorem blanditiis ab molestias beatae voluptates
                        consequuntur, hic corrupti quisquam totam illum minima eaque, tempore accusantium eum dolore
                        ducimus!
                    </p>
                    <div class="post__author">
                        <div class="post__author-avatar">
                            <img src="./images/avatar3.jpg" alt="Author Avatar">
                        </div>
                        <div class="post__author-info">
                            <h5>By: Jane Doe</h5>
                            <small>June 12, 2024 - 14:30</small>
                        </div>
                    </div>
                </div>
            </article>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/blog2.jpeg" alt="Post Thumbnail">
                </div>
                <div class="post__info">
                    <a href="" class="category__button">Wild Life</a>
                    <h3 class="post__title">
                        <a href="post.html">Lorem ipsum dolor sit amet</a>
                    </h3>
                    <p class="post__body">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Iure corporis placeat dolorem blanditiis ab molestias beatae voluptates
                        consequuntur, hic corrupti quisquam totam illum minima eaque, tempore accusantium eum dolore
                        ducimus!
                    </p>
                    <div class="post__author">
                        <div class="post__author-avatar">
                            <img src="./images/avatar3.jpg" alt="Author Avatar">
                        </div>
                        <div class="post__author-info">
                            <h5>By: Jane Doe</h5>
                            <small>June 12, 2024 - 14:30</small>
                        </div>
                    </div>
                </div>
            </article>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/blog2.jpeg" alt="Post Thumbnail">
                </div>
                <div class="post__info">
                    <a href="" class="category__button">Wild Life</a>
                    <h3 class="post__title">
                        <a href="post.html">Lorem ipsum dolor sit amet</a>
                    </h3>
                    <p class="post__body">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Iure corporis placeat dolorem blanditiis ab molestias beatae voluptates
                        consequuntur, hic corrupti quisquam totam illum minima eaque, tempore accusantium eum dolore
                        ducimus!
                    </p>
                    <div class="post__author">
                        <div class="post__author-avatar">
                            <img src="./images/avatar3.jpg" alt="Author Avatar">
                        </div>
                        <div class="post__author-info">
                            <h5>By: Jane Doe</h5>
                            <small>June 12, 2024 - 14:30</small>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
    <!-- =============fundi i postimeve=========-->

    <!-- =============kategorite e butonave=====-->
    <section class="category__buttons">
        <div class="container category__buttons-container">
            <a href="" class="category__button">Art</a>
            <a href="" class="category__button">Wild Life</a>
            <a href="" class="category__button">Travel</a>
            <a href="" class="category__button">Science & Technology</a>
            <a href="" class="category__button">Food</a>
            <a href="" class="category__button">Music</a>
        </div>
    </section>
    <!---Perfundimi i kategorive te butonave-->




    <?php 
    
    include'partials/footer.php'


    ?>