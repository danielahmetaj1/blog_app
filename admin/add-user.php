<?php
include 'partials/header.php';
?>
        
<section class="form__section" >
    <div class="container form__section-container">
        <h2>Shto Post</h2>
        <div class="alert__message error">
            <p>Ky eshte nje mesazh gabimi</p>
        </div>
        <form action="" enctype="multipart/form-data">
            <input type="text" placeholder="Emri">
            <input type="text" placeholder="Mbiemri">
            <input type="text" placeholder="Username">
            <input type="email" placeholder="Email">
            <input type="password" placeholder="Krijo Password">
            <input type="password" placeholder="Konfirmo Password">
            <select >
                <option value="0">Autor</option>
                <option value="1">Admin</option>
            </select>
            <div class="from__control">
                <label for="avatar">User Avatar</label>
                <input type="file" id="avatar">
            </div>
            <button type="submit" class="btn">Shto perdorues</button>
        </form>

    </div>
</section>

<?php
include '../partials/footer.php';
?>