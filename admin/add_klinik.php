<?php 
session_start();

// Koneksi ke database
include('../db_connect.php');  // Pastikan path-nya benar

// Cek jika pengguna bukan admin, arahkan kembali ke login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    $_SESSION['error_message'] = "Oops, kamu salah masuk!";
    header("Location: login.php");
    exit;
}

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $clinic_name = mysqli_real_escape_string($conn, $_POST['clinic_name']);
    $clinic_address = mysqli_real_escape_string($conn, $_POST['clinic_address']);
    $clinic_phone = mysqli_real_escape_string($conn, $_POST['clinic_phone']);

    // Query untuk menyimpan data ke dalam tabel 'clinic'
    $query = "INSERT INTO clinic (clinic_name, clinic_address, clinic_phone) 
              VALUES ('$clinic_name', '$clinic_address', '$clinic_phone')";
    
    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        header("Location: manage_klinik.php");
        exit;
    } else {
        echo "Error adding clinic: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Klinik</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFFAF0;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 40px;
            text-align: center;
        }

        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            margin: 0 auto;
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
        <h2>Tambah Klinik</h2>
        
        <form action="add_klinik.php" method="POST">
            <input type="text" name="clinic_name" placeholder="Clinic Name" required>
            <input type="text" name="clinic_address" placeholder="Clinic Address" required>
            <input type="text" name="clinic_phone" placeholder="Clinic Phone" required>
            <button type="submit" class="btn">Tambah Klinik</button>
        </form>

        <!-- Tombol Kembali -->
        <a href="manage_klinik.php">
            <button class="btn-back">Kembali</button>
        </a>
    </div>
</div>

</body>
</html>
