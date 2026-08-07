
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

<?php

switch ($page) {

    case "hw1":
        echo '<script src="assets/js/homework.js"></script>';
        echo '<script src="assets/js/homework01.js"></script>';
        break;

    case "hw2":
        echo '<script src="assets/js/homework.js"></script>';
        echo '<script src="assets/js/homework02.js"></script>';
        break;

    case "hw3":
        echo '<script src="assets/js/homework.js"></script>';
        echo '<script src="assets/js/homework03.js"></script>';
        break;

    case "hw4":
        echo '<script src="assets/js/homework.js"></script>';
        echo '<script src="assets/js/homework04.js"></script>';
        break;

    case "hw5":
        echo '<script src="assets/js/homework.js"></script>';
        echo '<script src="assets/js/homework05.js"></script>';
        break;

    case "hw6":
        echo '<script src="assets/js/homework.js"></script>';
        echo '<script src="assets/js/homework06.js"></script>';
        break;
}
?>


    