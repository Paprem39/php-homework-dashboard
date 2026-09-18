<?php
$sqlResult = "";

if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $search = $_GET['search'] ?? 'title';
    $kw = $_GET['keyword'];
    $match = $_GET['match'] ?? 'part';
    $price = $_GET['price'] ?? '> 0';
    
    if(isset($_GET['field']) && is_array($_GET['field'])) {
        $field = implode(", ", $_GET['field']);
    } else {
        $field = "*";
    }

    if($match == "part") {
        $kw = preg_replace("/[ ]{1,}/i", "%", $kw);
        $kw = "%".$kw."%";
    } else if($match == "start") {
        $kw = $kw."%";
    } else if($match == "end") {
        $kw = "%".$kw;
    } else if($match == "whole") {
        // ตรงกันทั้งคำ
    }

    $sql = "SELECT $field FROM book WHERE ($search LIKE '$kw') AND (price $price)";
    
    $sqlResult = "<b>ตัวอย่างคำสั่ง SQL ที่ได้:</b><br><div style='background: #1a1a1a; padding: 15px; border-radius: 6px; margin-top: 10px; color: #ff5555; word-break: break-all; border: 1px solid #333; font-family: monospace;'>" . nl2br($sql) . "</div>";
}
?>

<section class="homework-page">
    <div class="homework-card" style="max-width: 650px; margin: 0 auto;">
        
        <div class="homework-title">
            <h1>📚 Homework 07</h1>
            <p>ระบบสืบค้นหนังสือ (Book Search System)</p>
        </div>

        <?php if (!empty($sqlResult)): ?>
            <div style="margin-bottom: 20px; text-align: left;">
                <?= $sqlResult ?>
                <br>
                <a href="?page=hw7" style="display: inline-block; margin-top: 15px; background: #e50914; color: white; padding: 8px 20px; border-radius: 4px; text-decoration: none; font-weight: bold;">
                    <i class="fa-solid fa-arrow-left"></i> ย้อนกลับไปค้นหาใหม่
                </a>
            </div>
        <?php else: ?>

            <form method="get" action="">
                <input type="hidden" name="page" value="hw7">

                <!-- จัดระเบียบ Radio Button ให้เรียงแถวนอนสวยงาม -->
                <div class="form-group" style="text-align: left; margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #fff; font-weight: bold;">ค้นหาจาก:</label>
                    <div style="display: flex; gap: 20px; flex-wrap: wrap; color: #ccc;">
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 6px;">
                            <input type="radio" name="search" value="title" checked> ชื่อหนังสือ
                        </label>
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 6px;">
                            <input type="radio" name="search" value="author"> นักเขียน
                        </label>
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 6px;">
                            <input type="radio" name="search" value="publisher"> สำนักพิมพ์
                        </label>
                    </div>
                </div>

                <div class="form-group" style="text-align: left; margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #fff; font-weight: bold;">คำค้นหา (Keyword):</label>
                    <input type="text" name="keyword" placeholder="กรอกชื่อ, นักเขียน หรือสำนักพิมพ์..." required style="width: 100%; padding: 12px; background: #222; border: 1px solid #444; color: #fff; border-radius: 4px;">
                </div>

                <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                    <div style="flex: 1; text-align: left;">
                        <label style="display: block; margin-bottom: 8px; color: #fff; font-weight: bold;">รูปแบบการค้นหา:</label>
                        <select name="match" style="width: 100%; padding: 12px; background: #222; border: 1px solid #444; color: #fff; border-radius: 4px;">
                            <option value="part">ส่วนของคำ</option>
                            <option value="whole">ตรงกันทั้งคำ</option>
                            <option value="start">ขึ้นต้นด้วย</option>
                            <option value="end">ลงท้ายด้วย</option>
                        </select>
                    </div>

                    <div style="flex: 1; text-align: left;">
                        <label style="display: block; margin-bottom: 8px; color: #fff; font-weight: bold;">ช่วงราคา:</label>
                        <select name="price" style="width: 100%; padding: 12px; background: #222; border: 1px solid #444; color: #fff; border-radius: 4px;">
                            <option value="> 0">ทุกระดับราคา</option>
                            <option value="<= 200">ไม่เกิน 200</option>
                            <option value="BETWEEN 200 AND 250">200 - 250</option>
                            <option value="BETWEEN 250 AND 300">250 - 300</option>
                            <option value="BETWEEN 300 AND 400">300 - 400</option>
                            <option value=">= 400">400 ขึ้นไป</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="text-align: left; margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; color: #fff; font-weight: bold;">ข้อมูลที่แสดงในผลลัพธ์:</label>
                    <div style="display: flex; flex-wrap: wrap; gap: 20px; color: #ccc;">
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 6px;"><input type="checkbox" name="field[]" value="title" checked> ชื่อหนังสือ</label>
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 6px;"><input type="checkbox" name="field[]" value="author" checked> นักเขียน</label>
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 6px;"><input type="checkbox" name="field[]" value="publisher" checked> สนพ.</label>
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 6px;"><input type="checkbox" name="field[]" value="price" checked> ราคา</label>
                        <label style="cursor: pointer; display: flex; align-items: center; gap: 6px;"><input type="checkbox" name="field[]" value="isbn" checked> ISBN</label>
                    </div>
                </div>

                <button type="submit" class="calculate-btn" style="width: 100%; padding: 12px; background: #e50914; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 1rem;">
                    ค้นหาข้อมูลหนังสือ
                </button>

            </form>

        <?php endif; ?>

    </div>
</section>