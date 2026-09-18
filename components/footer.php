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

<!-- สคริปต์ซ่อนหน้าจอ Loading เฉพาะตัวที่เป็น Preloader โดยไม่บล็อกปุ่ม -->
<style>
    /* บังคับซ่อนเฉพาะกล่อง Preloader เท่านั้น โดยไม่กระทบปุ่มหรือฟอร์มอื่น */
    #preloader, 
    .preloader, 
    .loading-overlay,
    div[style*="position: fixed"][style*="z-index"]:has(> div:contains("Loading")) {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
    }
</style>

<script>
    window.addEventListener('load', function() {
        // ค้นหาเฉพาะกล่องที่แสดงคำว่า Loading แล้วซ่อนเฉพาะตัวมัน
        const elements = document.querySelectorAll('div, section, span');
        elements.forEach(el => {
            if (el.innerText && el.innerText.includes('Loading Web Programming')) {
                // หาเฉพาะกล่องชั้นนอกที่เป็นหน้าจอทับ (Overlay) ทั่วจอ
                let container = el.closest('div[style*="position: fixed"], .loading-screen, #preloader');
                if (container) {
                    container.style.display = 'none';
                } else {
                    el.style.display = 'none';
                }
            }
        });
    });
</script>

</body>

</html>