<?php include "../components/header.php"; ?>

<link rel="stylesheet" href="../assets/css/homework.css">

<section class="homework-page">

    <div class="homework-card">

        <div class="homework-title">

            <h1>🧮 Homework 03</h1>

            <p>Grade Student</p>
            
        </div>
          
        <form method="post">

            <div class="form-group">

                <label>Score</label>

                    <input
                        type="number"
                        id="score"
                        name="score"
                        placeholder="Enter Score"
                        required>

            </div>

            <button 
                type="submit" class="calculate-btn">

                    <i class="fa-solid fa-calculator"></i>
                    CHECK GRADE
            </button>

        </form>

        <?php

        $result = "";

        if (isset($_POST["score"])) {

            $score = (float)$_POST["score"];

            if($score < 0 || $score > 100){

                    $result = "กรุณากรอกคะแนนช่วง 0 - 100";
                }
                else
                {

                if ($score >= 80) {

                    $grade = "A";

                } elseif ($score >= 75) {

                    $grade = "B+";

                } elseif ($score >= 70) {

                    $grade = "B";

                } elseif ($score >= 65) {

                    $grade = "C+";

                } elseif ($score >= 60) {

                    $grade = "C";

                } elseif ($score >= 55) {

                    $grade = "D+";

                } elseif ($score >= 50) {

                    $grade = "D";

                } else {

                    $grade = "F";

                }
                
                    $result = "คะแนน {$score} ได้เกรด {$grade}";

                }
            }

        ?>
        <div class="button-group">

            <button type="button" class="back-btn" onclick="goHome()">

                <i class="fa-solid fa-house"></i>

                BACK HOME

            </button>

            <button class="done-btn" onclick="markDone('hw3')">

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

            <h1 id="resultText"></h1>

        </div>

    </div>

</div>

<!-- ================= ท้ายไฟล์ ================= --> 
<script>

const homeworkResult = <?= json_encode($result) ?>;

</script>

<script src="../assets/js/homework.js"></script>
<script src="../assets/js/homework03.js"></script>

<!-- ================= เรียก footer มาทำงานทุกไฟล์ ================= --> 
<?php include "../components/footer.php"; ?>