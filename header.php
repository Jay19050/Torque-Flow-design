<?php

$page = basename($_SERVER['PHP_SELF'], ".php");

if ($page == "index") {
    $page = "home";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Torque Flow</title>




    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">




    <link rel="stylesheet" href="css/style.css?v=12">

    <link rel="stylesheet" href="css/hero.css?v=3">

    <link rel="stylesheet" href="css/about.css?v=2">

    <link rel="stylesheet" href="css/contact.css?v=1">

    <link rel="stylesheet" href="css/login.css">


    <link rel="stylesheet" href="css/about.css?v=2">

    <link rel="stylesheet" href="css/contact.css?v=1">

    <link rel="stylesheet" href="css/login.css">

    <link rel="stylesheet" href="css/services.css">

</head>


<body class="page-<?= htmlspecialchars($page, ENT_QUOTES, 'UTF-8') ?>">

    <!-- Skip Link for Accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- =========================================
         HEADER
    ========================================= -->

    <header>


        <!-- LOGO -->

        <a href="index.php" class="logo" aria-label="Torque Flow Home">
            TORQUE FLOW
        </a>


        <!-- MAIN NAVIGATION -->

        <nav aria-label="Main Navigation">

            <a href="index.php" class="<?= ($page == "home") ? "active" : "" ?>">
                HOME
            </a>


            <a href="services.php" class="<?= ($page == "services") ? "active" : "" ?>">
                SERVICES
            </a>


            <a href="booking.php" class="<?= ($page == "booking") ? "active" : "" ?>">
                BOOKING
            </a>


            <a href="about.php" class="<?= ($page == "about") ? "active" : "" ?>">
                ABOUT
            </a>


            <a href="contact.php" class="<?= ($page == "contact") ? "active" : "" ?>">
                CONTACT
            </a>

        </nav>


        <!-- =========================================
             CLIENT ACCESS DROPDOWN
        ========================================= -->

        <div class="client-access">


            <!-- TRIGGER -->

            <button type="button" class="client-access-trigger" id="client-access-btn" aria-haspopup="true" aria-expanded="false" aria-controls="client-access-menu">

                <span>CLIENT ACCESS</span>

                <span class="client-access-arrow" aria-hidden="true">↗</span>

            </button>


            <!-- DROPDOWN MENU -->

            <div class="client-access-menu" id="client-access-menu" role="menu" aria-labelledby="client-access-btn">


                <!-- LOGIN -->

                <a href="login.php" role="menuitem" class="<?= ($page == "login") ? "active" : "" ?>">

                    <span>LOGIN</span>

                    <span aria-hidden="true">↗</span>

                </a>


                <!-- REGISTER -->

                <a href="registration.php" role="menuitem" class="<?= ($page == "registration") ? "active" : "" ?>">

                    <span>REGISTER</span>

                    <span aria-hidden="true">↗</span>

                </a>


            </div>

        </div>


    </header>
