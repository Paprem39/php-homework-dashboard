<?php
$message = "";

// ปรับ Path ของ uploads ให้ตรงกับตำแหน่งที่รันผ่าน index.php หน้าหลัก
$uploadDir = "uploads/";

// ================= Delete File =================
if (isset($_GET["delete"])) {
    $deleteFile = basename($_GET["delete"]);
    $deletePath = $uploadDir . $deleteFile;

    if (file_exists($deletePath)) {
        unlink($deletePath);
        $message = "✅ ลบไฟล์เรียบร้อยแล้ว";
    }
}

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// ================= Upload File =================
if (isset($_POST["upload"])) {
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $fileName = preg_replace("/[^a-zA-Z0-9._-]/", "_", basename($_FILES["image"]["name"]));
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allow = ["jpg", "jpeg", "png"];

        $fileType = mime_content_type($tmpName);
        $allowTypes = [
            "image/jpeg",
            "image/png"
        ];

        if (!in_array($extension, $allow) || !in_array($fileType, $allowTypes)) {
            $message = "❌ อนุญาตเฉพาะไฟล์ JPG, JPEG และ PNG";
        } elseif ($fileSize > 2 * 1024 * 1024) {
            $message = "❌ ขนาดไฟล์ต้องไม่เกิน 2 MB";
        } else {
            $newName = uniqid() . "_" . $fileName;

            if (move_uploaded_file($tmpName, $uploadDir . $newName)) {
                $message = "✅ อัปโหลดไฟล์สำเร็จ";
            } else {
                $message = "❌ กรุณาเลือกไฟล์หรือเกิดข้อผิดพลาดในการอัปโหลด";
            }
        }
    }
}
?>

<section class="homework-page">

    <div class="homework-card">

        <div class="homework-title">

            <h1>🖼 Homework 06</h1>

            <p>Upload & Download Image</p>

        </div>

        <form method="post" enctype="multipart/form-data">

            <div class="form-group" style="margin-bottom: 15px;">
                <input type="file" name="image" required style="color: #fff;">
            </div>

            <button type="submit" name="upload" class="calculate-btn">
                UPLOAD IMAGE
            </button>

        </form>

        <br>

        <?php if (!empty($message)): ?>
            <p style="color: #e50914; font-weight: bold;"><?= $message ?></p>
        <?php endif; ?>

        <hr style="border-color: #444; margin: 20px 0;">

        <h2>Uploaded Images</h2>

        <div class="file-list-container" style="max-height: 250px; overflow-y: auto; margin-top: 15px; text-align: left;">
            <?php
            $files = array_diff(scandir($uploadDir, SCANDIR_SORT_DESCENDING), [".", ".."]);

            if (count($files) == 0) {
                echo "<p style='color: #aaa;'>ยังไม่มีไฟล์รูปภาพ</p>";
            } else {
                foreach ($files as $file) {
                echo "<div class='file-item' style='display: flex; justify-content: space-between; align-items: center; background: #1a1a1a; padding: 10px; margin-bottom: 8px; border-radius: 6px; border: 1px solid #333;'>";
                
                    // ส่วนแสดงรูป Thumbnail และชื่อไฟล์
                    echo "<div class='file-info' style='display: flex; align-items: center; gap: 12px;'>";
                        // แสดงรูปภาพตัวอย่างขนาดเล็ก
                        echo "<img src='uploads/" . urlencode($file) . "' alt='Thumbnail' style='width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #444;'>";
                        // ชื่อไฟล์ (จำกัดความยาวหรือตัดบรรทัดได้ตามต้องการ)
                        echo "<span class='file-name' style='color: #fff; font-size: 0.85rem; max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'>" . htmlspecialchars($file) . "</span>";
                    echo "</div>";
            
                    // ปุ่มจัดการ (Download / Delete)
                    echo "<div class='file-actions' style='display: flex; gap: 10px;'>";
            
                        echo "<a class='download-btn' href='uploads/" . urlencode($file) . "' download style='background: #28a745; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.9rem;'>";
                            echo "<i class='fa-solid fa-download'></i> Download";
                        echo "</a>";
            
                        echo "<a class='delete-btn' href='?page=hw6&delete=" . urlencode($file) . "' onclick=\"return confirm('Delete this image?')\" style='background: #dc3545; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.9rem;'>";
                            echo "<i class='fa-solid fa-trash'></i> Delete";
                        echo "</a>";
            
                    echo "</div>";
                
                echo "</div>";
                }
            }
            ?>
        </div>

    </div>

</section>