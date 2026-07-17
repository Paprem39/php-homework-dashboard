<?php include "../components/header.php"; ?>

<link rel="stylesheet" href="../assets/css/homework.css">


<?php

$file = __DIR__ . "/../data/numbers.txt";

$numbers = [];

if (file_exists($file)) {

    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {

        $line = trim($line);

        if (is_numeric(trim($line))) {

            $numbers[] = (float)$line;

        }

    }

}else{
    echo "<p style='color:red'>";
    echo "ไม่พบไฟล์: " . $file;
    echo "</p>";
}


$min = null;
$max = null;
$average = null;


if (count($numbers) >= 10) {

    $min = min($numbers);

    $max = max($numbers);

    $average = array_sum($numbers) / count($numbers);

}


?>


<section class="homework-page">

    <div class="homework-card">


        <div class="homework-title">

            <h1>🧮 Homework 05</h1>

            <p>Read Number From Text File</p>

        </div>



        <?php if(count($numbers) >= 10): ?>


        <div class="result-box">


            <h2>Numbers From File</h2>


            <div class="number-list">

                <?php foreach($numbers as $number): ?>

                    <span>
                        <?= $number ?>
                    </span>

                <?php endforeach; ?>

            </div>

            <hr>

            <h2>Result</h2>

            <p>
                <strong>MIN :</strong>
                <?= $min ?>
            </p>

            <p>
                <strong>MAX :</strong>
                <?= $max ?>
            </p>

            <p>
                <strong>AVERAGE :</strong>
                <?= number_format($average,2) ?>
            </p>

        </div>

        <?php else: ?>
            <p>
                ❌ กรุณาใส่ตัวเลขอย่างน้อย 10 บรรทัดในไฟล์ numbers.txt
            </p>
        <?php endif; ?>



        <div class="button-group">

            <button class="back-btn" onclick="goHome()">

                <i class="fa-solid fa-house"></i>

                BACK HOME

            </button>

            <button class="done-btn" onclick="markDone('hw5')">

                <i class="fa-solid fa-circle-check"></i>

                ASSIGNMENT DONE

            </button>

        </div>

    </div>

</section>

<!-- ================= MODAL ================= -->

<div class="modal" id="resultModal">

    <div class="modal-box">

        <div class="modal-header">

            <h2>
                <i class="fa-solid fa-square-root-variable"></i>
                   Result : 
            </h2>

            <span class="close" onclick="closeModal()">
                &times;
            </span>

        </div>

        <div class="modal-body">

            <div id="resultText"></div>

        </div>

    </div>

</div>


<!-- ================= ท้ายไฟล์ ================= --> 

<script src="../assets/js/homework.js?v=1"></script>
<script src="../assets/js/homework05.js"></script>

<!-- ================= เรียก footer มาทำงานทุกไฟล์ ================= --> 
<?php include "../components/footer.php"; ?>