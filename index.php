<?php
// เปิด Session ไว้ที่บรรทัดแรกสุดของโปรเจกต์หลัก เพื่อให้ใช้ได้ทุกหน้า
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php include "components/header.php"; ?>

<div class="main-layout">

    <?php include "components/sidebar.php"; ?>

    <main class="content">

        <?php

        $page = $_GET["page"] ?? "dashboard";

        switch ($page) {

            case "hw1":
                include "pages/homework1.php";
                break;

            case "hw2":
                include "pages/homework2.php";
                break;

            case "hw3":
                include "pages/homework3.php";
                break;

            case "hw4":
                include "pages/homework4.php";
                break;

            case "hw5":
                include "pages/homework5.php";
                break;

            case "hw6":
                include "pages/homework6.php";
                break;

            case "hw7":
                include "pages/homework7.php";
                break;

            case "hw8":
                include "pages/homework8.php";
                break;

            case "about":
                include "pages/about.php";
                break;

            default:
                include "pages/dashboard.php";
                break;
        }

        ?>

    </main>

</div>

<?php include "components/footer.php"; ?>