<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "sirichaiprem";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // จัดการบันทึกข้อมูลเมื่อเพิ่มพนักงานใหม่
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_employee') {
        $full_name = trim($_POST['Full_name']);
        $gender = trim($_POST['Gender']);
        $position = trim($_POST['Position']);
        $salary = trim($_POST['Salary']);
        $email = trim($_POST['Email']);
        $birthday = trim($_POST['Birthday']);

        $insert_sql = "INSERT INTO employees (Full_name, Gender, Position, Salary, Email, Birthday) VALUES (:full_name, :gender, :position, :salary, :email, :birthday)";
        $stmt_insert = $conn->prepare($insert_sql);
        $stmt_insert->execute([
            ':full_name' => $full_name,
            ':gender' => $gender,
            ':position' => $position,
            ':salary' => $salary,
            ':email' => $email,
            ':birthday' => $birthday
        ]);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // จัดการอัปเดตข้อมูลพนักงาน (แก้ไข)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_employee') {
        $employee_id = $_POST['Employee_id'];
        $full_name = trim($_POST['Full_name']);
        $gender = trim($_POST['Gender']);
        $position = trim($_POST['Position']);
        $salary = trim($_POST['Salary']);
        $email = trim($_POST['Email']);
        $birthday = trim($_POST['Birthday']);

        $update_sql = "UPDATE employees SET Full_name = :full_name, Gender = :gender, Position = :position, Salary = :salary, Email = :email, Birthday = :birthday WHERE Employee_id = :employee_id";
        $stmt_update = $conn->prepare($update_sql);
        $stmt_update->execute([
            ':full_name' => $full_name,
            ':gender' => $gender,
            ':position' => $position,
            ':salary' => $salary,
            ':email' => $email,
            ':birthday' => $birthday,
            ':employee_id' => $employee_id
        ]);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // จัดการลบข้อมูลพนักงาน
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_employee') {
        $employee_id = $_POST['Employee_id'];

        $delete_sql = "DELETE FROM employees WHERE Employee_id = :employee_id";
        $stmt_delete = $conn->prepare($delete_sql);
        $stmt_delete->execute([':employee_id' => $employee_id]);

        header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
        exit();
    }

    // รับค่าคำค้นหาจากฟอร์ม (ถ้ามี)
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    if ($search !== '') {
        $sql = "SELECT * FROM employees WHERE 
                Employee_id LIKE :search OR 
                Full_name LIKE :search OR 
                Gender LIKE :search OR 
                Position LIKE :search OR 
                Salary LIKE :search OR 
                Email LIKE :search OR 
                Birthday LIKE :search";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("SELECT * FROM employees");
        $stmt->execute();
    }
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Employee Management</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 30px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #333;
            margin-bottom: 5px;
        }
        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-container {
            display: flex;
            gap: 10px;
        }
        .search-container input[type="text"] {
            padding: 8px 12px;
            font-size: 14px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
        }
        .search-container input[type="text"]:focus {
            border-color: #007bff;
        }
        .btn {
            padding: 8px 16px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-primary:hover { background-color: #0056b3; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-success:hover { background-color: #218838; }
        .btn-warning { background-color: #ffc107; color: #212529; }
        .btn-warning:hover { background-color: #e0a800; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-danger:hover { background-color: #c82333; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .btn-secondary:hover { background-color: #5a6268; }
        .btn-sm { padding: 5px 10px; font-size: 12px; }

        /* ตาราง */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        th {
            background-color: #e0e0e0;
            color: #333;
            text-align: left;
            padding: 10px 12px;
            font-weight: 600;
            border-bottom: 2px solid #ccc;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            color: #444;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        tbody tr:nth-child(even) { background-color: #f2f2f2; }
        tbody tr:hover { background-color: #e9f2ff; }

        /* Modal Popup */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5); 
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            position: relative;
        }
        .modal-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 12px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
            color: #555;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        .close-btn {
            float: right;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            color: #aaa;
        }
        .close-btn:hover { color: #000; }
        
        .delete-text {
            font-size: 15px;
            color: #333;
            line-height: 1.5;
            margin-bottom: 10px;
        }
        .delete-subtext {
            font-size: 13px;
            color: #dc3545;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <h2>รายชื่อพนักงาน (Employees)</h2>

    <div class="top-actions">
        <div class="search-container">
            <form method="GET" action="" style="display: flex; gap: 10px; align-items: center;">
                <input type="text" name="search" placeholder="ค้นหาข้อมูลพนักงาน..." value="<?= htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary">ค้นหา</button>
                <?php if (!empty($search)) { ?>
                    <a href="connect.php" class="btn btn-secondary">ล้างค่า</a>
                <?php } ?>
            </form>
        </div>
        <div>
            <button class="btn btn-success" onclick="openAddModal()">+ เพิ่มพนักงานใหม่</button>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Employee_id</th>
                <th>Full_name</th>
                <th>Gender</th>
                <th>Position</th>
                <th>Salary</th>
                <th>Email</th>
                <th>Birthday</th>
                <th class="text-center">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($result)) { ?>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td class="text-center"><?= htmlspecialchars($row["Employee_id"]); ?></td>
                        <td><?= htmlspecialchars($row["Full_name"]); ?></td>
                        <td><?= htmlspecialchars($row["Gender"]); ?></td>
                        <td><?= htmlspecialchars($row["Position"]); ?></td>
                        <td class="text-right"><?= number_format($row["Salary"]); ?></td>
                        <td><?= htmlspecialchars($row["Email"]); ?></td>
                        <td class="text-center"><?= htmlspecialchars($row["Birthday"]); ?></td>
                        <td class="text-center" style="display: flex; gap: 5px; justify-content: center;">
                            <button class="btn btn-warning btn-sm" onclick="openEditModal(
                                '<?= htmlspecialchars($row['Employee_id'], ENT_QUOTES); ?>',
                                '<?= htmlspecialchars($row['Full_name'], ENT_QUOTES); ?>',
                                '<?= htmlspecialchars($row['Gender'], ENT_QUOTES); ?>',
                                '<?= htmlspecialchars($row['Position'], ENT_QUOTES); ?>',
                                '<?= htmlspecialchars($row['Salary'], ENT_QUOTES); ?>',
                                '<?= htmlspecialchars($row['Email'], ENT_QUOTES); ?>',
                                '<?= htmlspecialchars($row['Birthday'], ENT_QUOTES); ?>'
                            )">แก้ไข</button>
                            
                            <button class="btn btn-danger btn-sm" onclick="openDeleteModal(
                                '<?= htmlspecialchars($row['Employee_id'], ENT_QUOTES); ?>',
                                '<?= htmlspecialchars($row['Full_name'], ENT_QUOTES); ?>'
                            )">ลบ</button>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #777;">ไม่พบข้อมูลพนักงาน</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Modal Popup เพิ่มข้อมูล -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeAddModal()">&times;</span>
            <div class="modal-header">เพิ่มข้อมูลพนักงานใหม่</div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add_employee">
                
                <div class="form-group">
                    <label>ชื่อ-นามสกุล (Full Name)</label>
                    <input type="text" name="Full_name" required>
                </div>
                <div class="form-group">
                    <label>เพศ (Gender)</label>
                    <select name="Gender" required>
                        <option value="">-- เลือกเพศ --</option>
                        <option value="ชาย">ชาย</option>
                        <option value="หญิง">หญิง</option>
                        <option value="male">male</option>
                        <option value="famale">famale</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>ตำแหน่ง (Position)</label>
                    <input type="text" name="Position" required>
                </div>
                <div class="form-group">
                    <label>เงินเดือน (Salary)</label>
                    <input type="number" name="Salary" required>
                </div>
                <div class="form-group">
                    <label>อีเมล (Email)</label>
                    <input type="email" name="Email" required>
                </div>
                <div class="form-group">
                    <label>วันเกิด (Birthday)</label>
                    <input type="date" name="Birthday" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAddModal()">ยกเลิก</button>
                    <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Popup แก้ไขข้อมูล -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <div class="modal-header">แก้ไขข้อมูลพนักงาน</div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="edit_employee">
                <input type="hidden" name="Employee_id" id="edit_employee_id">
                
                <div class="form-group">
                    <label>ชื่อ-นามสกุล (Full Name)</label>
                    <input type="text" name="Full_name" id="edit_full_name" required>
                </div>
                <div class="form-group">
                    <label>เพศ (Gender)</label>
                    <select name="Gender" id="edit_gender" required>
                        <option value="">-- เลือกเพศ --</option>
                        <option value="ชาย">ชาย</option>
                        <option value="หญิง">หญิง</option>
                        <option value="male">male</option>
                        <option value="famale">famale</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>ตำแหน่ง (Position)</label>
                    <input type="text" name="Position" id="edit_position" required>
                </div>
                <div class="form-group">
                    <label>เงินเดือน (Salary)</label>
                    <input type="number" name="Salary" id="edit_salary" required>
                </div>
                <div class="form-group">
                    <label>อีเมล (Email)</label>
                    <input type="email" name="Email" id="edit_email" required>
                </div>
                <div class="form-group">
                    <label>วันเกิด (Birthday)</label>
                    <input type="date" name="Birthday" id="edit_birthday" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">ยกเลิก</button>
                    <button type="submit" class="btn btn-warning">บันทึกการแก้ไข</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Popup ยืนยันการลบ (ดีไซน์สวยงาม) -->
    <div id="deleteModal" class="modal">
        <div class="modal-content" style="width: 350px;">
            <span class="close-btn" onclick="closeDeleteModal()">&times;</span>
            <div class="modal-header" style="color: #dc3545; border-bottom: 1px solid #f8d7da;">ยืนยันการลบข้อมูล</div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="delete_employee">
                <input type="hidden" name="Employee_id" id="delete_employee_id">
                
                <div class="delete-text">
                    คุณต้องการลบข้อมูลพนักงานคนนี้ <br>
                    <strong id="delete_employee_name" style="color: #000;"></strong> ใช่หรือไม่?
                    <div class="delete-subtext" style="margin-top: 8px;">* เมื่อลบแล้วจะไม่สามารถกู้คืนข้อมูลได้</div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">ยกเลิก</button>
                    <button type="submit" class="btn btn-danger">ยืนยันการลบ</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript ควบคุม Modal -->
    <script>
        function openAddModal() {
            document.getElementById('addModal').style.display = 'flex';
        }
        function closeAddModal() {
            document.getElementById('addModal').style.display = 'none';
        }

        function openEditModal(id, fullName, gender, position, salary, email, birthday) {
            document.getElementById('edit_employee_id').value = id;
            document.getElementById('edit_full_name').value = fullName;
            document.getElementById('edit_gender').value = gender;
            document.getElementById('edit_position').value = position;
            document.getElementById('edit_salary').value = salary;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_birthday').value = birthday;
            
            document.getElementById('editModal').style.display = 'flex';
        }
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function openDeleteModal(id, fullName) {
            document.getElementById('delete_employee_id').value = id;
            document.getElementById('delete_employee_name').innerText = fullName + ' (ID: ' + id + ')';
            document.getElementById('deleteModal').style.display = 'flex';
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
    </script>
</body>
</html>