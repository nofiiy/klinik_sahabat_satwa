<?php
session_start();

// Koneksi ke database
include('../db_connect.php');  // Pastikan path-nya sesuai dengan folder struktur Anda

// Cek apakah pengguna sudah login dan memiliki role 'vet'
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'vet') {
    $_SESSION['error_message'] = "Oops, kamu salah masuk!"; // Simpan pesan error di session
    header("Location: login.php"); // Redirect ke login
    exit;
}

// Proses form submission untuk menambahkan data kunjungan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan sanitasi
    $visit_date_time = mysqli_real_escape_string($conn, $_POST['visit_date_time']);
    $visit_notes = mysqli_real_escape_string($conn, $_POST['visit_notes']);
    $animal_id = intval($_POST['animal_id']); // Pastikan ID Hewan adalah integer
    $vet_id = intval($_POST['vet_id']); // Pastikan ID Dokter adalah integer
    $from_visit_id = !empty($_POST['from_visit_id']) ? intval($_POST['from_visit_id']) : "NULL";

    // Pastikan nilai dari visit_date_time valid
    if (!$visit_date_time) {
        echo "Tanggal kunjungan tidak valid!";
        exit;
    }

    // Query untuk menambahkan data kunjungan baru
    $insert_query = "INSERT INTO visit (visit_date_time, visit_notes, animal_id, vet_id, from_visit_id) 
                     VALUES ('$visit_date_time', '$visit_notes', $animal_id, $vet_id, $from_visit_id)";

    // Eksekusi query
    if (mysqli_query($conn, $insert_query)) {
        header("Location: kunjungan_vet.php");  // Redirect ke halaman daftar kunjungan setelah berhasil tambah
        exit;
    } else {
        echo "Error adding visit: " . mysqli_error($conn);
    }
}

// Ambil data hewan dan dokter untuk dropdown
$animals_query = mysqli_query($conn, "SELECT animal_id, animal_name FROM animal");
$vets_query = mysqli_query($conn, "SELECT vet_id, vet_givenname, vet_familyname FROM vet");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Visit - Klinik Sahabat Satwa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFFAF0;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #2980B9;
            color: white;
            text-align: center;
            padding: 20px;
        }

        footer {
            background-color: #2980B9;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
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
    <h1>Add Visit</h1>
</header>

<div class="container">
    <a href="kunjungan_vet.php">
        <button class="btn-back">&#8592; Kembali ke Daftar Kunjungan</button>
    </a>

    <h2>Formulir Kunjungan Baru</h2>
    <form method="POST">
        <input type="datetime-local" name="visit_date_time" required>
        <input type="text" name="visit_notes" placeholder="Catatan Visit" required>

        <!-- Dropdown untuk memilih ID Hewan -->
        <select name="animal_id" required>
            <option value="">-- Pilih Hewan (ID) --</option>
            <?php
            // Menampilkan daftar ID hewan untuk dropdown
            while ($animal = mysqli_fetch_assoc($animals_query)) {
                echo "<option value=\"{$animal['animal_id']}\">{$animal['animal_id']} - {$animal['animal_name']}</option>";
            }
            ?>
        </select>

        <!-- Dropdown untuk memilih ID Dokter -->
        <select name="vet_id" required>
            <option value="">-- Pilih Dokter Hewan (ID) --</option>
            <?php
            // Menampilkan daftar ID dokter untuk dropdown
            while ($vet = mysqli_fetch_assoc($vets_query)) {
                echo "<option value=\"{$vet['vet_id']}\">{$vet['vet_id']} - {$vet['vet_givenname']} {$vet['vet_familyname']}</option>";
            }
            ?>
        </select>

        <input type="number" name="from_visit_id" placeholder="Dari Visit ID (opsional)">
        <button type="submit" class="btn">Tambah Visit</button>
    </form>
</div>

<footer>
    <p>© 2025 Klinik Sahabat Satwa | All rights reserved.</p>
</footer>

</body>
</html>