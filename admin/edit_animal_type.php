<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: manage_animal_type.php");
    exit;
}

$at_id = intval($_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM animal_type WHERE at_id = $at_id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = mysqli_real_escape_string($conn, $_POST['at_description']);

    $query = "UPDATE animal_type SET at_description = '$description' WHERE at_id = $at_id";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_animal_type.php");
        exit;
    } else {
        echo "Error updating data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tipe Hewan</title>
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
        <h2>Edit Tipe Hewan</h2>
        <form method="POST">
            <input type="text" name="at_description" value="<?= htmlspecialchars($data['at_description']) ?>" required>
            <button type="submit" class="btn">Update</button>
        </form>
    </div>
</div>
</body>
</html>
