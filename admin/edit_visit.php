<?php
session_start();
include('../db_connect.php');

// Ensure user is an admin before accessing this page
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Ensure visit_id is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: manage_visit.php"); // If no visit_id, redirect back
    exit;
}

// Get the visit_id from the URL
$visit_id = $_GET['id'];

// Fetch the visit data based on visit_id
$query = "
    SELECT v.*, a.animal_name AS animal_name, CONCAT(d.vet_givenname, ' ', d.vet_familyname) AS vet_name
    FROM visit v
    LEFT JOIN animal a ON v.animal_id = a.animal_id
    LEFT JOIN vet d ON v.vet_id = d.vet_id
    WHERE v.visit_id = '$visit_id'
";
$result = mysqli_query($conn, $query);

// If the query fails or no visit is found, redirect to manage visit
if (!$result || mysqli_num_rows($result) == 0) {
    header("Location: manage_visit.php");
    exit;
}

$visit = mysqli_fetch_assoc($result);

// Process the form submission for updating the visit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $visit_date_time = mysqli_real_escape_string($conn, $_POST['visit_date_time']);
    $visit_notes = mysqli_real_escape_string($conn, $_POST['visit_notes']);
    $animal_id = intval($_POST['animal_id']);
    $vet_id = intval($_POST['vet_id']);
    $from_visit_id = !empty($_POST['from_visit_id']) ? intval($_POST['from_visit_id']) : "NULL";

    // Update the visit record in the database
    $update_query = "
        UPDATE visit 
        SET visit_date_time = '$visit_date_time', visit_notes = '$visit_notes', 
            animal_id = '$animal_id', vet_id = '$vet_id', from_visit_id = $from_visit_id
        WHERE visit_id = '$visit_id'
    ";

    if (mysqli_query($conn, $update_query)) {
        // Redirect back to manage visit page on success
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <button class="btn-back">&#8592; Kembali ke Daftar Kunjungan</button>
    </a>

    <h2>Edit Data Kunjungan</h2>
    <form method="POST">
        <input type="datetime-local" name="visit_date_time" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($visit['visit_date_time']))) ?>" required>
        <input type="text" name="visit_notes" value="<?= htmlspecialchars($visit['visit_notes']) ?>" placeholder="Catatan Visit" required>

        <!-- Dropdown untuk memilih ID Hewan -->
        <select name="animal_id" required>
            <option value="">-- Pilih Hewan --</option>
            <?php
            // Menampilkan daftar ID hewan untuk dropdown
            $animals_query = mysqli_query($conn, "SELECT animal_id, animal_name FROM animal");
            while ($animal = mysqli_fetch_assoc($animals_query)) {
                echo "<option value=\"{$animal['animal_id']}\" " . ($animal['animal_id'] == $visit['animal_id'] ? 'selected' : '') . ">{$animal['animal_name']}</option>";
            }
            ?>
        </select>

        <!-- Dropdown untuk memilih ID Dokter -->
        <select name="vet_id" required>
            <option value="">-- Pilih Dokter Hewan --</option>
            <?php
            // Menampilkan daftar ID dokter untuk dropdown
            $vets_query = mysqli_query($conn, "SELECT vet_id, vet_givenname, vet_familyname FROM vet");
            while ($vet = mysqli_fetch_assoc($vets_query)) {
                echo "<option value=\"{$vet['vet_id']}\" " . ($vet['vet_id'] == $visit['vet_id'] ? 'selected' : '') . ">{$vet['vet_givenname']} {$vet['vet_familyname']}</option>";
            }
            ?>
        </select>

        <input type="number" name="from_visit_id" value="<?= htmlspecialchars($visit['from_visit_id']) ?>" placeholder="Dari Visit ID (opsional)">
        <button type="submit" class="btn">Update Visit</button>
    </form>
</div>

<footer>
    <p>© 2025 Klinik Sahabat Satwa | All rights reserved.</p>
</footer>

</body>
</html>
