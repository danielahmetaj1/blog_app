<?php 
include 'partials/header.php';

//merr kategorite nga databaza
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

//ktheji mbrapsh te dhenat e formes nese forma ka qene invalide
$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null; 
unset($_SESSION['add-post-data']);

?>
        
<section class="form__section" >
    <div class="container form__section-container">
        <h2>Shto Post</h2>
        <?php if(isset($_SESSION['add-post'])): ?>
        <div class="alert__message error">
            <p>
                <?= $_SESSION['add-post']; 
                unset($_SESSION['add-post']);
                ?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL  ?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="title" value="<?= $title ?>" placeholder="Titulli">
            <select name="category_id">
                <?php while($category_id = mysqli_fetch_assoc($categories)): ?>
                <option value="<?= $category_id['id'] ?>"><?= $category_id['title'] ?></option>
               <?php endwhile ?>
        
            </select>
            <textarea rows="10" name="body" placeholder="Zhvillimi" ><?= $body ?></textarea>
            <?php if(isset($_SESSION['user_is_admin'])): ?>
            <div class="form__control inline">
                <input type="checkbox" id="is_featured" value="1" name="is_featured" checked>
                <label for="is_featured" >Vecori</label>
            </div>
            <?php endif ?>
            <div class="form__control">
                <label for="thumbnail">Zgjidh Miniaturen</label>
                <input type="file" id="thumbnail" name="thumbnail">
            </div>
            
            <button type="submit" name="submit" class="btn">Postoje</button>
        </form>

    </div> 
</section>
<?php 
include '../partials/footer.php';
?>