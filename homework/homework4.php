<?php include "../components/header.php"; ?>

<link rel="stylesheet" href="../assets/css/homework.css">

<section class="homework-page">

    <div class="homework-card">

        <div class="homework-title">

            <h1>🧮 Homework 04</h1>

            <p>Multiplication table</p>
            
        </div>
          
        <form method="post">

            <div class="form-group">

                <label>input Number</label>

                    <input
                        type="number"
                        id="number"
                        name="number"
                        placeholder="Enter Number"
                        required>

            </div>

            <button 
                type="submit" class="calculate-btn">

                    <i class="fa-solid fa-calculator"></i>
                    CHECK Multiplication
            </button>

        </form>

        <?php
            $result = "";

            if (isset($_POST["number"])) {
            
                $number = (int)$_POST["number"];
            
                for ($i = 1; $i <= 12; $i++) {
            
                    $result .= "{$number} × {$i} = " . ($number * $i) . "<br>";
            
                }
            
            }

        ?>

        <div class="button-group">

            <button type="button" class="back-btn" onclick="goHome()">

                <i class="fa-solid fa-house"></i>

                BACK HOME

            </button>

            <button class="done-btn" onclick="markDone('hw4')">

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
<script>

const homeworkResult = <?= json_encode($result) ?>;

</script>

<script src="../assets/js/homework.js"></script>
<script src="../assets/js/homework04.js"></script>

<!-- ================= เรียก footer มาทำงานทุกไฟล์ ================= --> 
<?php include "../components/footer.php"; ?>