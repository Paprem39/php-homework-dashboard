<!-- ================= FOOTER ================= -->

<footer>

<h3>WEB PROGRAMMING LABORATORY</h3>

<p>

    Developed by

    <strong>Sirichai Paisitvorakun</strong>

</p>

</footer>



<!-- JavaScript -->

<script src="<?= $basePath ?>assets/js/script.js?v=1"></script>

<script>

document.addEventListener("DOMContentLoaded", function(){

if(localStorage.getItem("hw1") === "done"){

    document.getElementById("hw1-status").innerHTML = "✔ DONE";

    document.getElementById("hw1-status").style.color = "#00ff88";

}

});

</script>



</body>

</html>