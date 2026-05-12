<?php 
include 'partials/header.php';

//mer te dhenat e kategorise nese eshte vendosur ne session
$title = $_SESSION['add-category-data']['title'] ?? null;
$slug = $_SESSION['add-category-data']['slug'] ?? null;
$created_at = $_SESSION['add-category-data']['created_at'] ?? null;
unset($_SESSION['add-category-data']);
?>
        
<section class="form__section">
    <div class="container form__section-container">
        <h2>Shto Kategori</h2>
        <?php if(isset($_SESSION['add-category'])): ?>
            <div class="alert__message error">
                <p><?= $_SESSION['add-category'];
                unset($_SESSION['add-category']); ?></p>
            </div>
        <?php endif; ?>
        <form action="<?= ROOT_URL ?>admin/add-category-logic.php" method="POST">
            <input type="text" name="title" value="<?= $title ?>" placeholder="Titulli">
            <textarea rows="4" name="slug" placeholder="Pershkrimi"><?= $slug ?></textarea>
            <textarea name="created_at" placeholder="Data e Krijimit(yyyy-mm-dd)"><?= $created_at ?></textarea>
            <button type="submit" name="submit" class="btn">Shto Kategori</button>
        </form>

    </div>
</section>

<?php 
include '../partials/footer.php';
?>