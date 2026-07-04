function calculate(){

    let num1 = parseFloat(document.getElementById("num1").value);

    let num2 = parseFloat(document.getElementById("num2").value);

    let op = document.getElementById("operator").value;


    if(isNaN(num1) || isNaN(num2)){

        document.getElementById("resultText").innerHTML =
        "Please enter both numbers.";

        document.getElementById("resultModal").style.display="flex";

        return;

    }

    let result;

    switch(op){

        case "+":
            result = num1 + num2;
            break;

        case "-":
            result = num1 - num2;
            break;

        case "*":
            result = num1 * num2;
            break;

        case "/":

            if(num2==0){

                document.getElementById("resultText").innerHTML =
                "Cannot divide by zero";

                document.getElementById("resultModal").style.display="flex";

                return;

            }

            result = num1 / num2;

            break;

    }

    document.getElementById("resultText").innerHTML =
    `${num1} ${op} ${num2} = <br><br><span style="color:#ff0048">${result}</span>`;

    document.getElementById("resultModal").style.display="flex";

}


function closeModal(){

    document.getElementById("resultModal").style.display="none";

}


function goHome(){

    window.location.href="../index.php";

}


function markDone(){

    localStorage.setItem("hw1","done");

    alert("Homework 01 Completed!");

}