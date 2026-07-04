<?php

$basePath = "";

if (strpos($_SERVER['PHP_SELF'], '/homework/') !== false) {
    $basePath = "../";
}

?>

<!DOCTYPE html>
<html lang="th">

<head>
<link rel="icon"
      type="image/svg+xml"
      href="<?= $basePath ?>assets/img/logo.svg">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Web Programming Laboratory</title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= $basePath ?>assets/css/style.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

</head>

<body>
    <div id="loader">
        <div class="loader-box"></div>
        <p>Loading Web Programming Lab...</p>
    </div>

    <canvas id="particles"></canvas>

    <!-- ================= HEADER ================= -->

    <header class="header">

        <div class="logo-area">

        <div class="logo">

    <img
        src="<?= $basePath ?>assets/img/logo.svg"
        alt="WP Logo">

</div>

            <div>

                <h1>ปฏิบัติการเขียนโปรแกรมบนเว็บ</h1>

                <p>WEB PROGRAMMING LABORATORY</p>

            </div>

        </div>

        <div class="header-right">

    <a href="#" class="github-btn">

        <i class="fa-brands fa-github"></i>

        GitHub

    </a>

    <div class="header-info">

        <div id="clock"></div>

        <div id="date"></div>

    </div>

</div>

    </header>