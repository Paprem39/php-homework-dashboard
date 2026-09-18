<?php
// กำหนดค่าการเชื่อมต่อฐานข้อมูล (ใช้ตัวแปร $conn ร่วมกับโปรเจคหลัก)
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "sirichaiprem";

$login_error = "";

try {
    // ใช้ตัวแปร $conn เชื่อมต่อฐานข้อมูล
    if (!isset($conn)) {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // จัดการระบบ Login เชื่อมกับตาราง member ในฐานข้อมูลจริง
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
        $input_user = trim($_POST['login_username']);
        $input_pass = trim($_POST['login_password']);

        $stmt_member = $conn->prepare("SELECT * FROM member WHERE user = :user");
        $stmt_member->execute([':user' => $input_user]);
        $member_row = $stmt_member->fetch(PDO::FETCH_ASSOC);

        if ($member_row && $input_pass === $member_row['password']) {
            $_SESSION['role'] = $member_row['role']; 
            $_SESSION['username'] = $member_row['user'];
            header("Location: index.php?page=hw8&login=success");
            exit();
        } else {
            $login_error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง";
        }
    }

    // จัดการระบบ Logout
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        unset($_SESSION['role']);
        unset($_SESSION['username']);
        header("Location: index.php?page=hw8");
        exit();
    }

    // ตรวจสอบสิทธิ์ว่าเป็น Admin หรือไม่
    $is_admin = isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin';

    // จัดการเพิ่มพนักงาน (เฉพาะ Admin)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_employee' && $is_admin) {
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

        header("Location: index.php?page=hw8");
        exit();
    }

    // จัดการแก้ไขพนักงาน (เฉพาะ Admin)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_employee' && $is_admin) {
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

        header("Location: index.php?page=hw8");
        exit();
    }

    // จัดการลบพนักงาน (เฉพาะ Admin)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_employee' && $is_admin) {
        $employee_id = $_POST['Employee_id'];
        $delete_sql = "DELETE FROM employees WHERE Employee_id = :employee_id";
        $stmt_delete = $conn->prepare($delete_sql);
        $stmt_delete->execute([':employee_id' => $employee_id]);

        header("Location: index.php?page=hw8");
        exit();
    }

    // ค้นหาข้อมูลพนักงาน
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
    echo "<div style='color: #ff5555; padding: 20px;'>เกิดข้อผิดพลาดฐานข้อมูล: " . $e->getMessage() . "</div>";
}
?>

