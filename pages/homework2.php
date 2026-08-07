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
                        id="num1"
                        name="num1"
                        placeholder="Enter Number"
                        required>

            </div>

            <button
                type="button"
                class="calculate-btn"
                onclick="checkNumber()">

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

    </div>

</section>

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