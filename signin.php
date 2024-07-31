<?php
require 'config/constants.php';
$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- custom css  -->
    <link rel="stylesheet" href="./style/style.css">
    
    <!-- font-awasome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- google font  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <title>Blogi</title>
</head>
<body>
    
    <section class="form-section">
    <div class="container form-section-container">
        <h2>Sign In</h2>
       <?php if(isset($_SESSION['signup-success'])) : ?>
        <div class="alert-message success"> 
            <p>
                <?= $_SESSION['signup-success'];
                unset($_SESSION['signup-success']); ?>
            </p>
        </div>

        <?php elseif(isset($_SESSION['signin'])) : ?>
            <div class="alert-message error">
                <p>
                    <?= $_SESSION['signin'];
                    unset($_SESSION['signin']);
                    ?>
                </p>
            </div>

        <?php endif ?>

        <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
            <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Username or email">

            <input type="password" value="<?= $password ?>" name="password" placeholder="Password">

            
            <button type="submit" name="submit" class="btn">Sign In</button>
            <small>Don't have an account? <a href="./signup.php">Sign Up</a></small>
        </form>
    </div>
    </section>

</body>
</html>