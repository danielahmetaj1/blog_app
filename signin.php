<?php

require 'config/constants.php';

$username_email= $_SESSION['signin-data']['username_email'] ?? null;

unset($_SESSION['signin-data']);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WriteX Blog</title>
    <!-- Stilizim custom-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <!--Ikona -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.2.0/css/line.css">
    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Kycu</h2>
            <?php if (isset ($_SESSION['signup-success'])) : ?>
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['signup-success'];
                        unset($_SESSION['signup-success']);
                        ?>
                    </p>
                </div>
            <?php elseif(isset($_SESSION['signin'])) :  ?>
            <div class="alert__message error">
                    <p>
                        <?= $_SESSION['signin'];
                        unset($_SESSION['signin']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
                <input type="text" name="username_email" value="<?= htmlspecialchars($username_email ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Username ose Email">
                <input type="password" name="password" placeholder="Password">
                <button type="submit" name="submit" class="btn">Kycu</button>
                <small>Nuk ke nje llogari? <a href="signup.php"> Regjistrohu</a> </small>
            </form>

        </div>
    </section>

</body>

</html>
