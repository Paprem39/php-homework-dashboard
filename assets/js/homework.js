/* ===========================================
   HOMEWORK COMMON FUNCTIONS
=========================================== */

// ---------- Popup ----------

function openModal(message){

    document.getElementById("resultText").innerHTML = message;

    document.getElementById("resultModal").style.display = "flex";

}

function closeModal(){

    document.getElementById("resultModal").style.display = "none";

}

// ---------- Back Home ----------

function goHome(){

    window.location.href = "../index.php";

}

// ---------- Assignment Done ----------

function markDone(homework){

    localStorage.setItem(homework,"done");

    alert(homework.toUpperCase() + " Completed!");

}