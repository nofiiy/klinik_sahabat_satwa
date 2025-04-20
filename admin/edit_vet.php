<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: manage_vet.php");
    exit;
}

$vet_id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM vet WHERE vet_id = '$vet_id'");
if (mysqli_num_rows($result) == 0) {
    header("Location: manage_vet.php");
    exit;
}
$vet = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vet_title = mysqli_real_escape_string($conn, $_POST['vet_title']);
    $vet_givenname = mysqli_real_escape_string($conn, $_POST['vet_givenname']);
    $vet_familyname = mysqli_real_escape_string($conn, $_POST['vet_familyname']);
    $vet_phone = mysqli_real_escape_string($conn, $_POST['vet_phone']);

    $query = "UPDATE vet SET vet_title = '$vet_title', vet_givenname = '$vet_givenname', vet_familyname = '$vet_familyname', vet_phone = '$vet_phone' WHERE vet_id = '$vet_id'";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_vet.php");
        exit;
    } else {
        echo "Error updating vet: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Vet</title>
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
        <h2>Edit Vet</h2>
        <form method="POST">
            <input type="text" name="vet_title" value="<?= $vet['vet_title'] ?>" required>
            <input type="text" name="vet_givenname" value="<?= $vet['vet_givenname'] ?>" required>
            <input type="text" name="vet_familyname" value="<?= $vet['vet_familyname'] ?>" required>
            <input type="text" name="vet_phone" value="<?= $vet['vet_phone'] ?>" required>
            <button type="submit" class="btn">Update</button>
        </form>
    </div>
</div>
</body>
</html>
