<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en" class="text-[12px] md:text-[14px] lg:text-[16px]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEOAFRICA</title>
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/output.css">
</head>
<body class="overflow-hidden">
    <div id="loading" class="fixed bg-white flex justify-center items-center opacity-100 transition-all duration-500 left-0 top-0 w-full h-full z-50 text-5xl">
        <i class="fa-solid fa-spinner text-primary animate-spin"></i>
    </div>