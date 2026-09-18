<!-- ================= FOOTER ================= -->

<footer>

    Developed by
    <strong>Sirichai Paisitvorakun</strong>

</footer>

<script src="assets/js/app.js"></script>
<script src="assets/js/homework.js"></script>

<?php

$page = $_GET["page"] ?? "dashboard";

switch ($page) {

    case "hw1":
        echo '<script src="assets/js/homework01.js"></script>';
        break;

    case "hw2":
        echo '<script src="assets/js/homework02.js"></script>';
        break;

    case "hw3":
        echo '<script src="assets/js/homework03.js?v=2"></script>';
        break;

    case "hw4":
        echo '<script src="assets/js/homework04.js?v=2"></script>';
        break;

    case "hw5":
        echo '<script src="assets/js/homework05.js"></script>';
        break;

    case "hw6":
        echo '<script src="assets/js/homework06.js"></script>';
        break;

    case "hw7":
        echo '<script src="assets/js/homework07.js"></script>';
        break;

}

?>



<!-- JavaScript -->

<script src="<?= $basePath ?>assets/js/script.js?v=1"></script>

</body>

</html>