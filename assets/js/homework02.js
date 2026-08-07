function checkNumber() {

    const num = parseInt(document.getElementById("num1").value);

    let result = "";

    if (isNaN(num)) {
        result = "กรุณากรอกตัวเลข";
    } else if (num % 2 === 0) {
        result = num + " เป็นเลขคู่";
    } else {
        result = num + " เป็นเลขคี่";
    }

    document.getElementById("resultText").innerHTML = result;

    // เปิด Modal
    document.getElementById("resultModal").style.display = "flex";

}