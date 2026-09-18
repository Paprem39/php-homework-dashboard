<?php
// กำหนด path ให้ตรงกับโครงสร้างโฟลเดอร์หลักที่เรียกผ่าน index.php
$file = "data/numbers.txt";

$numbers = [];

if (file_exists($file)) {
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as$line) {
        $line = trim($line);
        if (is_numeric(trim($line))) {
            $numbers[] = (float)$line;
        }
    }
} else {
    // ถ้าไม่มีไฟล์ สร้างไฟล์จำลองหรือแจ้งเตือน
    // สามารถสร้างไฟล์ numbers.txt ไว้ในโฟลเดอร์ data/ ได้เลยครับ
}

$min = null;
$max = null;
$average = null;

if (count($numbers) > 0) {$min = min($numbers);$max = max($numbers);$average = array_sum($numbers) / count($numbers);
}
?>

<section class="homework-page">

    <div class="homework-card">

        <div class="homework-title">

            <h1>📂 Homework 05</h1>

            <p>Read Number From Text File</p>

        </div>

        <?php if(count($numbers) > 0): ?>

        <div class="result-box" style="text-align: left; margin-bottom: 20px;">

            <h2>Numbers From File</h2>

            <div class="number-list" style="margin: 10px 0; max-height: 120px; overflow-y: auto;">
                <?php foreach($numbers as$number): ?>
                    <span style="display: inline-block; background: #222; padding: 3px 8px; margin: 2px; border-radius: 4px; border: 1px solid #444;">
                        <?= $number ?>
                    </span>
                <?php endforeach; ?>
            </div>

            <hr style="border-color: #444; margin: 15px 0;">

            <h2>Result</h2>

            <p><strong>MIN :</strong> <?= $min ?></p>

            <p><strong>MAX :</strong> <?= $max ?></p>

            <p><strong>AVERAGE :</strong> <?= number_format($average, 2) ?></p>

        </div>

        <?php else: ?>
            <p style="color: #ff5555; margin-bottom: 20px;">
                ❌ ไม่พบข้อมูลตัวเลขในไฟล์ data/numbers.txt หรือไฟล์ว่างเปล่า
            </p>
        <?php endif; ?>

        <!-- ปุ่มสำหรับสั่งให้แสดงผลผ่าน Modal หรือทำงานร่วมกับ JS ตามสไตล์เดิม -->
        <button
            type="button"
            class="calculate-btn"
            onclick="showFileResult()">

            VIEW FILE SUMMARY

        </button>

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

            <div id="resultText" style="text-align: left; line-height: 1.6;"></div>

        </div>

    </div>

</div>

<!-- ส่งค่าจาก PHP ไปให้ JavaScript แสดงผลใน Modal -->
<script>
function showFileResult() {
    let htmlContent = `
        <h3 style="color: #e50914; margin-bottom: 10px;">สรุปข้อมูลจาก Text File</h3>
        <p><b>จำนวนข้อมูลทั้งหมด:</b> <?= count($numbers) ?> ตัว</p>
        <p><b>ค่าต่ำสุด (MIN):</b> <?= $min !== null ? $min : '-' ?></p>
        <p><b>ค่าสูงสุด (MAX):</b> <?= $max !== null ? $max : '-' ?></p>
        <p><b>ค่าเฉลี่ย (AVERAGE):</b> <?= $average !== null ? number_format($average, 2) : '-' ?></p>
    `;
    
    document.getElementById("resultText").innerHTML = htmlContent;
    document.getElementById("resultModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("resultModal").style.display = "none";
}
</script>