<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
</head>

<body>

<form action="forminsert1.php" method="POST">

    <table border="0">

        <tr>
            <td><label for="fname">full name:</label></td>
            <td><input type="text" id="fname" name="Full_name"><br></td>
        </tr>

        <tr>
            <td><label for="gender">gender:</label></td>
            <td><input type="text" id="gender" name="Gender"><br></td>
        </tr>

        <tr>
            <td><label for="position">position:</label></td>
            <td><input type="text" id="position" name="Position"><br></td>
        </tr>

        <tr>
            <td><label for="salary">salary:</label></td>
            <td><input type="text" id="salary" name="Salary"><br></td>
        </tr>

        <tr>
            <td><label for="email">email:</label></td>
            <td><input type="text" id="email" name="Email"><br></td>
        </tr>

        <tr>
            <td><label for="birthday">birthday:</label></td>
            <td><input type="date" id="birthday" name="Birthday"><br></td>
        </tr>

    </table>

    <br>

    <input type="submit" value="Submit">

</form>


<?php

$link = mysqli_connect(
    "localhost",
    "sirichaiprem",
    "cet123456",
    "sirichaiprem"
) or die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ");


/* ตรวจสอบว่ามีการกด Submit หรือไม่ */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // รับค่าจาก Form
    $Full_name = $_POST["Full_name"];
    $Gender = $_POST["Gender"];
    $Position = $_POST["Position"];
    $Salary = $_POST["Salary"];
    $Email = $_POST["Email"];
    $Birthday = $_POST["Birthday"];


    // INSERT ข้อมูลลง Database
    $sql = "INSERT INTO employees
            (Full_name, Gender, Position, Salary, Email, Birthday)
            VALUES
            ('$Full_name', '$Gender', '$Position', '$Salary', '$Email', '$Birthday')";


    $r = mysqli_query($link, $sql);


    if (!$r) {

        echo "การเพิ่มข้อมูล เกิดข้อผิดพลาด <br>";

    } else {

        echo "การเพิ่มข้อมูล เสร็จเรียบร้อย <br>";

    }
}


mysqli_close($link);

?>

</body>
</html>