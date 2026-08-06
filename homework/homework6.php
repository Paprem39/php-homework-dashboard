<?php include "../components/header.php"; ?>

<link rel="stylesheet" href="../assets/css/homework.css">

<?php

$message = "";

$uploadDir = __DIR__ . "/../uploads/";

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

            <input type="file" name="image" required>

            <br><br>

            <button type="submit" name="upload">
                Upload
            </button>

        </form>

        <br>

        <p><?= $message ?></p>

        <hr>

        <h2>Uploaded Images</h2>

        <?php

        $files = array_diff(scandir($uploadDir, SCANDIR_SORT_DESCENDING), [".", ".."]);

        if (count($files) == 0) {

            echo "<p>ยังไม่มีไฟล์</p>";

        } else {

            foreach ($files as $file) {

                echo "<div class='file-item'>";
            
                    echo "<div class='file-name'>";
                        echo "<i class='fa-solid fa-image'></i> ";
                        echo htmlspecialchars($file);
                    echo "</div>";
            
                    echo "<div class='file-actions'>";
            
                        echo "<a class='download-btn' href='../uploads/" . urlencode($file) . "' download>";
                            echo "<i class='fa-solid fa-download'></i> Download";
                        echo "</a>";
            
                        echo "<a class='delete-btn' href='?delete=" . urlencode($file) . "' onclick=\"return confirm('Delete this image?')\">";
                            echo "<i class='fa-solid fa-trash'></i> Delete";
                        echo "</a>";
            
                    echo "</div>";
            
                echo "</div>";
            
            }

        }

        ?>


        <div class="button-group">

            <button class="back-btn" onclick="goHome()">

                <i class="fa-solid fa-house"></i>

                BACK HOME

            </button>

            <button class="done-btn" onclick="markDone('hw6')">

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

            <div id="resultText"></div>

        </div>

    </div>

</div>


<!-- ================= ท้ายไฟล์ ================= --> 

<script src="../assets/js/homework.js?v=1"></script>
<script src="../assets/js/homework06.js"></script>

<!-- ================= เรียก footer มาทำงานทุกไฟล์ ================= --> 
<?php include "../components/footer.php"; ?>