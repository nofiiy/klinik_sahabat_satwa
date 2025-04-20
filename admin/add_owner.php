<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    $_SESSION['error_message'] = "Oops, kamu salah masuk!";
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $givenname = mysqli_real_escape_string($conn, $_POST['owner_givenname']);
    $familyname = mysqli_real_escape_string($conn, $_POST['owner_familyname']);
    $address = mysqli_real_escape_string($conn, $_POST['owner_address']);
    $phone = mysqli_real_escape_string($conn, $_POST['owner_phone']);

    $query = "INSERT INTO owners (owner_givenname, owner_familyname, owner_address, owner_phone)
              VALUES ('$givenname', '$familyname', '$address', '$phone')";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_owner.php");
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
    <title>Tambah Owner</title>
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
        <h2>Tambah Owner</h2>
        <form method="POST">
            <input type="text" name="owner_givenname" placeholder="Given Name" required>
            <input type="text" name="owner_familyname" placeholder="Family Name" required>
            <input type="text" name="owner_address" placeholder="Address" required>
            <input type="text" name="owner_phone" placeholder="Phone" required>
            <button type="submit" class="btn">Simpan</button>
        </form>
    </div>
</div>
</body>
</html>
