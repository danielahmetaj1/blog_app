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
            <input type="text" placeholder="Titulli">
            <select >
                <option value="1">Travel</option>
                <option value="1">Art</option>
                <option value="1">Science </option>
                <option value="1">Science </option>
                <option value="1">Science </option>
                <option value="1">Science </option>

            </select>
            <textarea rows="10" placeholder="Zhvillimi"></textarea>
            <div class="form__control inline">
                <input type="checkbox" id="is_featured" checked>
                <label for="is_featured" >Vecori</label>
            </div>
            <div class="form__control">
                <label for="thumbnail">Zgjidh Miniaturën</label>
                <input type="file" id="thumbnail">
            </div>
            
            <button type="submit" class="btn">Postoje</button>
        </form>

    </div> 
</section>
<?php 
include '../partials/footer.php';
?>