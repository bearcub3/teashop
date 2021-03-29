<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>All-My-Tea Cups</title>
<link rel="stylesheet" href="css/bootstrap-icons.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
</head>

<body>
<header class="my-3">
    <div class="d-flex">
        <h1 class="align-self-center ms-5">
            <a class="fs-3" href="home.php" id="logo">All-My-Tea Cups</a>
        </h1>
        <a class="ms-auto align-self-center px-3" href="cart.php">View Cart</a><span class="align-self-center">|</span>
        <?php
        # Access session.
        session_start() ;

        # Redirect if not logged in.
        if ( !isset( $_SESSION[ 'user_id' ] ) ) 
        {
            echo '<a class="align-self-center px-3" href="login.php">Log In</a>';
        } else {
            echo '<a class="align-self-center px-3" href="goodbye.php">Log out</a>';
        }
        ?>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav d-flex justify-content-start">
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="category.php?category=TeaCup">Tea Cups</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="category.php?category=CoffeeCup">Coffee Cups</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="category.php?category=Mug">Mugs</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="forum.php">Forum</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="container">
