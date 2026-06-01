<?php
include 'partials/header.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE user_id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
}else{
    header('location: ' . ROOT_URL . 'admin/manage-users.php');
    die();
}
?>
        
<section class="form__section" >
    <div class="container form__section-container">
        <h2>Perditeso Perdoruesin</h2>
       
        <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" value="<?= $user['user_id'] ?>" name="id">
            <input type="text" value="<?= $user['firstname'] ?>" name="firstname" placeholder="Emri">
            <input type="text" value="<?= $user['lastname'] ?>" name="lastname" placeholder="Mbiemri">
            <select name="userrole">
                <option value="author">Autor</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="submit" class="btn">Perditeso perdoruesin</button>
        </form>

    </div>
</section>

<?php
include '../partials/footer.php';
?>
