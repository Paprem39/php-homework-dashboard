<?php include "../components/header.php"; ?>

<link rel="stylesheet" href="../assets/css/homework.css">

<section class="homework-page">

    <div class="homework-card">

        <div class="homework-title">

            <h1>📚 Homework 03</h1>

            <p>Grade Calculator</p>

        </div>

        <form method="post">

            <div class="form-group">

                <label>Score (0 - 100)</label>

                <input
                    type="number"
                    name="score"
                    min="0"
                    max="100"
                    placeholder="Enter Score"
                    required>

            </div>

            <button type="submit" class="calculate-btn">

                <i class="fa-solid fa-graduation-cap"></i>

                CHECK GRADE

            </button>

        </form>

<?php

$result = "";

if(isset($_POST["score"])){

    $score = (int)$_POST["score"];

    if($score >= 80){
        $grade = "A";
    }
    elseif($score >= 75){
        $grade = "B+";
    }
    elseif($score >= 70){
        $grade = "B";
    }
    elseif($score >= 65){
        $grade = "C+";
    }
    elseif($score >= 60){
        $grade = "C";
    }
    elseif($score >= 55){
        $grade = "D+";
    }
    elseif($score >= 50){
        $grade = "D";
    }
    else{
        $grade = "F";
    }

    $result = "🎓 คะแนน {$score} ได้เกรด <b>{$grade}</b>";

}

?>

<?php if($result != ""): ?>

<div class="result-box">

    <?= $result ?>

</div>

<?php endif; ?>

        <div class="button-group">

            <button
                type="button"
                class="back-btn"
                onclick="goHome()">

                <i class="fa-solid fa-house"></i>

                BACK HOME

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

<script src="../assets/js/homework.js?v=1"></script>

<?php if($result != ""): ?>

<script>

document.addEventListener("DOMContentLoaded", function(){

    document.getElementById("resultText").innerHTML =
        "<?= $result ?>";

    document.getElementById("resultModal").style.display = "flex";

});

</script>

<?php endif; ?>

<?php include "../components/footer.php"; ?>