<?php 
include 'partials/header.php';

//mer kategorite nga databaza
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);
?>
        
<section class="form__section" >
    <div class="container form__section-container">
        <h2>Shto Post</h2>
        <div class="alert__message error">
            <p>Ky eshte nje mesazh gabimi</p>
        </div>
        <form action="<?= ROOT_URL  ?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="title" placeholder="Titulli">
            <select name="category_id">
                <?php while($category_id = mysqli_fetch_assoc($categories)): ?>
                <option value="<?= $category_id['id'] ?>"><?= $category_id['title'] ?></option>
               <?php endwhile ?>

            </select>
            <textarea rows="10" name="body" placeholder="Zhvillimi"></textarea>
            <?php if(isset($_SESSION['user_is_admin'])): ?>
            <div class="form__control inline">
                <input type="checkbox" id="is_featured" value="1" name="is_featured" checked>
                <label for="is_featured" >Vecori</label>
            </div>
            <?php endif ?>
            <div class="form__control">
                <label for="thumbnail">Zgjidh Miniaturën</label>
                <input type="file" id="thumbnail" name="thumbnail">
            </div>
            
            <button type="submit" name="submit" class="btn">Postoje</button>
        </form>

    </div> 
</section>
<?php 
include '../partials/footer.php';
?>