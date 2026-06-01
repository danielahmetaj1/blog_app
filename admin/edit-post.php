<?php
include 'partials/header.php';

// marrja e kategorive nga databaza
$category_query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $category_query);


//marrja e te dhenave nga databaza nese id eshte vendosur

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $post_query = "SELECT * FROM posts WHERE id = $id";
    $result = mysqli_query($connection, $post_query);
    $post = mysqli_fetch_assoc($result);
     
}else {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

if(isset($_SESSION['edit-post'])) {
    echo '<div class="alert-message error">' . $_SESSION['edit-post'] . '</div>';
    unset($_SESSION['edit-post']);
}

?>
        
<section class="form__section" >
    <div class="container form__section-container">
        <h2>Perditeso Postin</h2>
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>">
            <input type="text" name="title" value="<?= $post['title'] ?>" placeholder="Titulli">
            <select name="category">
                <?php while($category = mysqli_fetch_assoc($categories)) : ?> 
                <option value="<?= $category['id'] ?>" <?= $category['id'] == $post['category_id'] ? 'selected' : '' ?>><?= $category['title'] ?></option>
                <?php endwhile; ?>


            </select>
            <textarea rows="10" name="body" placeholder="Zhvillimi"><?=  $post['body'] ?></textarea>
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" <?= $post['is_featured'] ? 'checked' : '' ?>>
                <label for="is_featured">Vecori</label>
            </div>
            <div class="form__control">
                <label for="thumbnail">Ndrysho Miniaturen</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            
            <button type="submit" name="submit" class="btn">Perditeso Postin</button>
        </form>

    </div>
</section>

<?php
include '../partials/footer.php';
?>
