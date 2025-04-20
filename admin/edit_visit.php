<?php
session_start();
include('../db_connect.php');

// Cek role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Validasi visit_id
if (!isset($_GET['id'])) {
    header("Location: manage_visit.php");
    exit;
}

$visit_id = intval($_GET['id']);
$visit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM visit WHERE visit_id = $visit_id"));

// Ambil data hewan dan dokter (field name diperbaiki sesuai database)
$animals = mysqli_query($conn, "SELECT animal_id, animal_name FROM animal");
$vets = mysqli_query($conn, "SELECT vet_id, vet_givenname, vet_familyname FROM vet");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $visit_date_time = mysqli_real_escape_string($conn, $_POST['visit_date_time']);
    $visit_notes = mysqli_real_escape_string($conn, $_POST['visit_notes']);
    $animal_id = intval($_POST['animal_id']);
    $vet_id = intval($_POST['vet_id']);
    $from_visit_id = !empty($_POST['from_visit_id']) ? intval($_POST['from_visit_id']) : "NULL";

    $query = "
        UPDATE visit SET 
            visit_date_time = '$visit_date_time', 
            visit_notes = '$visit_notes', 
            animal_id = $animal_id, 
            vet_id = $vet_id, 
            from_visit_id = $from_visit_id 
        WHERE visit_id = $visit_id
    ";

    if (mysqli_query($conn, $query)) {
        header("Location: manage_visit.php");
        exit;
    } else {
        echo "Error updating visit: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Visit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFFAF0;
            margin: 0;
            padding: 0;
        }

        header, footer {
            background-color: #2980B9;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .container {
            padding: 40px;
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #2980B9;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        input, select, button {
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #2980B9;
        }

        .btn {
            background-color: #2980B9;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #3498DB;
        }

        .btn-back {
            background-color: transparent;
            color: #2980B9;
            border: none;
            font-size: 24px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .btn-back:hover {
            color: #3498DB;
        }
    </style>
</head>
<body>

<header>
    <h1>Edit Visit</h1>
</header>

<div class="container">
    <a href="manage_visit.php">
        <button class="btn-back">&#8592; Kembali</button>
    </a>
    <h2>Formulir Edit Visit</h2>
    <form method="POST">
        <input type="datetime-local" name="visit_date_time" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($visit['visit_date_time']))) ?>" required>
        <input type="text" name="visit_notes" value="<?= htmlspecialchars($visit['visit_notes']) ?>" required>

        <select name="animal_id" required>
            <option value="">-- Pilih Hewan --</option>
            <?php while($a = mysqli_fetch_assoc($animals)): ?>
                <option value="<?= $a['animal_id'] ?>" <?= $a['animal_id'] == $visit['animal_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($a['animal_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <select name="vet_id" required>
            <option value="">-- Pilih Dokter Hewan --</option>
            <?php while($v = mysqli_fetch_assoc($vets)): ?>
                <option value="<?= $v['vet_id'] ?>" <?= $v['vet_id'] == $visit['vet_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($v['vet_givenname'] . ' ' . $v['vet_familyname']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="number" name="from_visit_id" value="<?= htmlspecialchars($visit['from_visit_id']) ?>" placeholder="Dari Visit ID (opsional)">
        <button type="submit" class="btn">Update</button>
    </form>
</div>

<footer>
    <p>© 2025 Klinik Sahabat Satwa | All rights reserved.</p>
</footer>

</body>
</html>
