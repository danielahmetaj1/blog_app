<?php
include 'partials/header.php';

//marrja e te dhenave nese ka nje error
$firstname = $_SESSION['add-user-data'] ['firstname']?? null;
$lastname = $_SESSION['add-user-data'] ['lastname']?? null;
$username = $_SESSION['add-user-data'] ['username']??null;
$email = $_SESSION['add-user-data']  ['email']??null;
$createpassword = $_SESSION['add-user-data'] ['createpassword']?? null;
$confirmpassword = $_SESSION['add-user-data'] ['confirmpassword']?? null;
$userrole = $_SESSION['add-user-data'] ['userrole']?? null;


//fshi data session
unset($_SESSION['add-user-data']);
?>
        
<section class="form__section" >
    <div class="container form__section-container">
        <h2>Shto Perdorues</h2>
        <?php if(isset($_SESSION['add-user'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['add-user'];
                    unset($_SESSION['add-user']); 
                    ?>
                </p>
            </div>
            <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-user-logic.php" enctype="multipart/form-data"
        method="POST">
            <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="Emri">
            <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Mbiemri">
            <input type="text" name="username"value="<?= $username ?>" placeholder="Username">
            <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
            <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Krijo Password">
            <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>"placeholder="Konfirmo Password">
            <select name="userrole">
                <option value="0">Autor</option>
                <option value="1">Admin</option>
            </select>
            <div class="from__control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Shto perdorues</button>
        </form>

    </div>
</section>

<?php
include '../partials/footer.php';
?>