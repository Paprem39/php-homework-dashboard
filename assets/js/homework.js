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

