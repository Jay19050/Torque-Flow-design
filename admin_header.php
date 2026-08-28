<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Torque Flow | Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/admin_header.css">
</head>

<body>

<?php
    $current_page = basename($_SERVER['PHP_SELF']);
?>

<header class="tf-admin-header">

    <nav class="tf-admin-nav">

        <!-- BRAND -->
        <a href="admin_manage_type.php" class="tf-admin-brand">
            <span class="tf-brand-mark"><span>TF</span></span>

            <span class="tf-brand-name">
                TORQUE FLOW
            </span>

            <span class="tf-brand-label">
                ADMIN
            </span>
        </a>


        <!-- DESKTOP NAVIGATION -->
        <div class="tf-nav-right">

            <div class="tf-nav-links">

                <a
                    href="admin_manage_type.php"
                    class="tf-nav-link <?php echo ($current_page == 'admin_manage_type.php') ? 'active' : ''; ?>"
                >
                    <span class="tf-nav-number">01</span>
                    <span>SERVICE TYPE</span>
                </a>


                <a
                    href="admin_manage_service_center.php"
                    class="tf-nav-link <?php echo ($current_page == 'admin_manage_service_center.php') ? 'active' : ''; ?>"
                >
                    <span class="tf-nav-number">02</span>
                    <span>SERVICE CENTER</span>
                </a>


                <!-- REPORTS -->
                <div class="tf-nav-dropdown">

                    <button
                        type="button"
                        class="tf-nav-link tf-dropdown-trigger"
                        aria-expanded="false"
                        aria-haspopup="true"
                    >
                        <span class="tf-nav-number">03</span>
                        <span>REPORTS</span>
                        <span class="tf-dropdown-arrow">↘</span>
                    </button>


                    <div class="tf-dropdown-menu">

                        <div class="tf-dropdown-heading">
                            REPORTS
                            <span>04 MODULES</span>
                        </div>

                        <a href="#">
                            <span>01</span>
                            ALL BOOKING REPORTS
                            <b>↗</b>
                        </a>

                        <a href="#">
                            <span>02</span>
                            TODAY'S BOOKING REPORTS
                            <b>↗</b>
                        </a>

                        <a href="#">
                            <span>03</span>
                            CUSTOMER REPORTS
                            <b>↗</b>
                        </a>

                        <a href="#">
                            <span>04</span>
                            SERVICE CENTER REPORTS
                            <b>↗</b>
                        </a>

                    </div>

                </div>


                <!-- LOGOUT -->
                <a href="logout.php" class="tf-logout">
                    <span>LOGOUT</span>
                    <b>↗</b>
                </a>

            </div>

        </div>


        <!-- MOBILE MENU BUTTON -->
        <button
            type="button"
            class="tf-mobile-toggle"
            aria-label="Open navigation"
            aria-expanded="false"
        >
            <span></span>
            <span></span>
        </button>

    </nav>


    <!-- MOBILE NAVIGATION -->
    <div class="tf-mobile-menu">

        <a
            href="admin_manage_type.php"
            class="<?php echo ($current_page == 'admin_manage_type.php') ? 'active' : ''; ?>"
        >
            <span>01</span>
            SERVICE TYPE
        </a>

        <a
            href="admin_manage_service_center.php"
            class="<?php echo ($current_page == 'admin_manage_service_center.php') ? 'active' : ''; ?>"
        >
            <span>02</span>
            SERVICE CENTER
        </a>

        <div class="tf-mobile-report-heading">
            <span>03</span>
            REPORTS
        </div>

        <a href="#" class="tf-mobile-sub-link">
            ALL BOOKING REPORTS
        </a>

        <a href="#" class="tf-mobile-sub-link">
            TODAY'S BOOKING REPORTS
        </a>

        <a href="#" class="tf-mobile-sub-link">
            CUSTOMER REPORTS
        </a>

        <a href="#" class="tf-mobile-sub-link">
            SERVICE CENTER REPORTS
        </a>

        <a href="logout.php" class="tf-mobile-logout">
            LOGOUT ↗
        </a>

    </div>

</header>


<script>
document.addEventListener("DOMContentLoaded", function () {

    /* ============================
       REPORT DROPDOWN
       ============================ */

    const dropdown = document.querySelector(".tf-nav-dropdown");
    const dropdownTrigger = document.querySelector(".tf-dropdown-trigger");

    if (dropdown && dropdownTrigger) {

        dropdownTrigger.addEventListener("click", function (event) {

            event.stopPropagation();

            const isOpen = dropdown.classList.toggle("open");

            dropdownTrigger.setAttribute(
                "aria-expanded",
                isOpen ? "true" : "false"
            );

        });


        document.addEventListener("click", function (event) {

            if (!dropdown.contains(event.target)) {

                dropdown.classList.remove("open");

                dropdownTrigger.setAttribute(
                    "aria-expanded",
                    "false"
                );

            }

        });

    }


    /* ============================
       MOBILE MENU
       ============================ */

    const mobileToggle = document.querySelector(".tf-mobile-toggle");
    const mobileMenu = document.querySelector(".tf-mobile-menu");

    if (mobileToggle && mobileMenu) {

        mobileToggle.addEventListener("click", function () {

            const isOpen = mobileMenu.classList.toggle("open");

            mobileToggle.classList.toggle("open", isOpen);

            mobileToggle.setAttribute(
                "aria-expanded",
                isOpen ? "true" : "false"
            );

        });

    }

});
</script>
