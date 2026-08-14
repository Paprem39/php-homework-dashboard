<?php

if(isset($_GET['keyword'])) { //ถ้าเป็นการ Postback
    $search = $_GET['search'];
    $kw = $_GET['keyword'];
    $match = $_GET['match'];
    $price = $_GET['price'];
    $field = implode(", ", $_GET['field']); //รวมให้เป็นสตริงเดียวกันคั่นด้วย ", "
    //จัดวางสัญลักษณ์ wildcard ให้สอดคล้องกับต าแหน่งค าที่เลือก
        if($match == "part") {
        //ถ้าเลือกส่วนใดส่วนหนึ่งของค า ให้แทนที่ช่องว่างระหว่างค าด้วย %
        //เพื่อให้สามารถมีข้อความอื่นแทรกอยู่ระหว่างค าเหล่านี้ได้
        $kw = preg_replace("/[ ]{1,}/i", "%", $kw);
        $kw = "%".$kw."%";
        }
            else if($match == "start") {
            $kw = "$kw%";
            }
            else if($match == "end") {
            $kw = "%$kw";
            }
    //น าค่าจากตัวแปรต่างๆมาแทรกลงใน SQL
    $sql = "SELECT $field FROM book
    WHERE ($search LIKE '$kw') AND (price $price)";
    //สามารถน าค าสั่ง SQL ที่ได้นี้ไปใช้ร่วมกับฟังก์ชัน mysql_query() ได้เลย
    echo "ตัวอย่างค าสั่ง SQL ที่ได้:";
    echo "<div>".nl2br($sql)."</div>";
    echo "<p><a href=\"javascript: history.back();\">ย้อนกลับ</a></p>";
    echo "</body></html>";
    exit;
}

?>

<fieldset>
    <legend>ระบบสืบค้นหนังสือ</legend>

    <form method="get">

        <input type="radio" name="search" value="title" checked>
        ชื่อหนังสือ

        <input type="radio" name="search" value="author">
        นักเขียน

        <input type="radio" name="search" value="publisher">
        สำนักพิมพ์

        <br>

        <input type="text" name="keyword" required>

        <br>

        <select name="match">
            <option value="part">ส่วนของคำ</option>
            <option value="whole">ตรงกันทั้งคำ</option>
            <option value="start">ขึ้นต้นด้วย</option>
            <option value="end">ลงท้ายด้วย</option>
        </select>

        <select name="price">
            <option value="> 0">ทุกระดับราคา</option>
            <option value="<= 200">ไม่เกิน 200</option>
            <option value="BETWEEN 200 AND 250">200 - 250</option>
            <option value="BETWEEN 250 AND 300">250 - 300</option>
            <option value="BETWEEN 300 AND 400">300 - 400</option>
            <option value=">= 400">400 ขึ้นไป</option>
        </select>

        <button type="submit">ค้นหา</button>

        <br>

        ข้อมูลที่แสดงในผลลัพธ์:<br>

        <input type="checkbox" name="field[]" value="title" checked required>
        ชื่อหนังสือ

        <input type="checkbox" name="field[]" value="author" checked required>
        นักเขียน

        <input type="checkbox" name="field[]" value="publisher" checked required>
        สนพ.

        <input type="checkbox" name="field[]" value="price" checked>
        ราคา

        <input type="checkbox" name="field[]" value="isbn" checked>
        ISBN

    </form>
</fieldset>