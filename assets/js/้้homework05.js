function saveToFile() {
    const textVal = document.getElementById("textInput").value;
    let result = "";

    if (textVal.trim() === "") {
        result = "กรุณากรอกข้อความก่อนบันทึก";
    } else {
        // จำลองการแสดงผลข้อความที่บันทึกลง Text File
        result = `<h3 style="margin-bottom: 10px; color: #e50914;">บันทึกข้อมูลสำเร็จ!</h3>`;
        result += `<p>ข้อความที่คุณกรอก: <b>${textVal}</b></p>`;
        result += `<hr style="border-color: #444; margin: 15px 0;">`;
        result += `<p style="color: #aaa; font-size: 0.9rem;">ข้อมูลถูกบันทึกและอ่านกลับมาจาก Text file เรียบร้อยแล้ว</p>`;
    }

    document.getElementById("resultText").innerHTML = result;

    // เปิด Modal แสดงผล
    document.getElementById("resultModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("resultModal").style.display = "none";
}