<?php
include 'partials/header.php';
?>
        
<section class="form__section" >
    <div class="container form__section-container">
        <h2>Perditeso Perdoruesin</h2>
       
        <form action="" enctype="multipart/form-data">
            <input type="text" placeholder="Emri">
            <input type="text" placeholder="Mbiemri">
            <select >
                <option value="0">Autor</option>
                <option value="1">Admin</option>
            </select>
            <button type="submit" class="btn">Perditso perdorues</button>
        </form>

    </div>
</section>

<?php
include '../partials/footer.php';
?>