<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    $_SESSION['error_message'] = "Oops, kamu salah masuk!";
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $drug_name = mysqli_real_escape_string($conn, $_POST['drug_name']);
    $drug_usage = mysqli_real_escape_string($conn, $_POST['drug_usage']);

    $query = "INSERT INTO drug (drug_name, drug_usage) VALUES ('$drug_name', '$drug_usage')";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_drug.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Obat</title>
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
            font-size: 30px;
        }

        input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
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

        .btn-back {
            background-color: #e74c3c;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn-back:hover {
            background-color: #c0392b;
        }

        @media (max-width: 768px) {
            .form-container {
                width: 90%;
                padding: 30px;
            }

            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Tambah Obat</h2>

        <form action="add_drug.php" method="POST">
            <input type="text" name="drug_name" placeholder="Nama Obat" required>
            <input type="text" name="drug_usage" placeholder="Kegunaan Obat" required>
            <button type="submit" class="btn">Simpan Obat</button>
        </form>

        <a href="manage_drug.php"><button class="btn-back">Kembali</button></a>
    </div>
</div>

</body>
</html>
