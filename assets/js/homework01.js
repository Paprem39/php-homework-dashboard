function calculate(){

    let num1 = parseFloat(document.getElementById("num1").value);

    let num2 = parseFloat(document.getElementById("num2").value);

    let op = document.getElementById("operator").value;

    if(isNaN(num1) || isNaN(num2)){

        openModal("Please enter both numbers.");

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

                openModal("Cannot divide by zero");

                return;

            }

            result = num1 / num2;

            break;

    }

    openModal(
        `${num1} ${op} ${num2}
        <br><br>
        <span style="color:#ff0048">${result}</span>`
    );

}