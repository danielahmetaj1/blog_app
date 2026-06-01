<?php
include 'partials/header.php';

//kategorite  fetch nga databaza
$query = "SELECT * FROM categories ORDER BY  title DESC";
$categories = mysqli_query($connection,$query);
?>



<section class="dashboard">

<?php if(isset($_SESSION['add-category-success']))://nese kategoria u shtua me sukses ?> 
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['add-category-success'];
                        unset($_SESSION['add-category-success']);
                        ?>
                    </p>
                </div>
                
 <?php elseif(isset($_SESSION['add-category']))://nese kategoria nuk u shtua me sukses ?> 
                <div class="alert__message error container">
                    <p>
                        <?= $_SESSION['add-category'];
                        unset($_SESSION['add-category']);
                        ?>
                    </p>
                </div>
                <?php elseif(isset($_SESSION['edit-category']))://nese editimi i kategorise nuk u be me sukses ?> 
                <div class="alert__message error container">
                    <p>
                        <?= $_SESSION['edit-category'];
                        unset($_SESSION['edit-category']);
                        ?>
                    </p>
                </div>
                <?php elseif(isset($_SESSION['edit-category-success']))://nese updatimi i kategorise u be me sukses ?> 
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['edit-category-success'];
                        unset($_SESSION['edit-category-success']);
                        ?>
                    </p>
                </div>
                   <?php elseif(isset($_SESSION['delete-category-success']))://nese fshirja e kategorise u be me sukses ?> 
                <div class="alert__message success container">
                    <p>
                        <?= $_SESSION['delete-category-success'];
                        unset($_SESSION['delete-category-success']);
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
                        <h5>Shto Post</h5>

                    </a>
                </li>
                <li><a href="index.php"><i class="uil uil-postcard"></i>
                        <h5>Menaxho Postet</h5>

                    </a>
                </li>

                <?php  if(isset($_SESSION['user_is_admin'])): ?>

                <li><a href="add-user.php"><i class="uil uil-user-plus"></i>
                        <h5>Shto Perdorues</h5>

                    </a>
                </li>
                <li><a href="manage-users.php"><i class="uil uil-users-alt"></i>
                        <h5>Menaxho Perdoruesit</h5>

                    </a>
                </li>
                <li><a href="add-category.php"><i class="uil uil-edit"></i>
                        <h5>Shto Kategori</h5>
                    </a>
                </li>
                <li><a href="manage-categories.php" class="active"><i class="uil uil-list-ul"></i>
                        <h5>Menaxho Kategorite</h5>

                    </a>
                </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Menaxho Kategorite</h2>
            <?php if(mysqli_num_rows($categories) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Titulli</th>
                        <th>Edito</th>
                        <th>Fshi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                    <tr>
                        <td><?=  $category['title'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?=  $category ['id']?>" class="btn sm">Edito</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-category.php?id=<?=  $category ['id']?>" class="btn sm danger">Fshi</a></td>
                    </tr>    
                    <?php endwhile ?>         
                </tbody>
            </table>
            <?php else: ?>
                <div class="alert__message error">
                    <p>Nuk u gjet asnje kategori.</p>
                </div>
            <?php endif ?>
        </main>
    </div>
</section>


<?php
include '../partials/footer.php';
?>
