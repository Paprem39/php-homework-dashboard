document.addEventListener("DOMContentLoaded", function () {

    if (homeworkResult) {

        document.getElementById("resultText").innerHTML = homeworkResult;

        document.getElementById("resultModal").style.display = "flex";

    }

});