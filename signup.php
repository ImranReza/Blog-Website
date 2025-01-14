<?php
require 'config/constants.php';


//get back form data if there was a registration error

$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;

//delete the session
unset($_SESSION['signup-data']);


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
        <h2>Sign Up</h2>
        <?php if(isset($_SESSION['signup'])) : ?>
            
        <div class="alert-message error"> 
            <p>
                <?= $_SESSION['signup'];
                unset($_SESSION['signup']);
                ?>
            </p>
        </div>
        <?php endif ?>

        <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name">

            <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Nmae">

            <input type="text" name="username" value="<?= $username ?>" placeholder="Username">

            <input type="email" name="email" value="<?= $email ?>" placeholder="Email">

            <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Create Password">

            <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password">


            <div class="form-control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar">

            </div>

            <button type="submit" name="submit" class="btn">Sign Up</button>
            <small>Already hava an account? <a href="./signin.php">Sign In</a></small>
        </form>
    </div>
    </section>

</body>
</html>