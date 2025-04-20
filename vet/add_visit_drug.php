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

// Ambil data untuk dropdown menu (hewan, dokter, dan obat)
$animals_query = mysqli_query($conn, "SELECT animal_id, animal_name FROM animal");
$vets_query = mysqli_query($conn, "SELECT vet_id, vet_givenname, vet_familyname FROM vet");
$drugs_query = mysqli_query($conn, "SELECT drug_id, drug_name FROM drug");

// Proses form submission untuk menambahkan data kunjungan obat
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan sanitasi
    $visit_id = intval($_POST['visit_id']);  // ID kunjungan
    $drug_id = intval($_POST['drug_id']);    // ID obat
    $visit_drug_dose = mysqli_real_escape_string($conn, $_POST['visit_drug_dose']); // Dosis obat
    $visit_drug_frequency = mysqli_real_escape_string($conn, $_POST['visit_drug_frequency']); // Frekuensi obat
    $visit_drug_qtysupplied = mysqli_real_escape_string($conn, $_POST['visit_drug_qtysupplied']); // Jumlah obat yang diberikan

    // Query untuk menambahkan data kunjungan obat baru
    $insert_query = "INSERT INTO visit_drug (visit_id, drug_id, visit_drug_dose, visit_drug_frequency, visit_drug_qtysupplied) 
                     VALUES ('$visit_id', '$drug_id', '$visit_drug_dose', '$visit_drug_frequency', '$visit_drug_qtysupplied')";

    // Eksekusi query
    if (mysqli_query($conn, $insert_query)) {
        header("Location: kunjungan_obat_vet.php");  // Redirect ke halaman daftar kunjungan obat setelah berhasil tambah
        exit;
    } else {
        echo "Error adding visit drug: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Visit Drug - Klinik Sahabat Satwa</title>
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
    <h1>Add Visit Drug</h1>
</header>

<div class="container">
    <a href="kunjungan_obat.php">
        <button class="btn-back">&#8592; Kembali ke Daftar Kunjungan Obat</button>
    </a>

    <h2>Formulir Tambah Kunjungan Obat</h2>
    <form method="POST">
        <!-- Dropdown untuk memilih Visit ID -->
        <select name="visit_id" required>
            <option value="">-- Pilih Visit ID --</option>
            <?php
            // Menampilkan daftar Visit ID untuk dropdown
            $visits_query = mysqli_query($conn, "SELECT visit_id, visit_date_time FROM visit");
            while ($visit = mysqli_fetch_assoc($visits_query)) {
                echo "<option value=\"{$visit['visit_id']}\">{$visit['visit_id']} - {$visit['visit_date_time']}</option>";
            }
            ?>
        </select>

        <!-- Dropdown untuk memilih ID Obat -->
        <select name="drug_id" required>
            <option value="">-- Pilih Obat (ID) --</option>
            <?php
            // Menampilkan daftar ID obat untuk dropdown
            while ($drug = mysqli_fetch_assoc($drugs_query)) {
                echo "<option value=\"{$drug['drug_id']}\">{$drug['drug_id']} - {$drug['drug_name']}</option>";
            }
            ?>
        </select>

        <!-- Input untuk dosis obat -->
        <input type="text" name="visit_drug_dose" placeholder="Dosis Obat" required>

        <!-- Input untuk frekuensi obat -->
        <input type="text" name="visit_drug_frequency" placeholder="Frekuensi Obat" required>

        <!-- Input untuk jumlah obat yang diberikan -->
        <input type="number" name="visit_drug_qtysupplied" placeholder="Jumlah Obat Diberikan" required>

        <button type="submit" class="btn">Tambah Visit Drug</button>
    </form>
</div>

<footer>
    <p>© 2025 Klinik Sahabat Satwa | All rights reserved.</p>
</footer>

</body>
</html>