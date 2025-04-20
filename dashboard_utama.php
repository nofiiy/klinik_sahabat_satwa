<?php
session_start();

// Koneksi ke database
include('db_connect.php'); // Perbaikan path ke db_connect.php

// Cek apakah pengguna sudah login
if (!isset($_SESSION['role'])) {
    header("Location: login.php"); // Jika belum login, redirect ke halaman login
    exit;
}

// Role yang login
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Klinik Sahabat Satwa</title>
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
            text-align: center;
        }

        h2 {
            color: #2980B9;
            margin-bottom: 20px;
            font-size: 30px;
        }

        .dashboard-card {
            background-color: white;
            padding: 30px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            margin: 0 auto;
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
            font-size: 16px;
            position: absolute;
            top: 20px;
            left: 20px;
            /* Positioning the button at the top-left corner */
        }

        .btn-back:hover {
            background-color: #c0392b;
        }

        /* For mobile responsiveness */
        @media (max-width: 768px) {
            h2 {
                font-size: 24px;
            }
            .dashboard-card {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<!-- Header -->
<header>
    <h1>Dashboard</h1>
</header>

<!-- Main Content -->
<div class="container">
    <h2>Welcome to the Dashboard</h2>
    
    <?php
    // Tampilkan konten berdasarkan role pengguna
    if ($role == 'admin') {
        // Konten untuk Admin
        echo '<div class="dashboard-card">
                <h3>Admin Role: Full Access</h3>
                <p>As an Admin, you have full control over the clinic\'s data and can manage users, appointments, and more.</p>
                <button class="btn" onclick="window.location.href=\'admin/manage_animals.php\'">Manage Animals</button>
                <button class="btn" onclick="window.location.href=\'admin/manage_klinik.php\'">Klinik</button>
                <button class="btn" onclick="window.location.href=\'admin/manage_drug.php\'">Obat</button>
                <button class="btn" onclick="window.location.href=\'admin/manage_owner.php\'">Owners</button>
                <button class="btn" onclick="window.location.href=\'admin/spec_visit.php\'">Specialisation Visit</button>
                <button class="btn" onclick="window.location.href=\'admin/manage_specialisation.php\'">Specialisation</button>
                <button class="btn" onclick="window.location.href=\'admin/manage_vet.php\'">Dokter</button>
                <button class="btn" onclick="window.location.href=\'admin/manage_visit_drug.php\'">Visit Obat</button>
                <button class="btn" onclick="window.location.href=\'admin/manage_visit.php\'">Kunjungan</button>
                <button class="btn" onclick="window.location.href=\'admin/manage_animal_type.php\'">Jenis Hewan</button>
              </div>';
    } elseif ($role == 'vet') {
        // Konten untuk Veterinarian
        echo '<div class="dashboard-card">
                <h3>Vet Role</h3>
                <p>As a Vet, you can manage animal check-ups and related medical records.</p>
                <button class="btn" onclick="window.location.href=\'vet/vet_list.php\'">Daftar Dokter</button>
                <button class="btn" onclick="window.location.href=\'vet/owners_pet.php\'">Pemilik Hewan</button>
                <button class="btn" onclick="window.location.href=\'vet/animal_type_vet.php\'">Jenis Hewan</button>
                <button class="btn" onclick="window.location.href=\'vet/hewan_vet.php\'">Kelola Hewan</button>
                <button class="btn" onclick="window.location.href=\'vet/kunjungan_vet.php\'">Kunjungan</button>
                <button class="btn" onclick="window.location.href=\'vet/kunjungan_obat_vet.php\'">Kunjungan Obat</button>
              </div>';
    } elseif ($role == 'owner') {
        // Konten untuk Owner
        echo '<div class="dashboard-card">
                <h3>Owner Role</h3>
                <p>As an Owner, you can view and manage your pet\'s records.</p>
                <button class="btn" onclick="window.location.href=\'owner/animal_owner.php\'">View My Pets</button>
                <button class="btn" onclick="window.location.href=\'owner/visit_owner.php\'">View Appointments</button>
              </div>';
    }
    ?>

    <!-- Tombol Kembali -->
    <a href="indexutama.php">
        <button class="btn-back">← Kembali ke Halaman Utama</button>
    </a>
</div>

<!-- Footer -->
<footer>
    <p>© 2025 Klinik Sahabat Satwa | All rights reserved.</p>
</footer>

</body>
</html>
