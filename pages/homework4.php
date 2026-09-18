<section class="homework-page">

    <div class="homework-card">

        <div class="homework-title">

            <h1>✖️ Homework 04</h1>

            <p>Multiplication Table</p>
            
        </div>
        
        <form method="post">

            <div class="form-group">

                <label>Enter Number</label>

                    <input
                        type="number"
                        id="numInput"
                        name="num"
                        placeholder="Enter Number"
                        required>

            </div>

            <button
                type="button"
                class="calculate-btn"
                onclick="calculateMultiplication()">

                SHOW MULTIPLICATION TABLE

            </button>

        </form>

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

            <!-- ปรับให้มีพื้นที่เลื่อนดูแม่สูตรคูณได้สะดวก -->
            <div id="resultText" style="text-align: left; max-height: 300px; overflow-y: auto; padding: 0 20px;"></div>

        </div>

    </div>

</div>

<script src="assets/js/homework04.js"></script>