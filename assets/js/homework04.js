function calculateMultiplication() {
    const num = parseInt(document.getElementById("numInput").value);
    let result = "";

    if (isNaN(num)) {
        result = "กรุณากรอกตัวเลขสำหรับคูณ";
    } else {
        result = `<h3 style="margin-bottom: 10px; color: #e50914; text-align: center;">แม่สูตรคูณแม่ ${num}</h3>`;
        result += `<ul style="list-style: none; padding: 0; line-height: 1.8; font-size: 1.1rem;">`;
        
        for (let i = 1; i <= 12; i++) {
            result += `<li>${num} × ${i} = <b>${num * i}</b></li>`;
        }
        
        result += `</ul>`;
    }

    document.getElementById("resultText").innerHTML = result;

    // เปิด Modal แสดงผล
    document.getElementById("resultModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("resultModal").style.display = "none";
}