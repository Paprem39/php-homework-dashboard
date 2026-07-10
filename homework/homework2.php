<?php include "../components/header.php"; ?>

<link rel="stylesheet" href="../assets/css/homework.css">

<section class="homework-page">

    <div class="homework-card">

        <div class="homework-title">

            <h1>🧮 Homework 02</h1>

            <p>Odd / Even Number</p>
            
        </div>
          
            <form method="post">

                <div class="form-group">

                    <label>Number</label>

                        <input
                            type="number"
                            name="num1"
                            placeholder="Enter Number"
                            required>

                </div>

                <button type="submit" class="calculate-btn">

                    <i class="fa-solid fa-calculator"></i>

                        CHECK NUMBER

                </button>

            </form>

    <?php

        $result = "";

            if(isset($_POST["num1"])){

                $num1 = (int)$_POST["num1"];

            if($num1 % 2 == 0){

                $result = "🎉 {$num1} เป็นเลขคู่ ";

            }else{

                $result = "🔥 {$num1} เป็นเลขคี่ ";

            }

        }

    ?>
        <div class="button-group">

            <button class="back-btn" onclick="goHome()">

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