<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vet_title = mysqli_real_escape_string($conn, $_POST['vet_title']);
    $vet_givenname = mysqli_real_escape_string($conn, $_POST['vet_givenname']);
    $vet_familyname = mysqli_real_escape_string($conn, $_POST['vet_familyname']);
    $vet_phone = mysqli_real_escape_string($conn, $_POST['vet_phone']);

    $query = "INSERT INTO vet (vet_title, vet_givenname, vet_familyname, vet_phone) VALUES ('$vet_title', '$vet_givenname', '$vet_familyname', '$vet_phone')";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_vet.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Vet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFFAF0;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            padding: 40px;
        }

        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            color: #2980B9;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            background-color: #2980B9;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #3498DB;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-container">
        <h2>Tambah Vet</h2>
        <form method="POST">
            <input type="text" name="vet_title" placeholder="Title" required>
            <input type="text" name="vet_givenname" placeholder="Given Name" required>
            <input type="text" name="vet_familyname" placeholder="Family Name" required>
            <input type="text" name="vet_phone" placeholder="Phone Number" required>
            <button type="submit" class="btn">Simpan</button>
        </form>
    </div>
</div>
</body>
</html>
