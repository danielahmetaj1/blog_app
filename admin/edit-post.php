<?php
include 'partials/header.php';

// marja e kategorive nga databaza
$category_query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $category_query);


//marja e tedhenave nga databaza nese id eshte vendosur

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $post_query = "SELECT * FROM posts WHERE id = $id";
    $post = mysqli_query($connection, $post_query);
    $post = mysqli_fetch_assoc($post);
    if(!$post) {
        header('location: ' . ROOT_URL . 'admin/');
        die();
    }
}else {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

?>
        
<section class="form__section" >
    <div class="container form__section-container">
        <h2>Perditeso Postin</h2>
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $post['id'] ?>" >
            <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>">
            <input type="text" name="title" value="<?= $post['title'] ?>">
            <select name="category">
                <?php while($category = mysqli_fetch_assoc($categories)) : ?> 
                <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                <?php endwhile; ?>
                <option value="1">Art</option>
                <option value="1">Science </option>
                <option value="1">Science </option>
                <option value="1">Science </option>
                <option value="1">Science </option>

            </select>
            <textarea rows="10" name="body" placeholder="Zhvillimi"><?=  $post['body'] ?></textarea>
            <div class="form__control inline">
                <input type="checkbox" id="is_featured" value="1" checked>
                <label for="is_featured">Vecori</label>
            </div>
            <div class="form__control">
                <label for="thumbnail">Ndrysho Miniaturën</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            
            <button type="submit" name="submit" class="btn">Perditso Postin</button>
        </form>

    </div>
</section>

<?php
include '../partials/footer.php';
?>