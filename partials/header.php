<?php

require 'config/database.php';

//fetch current user from database
if(isset($_SESSION['user-id'])){
    $id = filter_var($_SESSION['user-id'],FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id = $id";
    $result = mysqli_query($connection,$query);
    $avatar = mysqli_fetch_assoc($result);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- custom css  -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>style/style.css">
    
    <!-- font-awasome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- google font  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <title>Blogi</title>
</head>
<body>

    <!-- ########################################### NAV SECTION ############################################ -->
    <nav>
        <div class="container nav-container">
           <a href="<?= ROOT_URL ?>" class="nav-logo">BLOGI</a> 

           <ul class="nav-items">
            <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
            <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
            <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
            <?php if(isset($_SESSION['user-id'])) : ?>
            <li class="nav-profile">
                <div class="avatar">
                    <img class="nav-avator" src="<?= ROOT_URL .'images/'. $avatar['avatar']?>" alt="avatar">
                </div>
                <ul>
                    <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                    <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                </ul>
            </li>
            <?php else: ?>
                <li><a href="signin.php">Sign In</a></li>
            <?php endif ?>
           </ul>

           <button class="open-nav-btn"><i class="fa-solid fa-bars"></i></button>
           <button class="close-nav-btn"><i class="fa-solid fa-x"></i></button>
        </div>
    </nav>
