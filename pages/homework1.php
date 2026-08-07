<section class="homework-page">

    <div class="homework-card">

        <div class="homework-title">

            <h1>🧮 Homework 01</h1>
            <p>Simple Calculator</p>

        </div>

        <div class="calculator">

            <div class="form-group">
                <label>Number 1</label>
                <input type="number" id="num1" placeholder="Enter Number 1">
            </div>

            <div class="form-group">
                <label>Operator</label>

                <select id="operator">
                    <option value="+">+</option>
                    <option value="-">-</option>
                    <option value="*">×</option>
                    <option value="/">÷</option>
                </select>

            </div>

            <div class="form-group">
                <label>Number 2</label>
                <input type="number" id="num2" placeholder="Enter Number 2">
            </div>

            <button class="calculate-btn" onclick="calculate()">
                <i class="fa-solid fa-calculator"></i>
                CALCULATE
            </button>

        </div>

    </div>

</section>

<div class="modal" id="resultModal">

    <div class="modal-box">

        <div class="modal-header">

            <h2>
                <i class="fa-solid fa-square-root-variable"></i>
                Calculation Result
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