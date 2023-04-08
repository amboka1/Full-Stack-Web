<?php 

require '../config/database.php';


// check login status for all pages with nav
if(!isset($_SESSION['user-id'])) {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}


// fetch current user from database

if(isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id='$id'";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amboka</title>
    <!-- CSS დაკავშირება -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>./css/style.css">
    <!-- ICON დაკავშირება -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>

    <nav>
        <div class="container nav__container">
            <a href="<?= ROOT_URL ?>" class="nav__logo">Ambokka</a>
            <ul class="nav__items">
            <li><a class="fonts" href="<?= ROOT_URL ?>blog.php">ბლოგი</a></li>
                    <li><a class="fonts" href="<?= ROOT_URL ?>about.php">შესახებ</a></li>
                    <li><a class="fonts" href="<?= ROOT_URL ?>services.php">მომსახურება</a></li>
                    <li><a class="fonts" href="<?= ROOT_URL ?>contact.php">კონტაქტი</a></li>
                    <?php if(isset($_SESSION['user-id'])) : ?>
                        <li class="nav__profile">
                        <div class="avatar">
                            <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>" alt="">
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                            <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <?php else : ?> 
                    <li><a href="<?= ROOT_URL ?>signin.php">შესვლა</a></li>
                    <?php endif ?>
            </ul>

            <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>

    <!-- ========================= END OF NAV ==========================  -->