<section class="homework-page" style="padding: 20px;">
    <div class="homework-card" style="max-width: 1000px; margin: 0 auto; background: #1a1a1a; padding: 25px; border-radius: 8px; border: 1px solid #333; color: #ddd;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #333; padding-bottom: 15px;">
            <div>
                <h2 style="color: #fff; margin: 0 0 5px 0;">👥 Homework 08: Employee Management</h2>
                <p style="color: #aaa; margin: 0; font-size: 0.9rem;">ระบบจัดการข้อมูลพนักงานพร้อมระบบสิทธิ์ผู้ใช้งาน (Admin / User)</p>
            </div>
            <div class="user-status">
                <?php if (isset($_SESSION['role'])) { ?>
                    <span style="font-size: 14px; color: #ccc;">เข้าสู่ระบบเป็น: <strong style="color: #fff;"><?= htmlspecialchars($_SESSION['username']); ?></strong> (<?= strtoupper($_SESSION['role']); ?>)</span>
                    <a href="index.php?page=hw8&action=logout" class="btn btn-secondary btn-sm" style="background: #6c757d; color: white; padding: 5px 12px; border-radius: 4px; text-decoration: none; font-size: 12px;">ออกจากระบบ</a>
                <?php } else { ?>
                    <button class="btn btn-primary btn-sm" onclick="openLoginModal()" style="background: #007bff; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">🔑 เข้าสู่ระบบ (Login)</button>
                <?php } ?>
            </div>
        </div>

        <?php if (isset($_GET['login']) && $_GET['login'] === 'success') { ?>
            <div style="background-color: #d4edda; color: #155724; padding: 10px 15px; border-radius: 4px; margin-bottom: 15px; font-size: 14px;">เข้าสู่ระบบสำเร็จ! เข้าใช้งานตามสิทธิ์เรียบร้อยแล้ว</div>
        <?php } ?>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
            <div class="search-container">
                <form method="GET" action="index.php" style="display: flex; gap: 10px; align-items: center;">
                    <input type="hidden" name="page" value="hw8">
                    <input type="text" name="search" placeholder="ค้นหาข้อมูลพนักงาน..." value="<?= htmlspecialchars($search); ?>" style="padding: 8px 12px; font-size: 14px; width: 250px; background: #222; border: 1px solid #444; color: #fff; border-radius: 4px;">
                    <button type="submit" style="background: #007bff; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">ค้นหา</button>
                    <?php if (!empty($search)) { ?>
                        <a href="index.php?page=hw8" style="background: #6c757d; color: white; padding: 8px 12px; border-radius: 4px; text-decoration: none; font-size: 14px;">ล้างค่า</a>
                    <?php } ?>
                </form>
            </div>
            <div>
                <?php if ($is_admin) { ?>
                    <button onclick="openAddModal()" style="background: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">+ เพิ่มพนักงานใหม่</button>
                <?php } ?>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; background-color: #222; color: #ddd; font-size: 0.9rem;">
                <thead>
                    <tr style="background-color: #333; color: #fff;">
                        <th style="padding: 10px; border: 1px solid #444; text-align: center;">ID</th>
                        <th style="padding: 10px; border: 1px solid #444; text-align: left;">Full Name</th>
                        <th style="padding: 10px; border: 1px solid #444; text-align: center;">Gender</th>
                        <th style="padding: 10px; border: 1px solid #444; text-align: left;">Position</th>
                        <th style="padding: 10px; border: 1px solid #444; text-align: right;">Salary</th>
                        <th style="padding: 10px; border: 1px solid #444; text-align: left;">Email</th>
                        <th style="padding: 10px; border: 1px solid #444; text-align: center;">Birthday</th>
                        <?php if ($is_admin) { ?>
                            <th style="padding: 10px; border: 1px solid #444; text-align: center;">จัดการ</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($result)) { ?>
                        <?php foreach ($result as $row) { ?>
                            <tr style="border-bottom: 1px solid #333;">
                                <td style="padding: 10px; border: 1px solid #444; text-align: center;"><?= htmlspecialchars($row["Employee_id"]); ?></td>
                                <td style="padding: 10px; border: 1px solid #444;"><?= htmlspecialchars($row["Full_name"]); ?></td>
                                <td style="padding: 10px; border: 1px solid #444; text-align: center;"><?= htmlspecialchars($row["Gender"]); ?></td>
                                <td style="padding: 10px; border: 1px solid #444;"><?= htmlspecialchars($row["Position"]); ?></td>
                                <td style="padding: 10px; border: 1px solid #444; text-align: right;"><?= number_format($row["Salary"]); ?></td>
                                <td style="padding: 10px; border: 1px solid #444;"><?= htmlspecialchars($row["Email"]); ?></td>
                                <td style="padding: 10px; border: 1px solid #444; text-align: center;"><?= htmlspecialchars($row["Birthday"]); ?></td>
                                
                                <?php if ($is_admin) { ?>
                                    <td style="padding: 10px; border: 1px solid #444; text-align: center;">
                                        <div style="display: flex; gap: 5px; justify-content: center;">
                                            <button style="background: #ffc107; color: #000; border: none; padding: 4px 8px; border-radius: 3px; cursor: pointer; font-size: 12px;" onclick="openEditModal(
                                                '<?= htmlspecialchars($row['Employee_id'], ENT_QUOTES); ?>',
                                                '<?= htmlspecialchars($row['Full_name'], ENT_QUOTES); ?>',
                                                '<?= htmlspecialchars($row['Gender'], ENT_QUOTES); ?>',
                                                '<?= htmlspecialchars($row['Position'], ENT_QUOTES); ?>',
                                                '<?= htmlspecialchars($row['Salary'], ENT_QUOTES); ?>',
                                                '<?= htmlspecialchars($row['Email'], ENT_QUOTES); ?>',
                                                '<?= htmlspecialchars($row['Birthday'], ENT_QUOTES); ?>'
                                            )">แก้ไข</button>
                                            
                                            <button style="background: #dc3545; color: #fff; border: none; padding: 4px 8px; border-radius: 3px; cursor: pointer; font-size: 12px;" onclick="openDeleteModal(
                                                '<?= htmlspecialchars($row['Employee_id'], ENT_QUOTES); ?>',
                                                '<?= htmlspecialchars($row['Full_name'], ENT_QUOTES); ?>'
                                            )">ลบ</button>
                                        </div>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="<?= $is_admin ? 8 : 7 ?>" style="text-align: center; padding: 20px; color: #777; border: 1px solid #444;">ไม่พบข้อมูลพนักงาน</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Modal Popup สำหรับ Login -->
        <div id="loginModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); justify-content: center; align-items: center;">
            <div style="background-color: #222; padding: 25px; border-radius: 8px; width: 350px; border: 1px solid #444; color: #fff; position: relative;">
                <span onclick="closeLoginModal()" style="position: absolute; right: 15px; top: 10px; font-size: 20px; cursor: pointer; color: #aaa;">&times;</span>
                <div style="font-size: 18px; font-weight: bold; margin-bottom: 15px; border-bottom: 1px solid #444; padding-bottom: 8px;">เข้าสู่ระบบ (Login)</div>
                
                <?php if (!empty($login_error)) { ?>
                    <div style="background-color: #f8d7da; color: #721c24; padding: 8px 12px; border-radius: 4px; margin-bottom: 12px; font-size: 13px; border: 1px solid #f5c6cb;">
                        <?= $login_error; ?>
                    </div>
                <?php } ?>

                <form method="POST" action="index.php?page=hw8">
                    <input type="hidden" name="action" value="login">
                    
                    <div style="margin-bottom: 12px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 13px; color: #ccc;">ชื่อผู้ใช้งาน (Username)</label>
                        <input type="text" name="login_username" placeholder="เช่น admin หรือ user" required style="width: 100%; padding: 8px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 13px; color: #ccc;">รหัสผ่าน (Password)</label>
                        <input type="password" name="login_password" placeholder="เช่น cet123456" required style="width: 100%; padding: 8px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px; box-sizing: border-box;">
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button type="button" onclick="closeLoginModal()" style="background: #6c757d; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">ยกเลิก</button>
                        <button type="submit" style="background: #007bff; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">เข้าสู่ระบบ</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Popup เพิ่มพนักงาน -->
        <?php if ($is_admin) { ?>
        <div id="addModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); justify-content: center; align-items: center;">
            <div style="background-color: #222; padding: 25px; border-radius: 8px; width: 380px; border: 1px solid #444; color: #fff; position: relative;">
                <span onclick="closeAddModal()" style="position: absolute; right: 15px; top: 10px; font-size: 20px; cursor: pointer; color: #aaa;">&times;</span>
                <div style="font-size: 18px; font-weight: bold; margin-bottom: 15px; border-bottom: 1px solid #444; padding-bottom: 8px;">เพิ่มข้อมูลพนักงานใหม่</div>
                
                <form method="POST" action="index.php?page=hw8">
                    <input type="hidden" name="action" value="add_employee">
                    
                    <div style="margin-bottom: 10px;"><label style="font-size: 13px; color: #ccc;">ชื่อ-นามสกุล</label><input type="text" name="Full_name" required style="width: 100%; padding: 7px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px;"></div>
                    <div style="margin-bottom: 10px;"><label style="font-size: 13px; color: #ccc;">เพศ</label>
                        <select name="Gender" required style="width: 100%; padding: 7px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px;">
                            <option value="">-- เลือกเพศ --</option>
                            <option value="ชาย">ชาย</option><option value="หญิง">หญิง</option>
                            <option value="male">male</option><option value="famale">famale</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 10px;"><label style="font-size: 13px; color: #ccc;">ตำแหน่ง</label><input type="text" name="Position" required style="width: 100%; padding: 7px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px;"></div>
                    <div style="margin-bottom: 10px;"><label style="font-size: 13px; color: #ccc;">เงินเดือน</label><input type="number" name="Salary" required style="width: 100%; padding: 7px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px;"></div>
                    <div style="margin-bottom: 10px;"><label style="font-size: 13px; color: #ccc;">อีเมล</label><input type="email" name="Email" required style="width: 100%; padding: 7px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px;"></div>
                    <div style="margin-bottom: 15px;"><label style="font-size: 13px; color: #ccc;">วันเกิด</label><input type="date" name="Birthday" required style="width: 100%; padding: 7px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px;"></div>

                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button type="button" onclick="closeAddModal()" style="background: #6c757d; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">ยกเลิก</button>
                        <button type="submit" style="background: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">บันทึกข้อมูล</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Popup แก้ไขพนักงาน -->
        <div id="editModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); justify-content: center; align-items: center;">
            <div style="background-color: #222; padding: 25px; border-radius: 8px; width: 380px; border: 1px solid #444; color: #fff; position: relative;">
                <span onclick="closeEditModal()" style="position: absolute; right: 15px; top: 10px; font-size: 20px; cursor: pointer; color: #aaa;">&times;</span>
                <div style="font-size: 18px; font-weight: bold; margin-bottom: 15px; border-bottom: 1px solid #444; padding-bottom: 8px;">แก้ไขข้อมูลพนักงาน</div>
                
                <form method="POST" action="index.php?page=hw8">
                    <input type="hidden" name="action" value="edit_employee">
                    <input type="hidden" name="Employee_id" id="edit_employee_id">
                    
                    <div style="margin-bottom: 10px;"><label style="font-size: 13px; color: #ccc;">ชื่อ-นามสกุล</label><input type="text" name="Full_name" id="edit_full_name" required style="width: 100%; padding: 7px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px;"></div>
                    <div style="margin-bottom: 10px;"><label style="font-size: 13px; color: #ccc;">เพศ</label>
                        <select name="Gender" id="edit_gender" required style="width: 100%; padding: 7px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px;">
                            <option value="">-- เลือกเพศ --</option>
                            <option value="ชาย">ชาย</option><option value="หญิง">หญิง</option>
                            <option value="male">male</option><option value="famale">famale</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 10px;"><label style="font-size: 13px; color: #ccc;">ตำแหน่ง</label><input type="text" name="Position" id="edit_position" required style="width: 100%; padding: 7px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px;"></div>
                    <div style="margin-bottom: 10px;"><label style="font-size: 13px; color: #ccc;">เงินเดือน</label><input type="number" name="Salary" id="edit_salary" required style="width: 100%; padding: 7px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px;"></div>
                    <div style="margin-bottom: 10px;"><label style="font-size: 13px; color: #ccc;">อีเมล</label><input type="email" name="Email" id="edit_email" required style="width: 100%; padding: 7px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px;"></div>
                    <div style="margin-bottom: 15px;"><label style="font-size: 13px; color: #ccc;">วันเกิด</label><input type="date" name="Birthday" id="edit_birthday" required style="width: 100%; padding: 7px; background: #111; border: 1px solid #444; color: #fff; border-radius: 4px;"></div>

                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button type="button" onclick="closeEditModal()" style="background: #6c757d; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">ยกเลิก</button>
                        <button type="submit" style="background: #ffc107; color: #000; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">บันทึกการแก้ไข</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Popup ลบพนักงาน -->
        <div id="deleteModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); justify-content: center; align-items: center;">
            <div style="background-color: #222; padding: 25px; border-radius: 8px; width: 350px; border: 1px solid #444; color: #fff; position: relative;">
                <span onclick="closeDeleteModal()" style="position: absolute; right: 15px; top: 10px; font-size: 20px; cursor: pointer; color: #aaa;">&times;</span>
                <div style="font-size: 18px; font-weight: bold; margin-bottom: 15px; border-bottom: 1px solid #444; padding-bottom: 8px; color: #dc3545;">ยืนยันการลบข้อมูล</div>
                
                <form method="POST" action="index.php?page=hw8">
                    <input type="hidden" name="action" value="delete_employee">
                    <input type="hidden" name="Employee_id" id="delete_employee_id">
                    
                    <div style="font-size: 14px; color: #ccc; line-height: 1.5; margin-bottom: 20px;">
                        คุณต้องการลบข้อมูลพนักงานคนนี้ <br>
                        <strong id="delete_employee_name" style="color: #fff;"></strong> ใช่หรือไม่?
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button type="button" onclick="closeDeleteModal()" style="background: #6c757d; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">ยกเลิก</button>
                        <button type="submit" style="background: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">ยืนยันการลบ</button>
                    </div>
                </form>
            </div>
        </div>
        <?php } ?>

    </div>
</section>

<!-- JavaScript ควบคุม Modal -->
<script>
    function openLoginModal() { document.getElementById('loginModal').style.display = 'flex'; }
    function closeLoginModal() { document.getElementById('loginModal').style.display = 'none'; }

    <?php if (!empty($login_error)) { ?>
        window.onload = function() { openLoginModal(); };
    <?php } ?>

    function openAddModal() { document.getElementById('addModal').style.display = 'flex'; }
    function closeAddModal() { document.getElementById('addModal').style.display = 'none'; }

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
    function closeEditModal() { document.getElementById('editModal').style.display = 'none'; }

    function openDeleteModal(id, fullName) {
        document.getElementById('delete_employee_id').value = id;
        document.getElementById('delete_employee_name').innerText = fullName + ' (ID: ' + id + ')';
        document.getElementById('deleteModal').style.display = 'flex';
    }
    function closeDeleteModal() { document.getElementById('deleteModal').style.display = 'none'; }
</script>