<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $visit_id = mysqli_real_escape_string($conn, $_POST['visit_id']);
    $drug_id = mysqli_real_escape_string($conn, $_POST['drug_id']);
    $visit_drug_dose = mysqli_real_escape_string($conn, $_POST['visit_drug_dose']);
    $visit_drug_frequency = mysqli_real_escape_string($conn, $_POST['visit_drug_frequency']);
    $visit_drug_qtysupplied = mysqli_real_escape_string($conn, $_POST['visit_drug_qtysupplied']);

    $query = "INSERT INTO visit_drug (visit_id, drug_id, visit_drug_dose, visit_drug_frequency, visit_drug_qtysupplied) 
              VALUES ('$visit_id', '$drug_id', '$visit_drug_dose', '$visit_drug_frequency', '$visit_drug_qtysupplied')";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_visit_drug.php");
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
    <title>Tambah Visit Drug</title>
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

        input, select {
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
        <h2>Tambah Visit Drug</h2>
        <form method="POST">
            <input type="text" name="visit_id" placeholder="Visit ID" required>
            <input type="text" name="drug_id" placeholder="Drug ID" required>
            <input type="text" name="visit_drug_dose" placeholder="Drug Dose" required>
            <input type="text" name="visit_drug_frequency" placeholder="Drug Frequency" required>
            <input type="number" name="visit_drug_qtysupplied" placeholder="Quantity Supplied" required>
            <button type="submit" class="btn">Simpan</button>
        </form>
    </div>
</div>
</body>
</html>
