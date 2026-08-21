<body>
<?php

    $link = mysqli_connect("localhost", "sirichaiprem", "cet123456", "sirichaiprem")
    or die(mysqli_connect_error() . "</body></html>");

    $sql = "INSERT INTO employees VALUES
    ('','สมชาย พายเรือ','ชาย','ผู้จัดการ','35000','Somchai@gmail.com','1996-02-12')";

    $r = mysqli_query($link, $sql);

    if (!$r) 
    { 
        echo "การเพิ่มข้อมูล เกิดข้อผิดพลาด <br>"; 
    }
    else 
    { 
        echo "การเพิ่มข้อมูล เสร็จเรียบร้อย <br>"; 
    }

    mysqli_close($link);

?>
</body>