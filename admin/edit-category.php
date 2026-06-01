<?php
include 'partials/header.php';

if(isset($_GET['id'])){
   $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

   //merr kategorine nga databaza
   $query = "SELECT * FROM categories WHERE id=$id";
   $result = mysqli_query($connection, $query);
   if(mysqli_num_rows($result)==1){
    $category = mysqli_fetch_assoc($result);
   }
}else{
    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    die();
}
?>
        
<section class="form__section">
    <div class="container form__section-container">
        <h2>Perditeso Kategorine</h2>
      
        <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="POST">
            <input type="hidden" name="id" value="<?=  $category['id'] ?>">
            <input type="text" name="title"  value="<?= $category['title'] ?>" placeholder="Titulli">
            <textarea rows="4" name="slug" placeholder="Pershkrimi"><?=  $category['slug'] ?></textarea>
            <button type="submit" name="submit" class="btn">Perditeso Kategorine</button>
        </form>

    </div>
</section>

<?php
include '../partials/footer.php';
?>
