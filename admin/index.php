<?php
include 'partials/header.php';

//bejme fetch postet e userit aktual
$current_user_id = $_SESSION['user_id'];
$querry= "SELECT id, title, category_id FROM posts WHERE user_id=$current_user_id ORDER BY id DESC";
$posts = mysqli_query($connection, $querry);
?>



<section class="dashboard">
    <?php if(isset($_SESSION['add-post-success'])): ?> 
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['add-post-success'];
                        unset($_SESSION['add-post-success']);
                        ?>
                    </p>
                </div>
                 <?php elseif(isset($_SESSION['edit-post-success'])): ?> 
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['edit-post-success'];
                        unset($_SESSION['edit-post-success']);
                        ?>
                    </p>
                </div>
    <?php endif ?>
    <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>

        <aside>
            <ul>
                <li><a href="add-post.php"><i class="uil uil-pen"></i>
                        <h5>Add Post</h5>

                    </a>
                </li>
                <li><a href="index.php" class="active"><i class="uil uil-postcard"></i>
                        <h5>Manage Posts</h5>

                    </a>
                </li>
                <?php  if(isset($_SESSION['user_is_admin'])): ?>
                <li><a href="add-user.php"><i class="uil uil-user-plus"></i>
                        <h5>Add User</h5>

                    </a>
                </li>
                <li><a href="manage-users.php"><i class="uil uil-users-alt"></i>
                        <h5>Manage Users</h5>

                    </a>
                </li>
                <li><a href="add-category.php"><i class="uil uil-edit"></i>
                        <h5>Add Category</h5>
                    </a>
                </li>
                <li><a href="manage-categories.php"><i class="uil uil-list-ul"></i>
                        <h5>Manage Categories</h5>

                    </a>
                </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Posts</h2>
            <?php if(mysqli_num_rows($posts) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Titulli</th>
                        <th>Kategori</th>
                        <th>Edito</th>
                        <th>Fshi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($post = mysqli_fetch_assoc($posts)) : ?>
                        <?php //bejme fetch te kategorise se postit
                        $category_id = $post['category_id'];
                        $category_querry = "SELECT title FROM categories WHERE id=$category_id";
                        $category_result = mysqli_query($connection, $category_querry);
                        $category = mysqli_fetch_assoc($category_result);
                            ?>
                    <tr>
                        <td><?= $post['title'] ?> </td>
                        <td><?= $category['title'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-post.php?id=<?= $post['id'] ?>" class="btn sm danger">Fshi</a></td>

                    </tr>
                    <?php endwhile ?>

                </tbody>
            </table>
            <?php else: ?>
           <div class="alert__message error">  <?= "nuk u gjend asnje post" ?>
           </div>
           <?php endif ?>
        </main>
    </div>
</section>


<?php
include '../partials/footer.php';
?>