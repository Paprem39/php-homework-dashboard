// ฟังก์ชันสำหรับปิด Modal (ถ้ามีการเรียกใช้งาน)
function closeModal() {
    const modal = document.getElementById("resultModal");
    if (modal) {
        modal.style.display = "none";
    }
}

// ตรวจสอบความพร้อมของ DOM สำหรับ Homework 06
document.addEventListener("DOMContentLoaded", function () {
    console.log("Homework 06 Loaded Successfully.");
});