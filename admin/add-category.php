<?php 
include 'partials/header.php';
?>
        
<section class="form__section">
    <div class="container form__section-container">
        <h2>Shto Kategori</h2>
        <div class="alert__message error">
            <p>Ky eshte nje mesazh gabimi</p>
        </div>
        <form action="<?= ROOT_URL ?> admin/add-category-logic.php" method="POST">
            <input type="text" name="name" placeholder="Titulli">
            <textarea rows="4" name="slug" placeholder="Pershkrimi"></textarea>
            <textarea name="created_at" placeholder="Data e Krijimit"></textarea>
            <button type="submit" name="submit" class="btn">Shto Kategori</button>
        </form>

    </div>
</section>

<?php 
include '../partials/footer.php';
?>