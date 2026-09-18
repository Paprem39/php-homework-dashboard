function calculateGrade() {
    const score = parseFloat(document.getElementById("scoreInput").value);
    let result = "";

    if (isNaN(score)) {
        result = "กรุณากรอกคะแนนที่เป็นตัวเลข";
    } else if (score < 0 || score > 100) {
        result = "กรุณากรอกคะแนนระหว่าง 0 ถึง 100";
    } else {
        let grade = "";
        if (score >= 80) {
            grade = "A";
        } else if (score >= 75) {
            grade = "B+";
        } else if (score >= 70) {
            grade = "B";
        } else if (score >= 65) {
            grade = "C+";
        } else if (score >= 60) {
            grade = "C";
        } else if (score >= 55) {
            grade = "D+";
        } else if (score >= 50) {
            grade = "D";
        } else {
            grade = "F";
        }
        result = `คะแนน ${score} ได้เกรด <b>${grade}</b> 🎉`;
    }

    document.getElementById("resultText").innerHTML = result;

    // เปิด Modal
    document.getElementById("resultModal").style.display = "flex";
}

// ฟังก์ชันปิด Modal (ถ้าในโปรเจ็คมีฟังก์ชันนี้อยู่แล้วที่ไฟล์อื่น สามารถข้ามได้ครับ)
function closeModal() {
    document.getElementById("resultModal").style.display = "none";
}