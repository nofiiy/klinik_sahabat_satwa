<?php
session_start();

// Koneksi ke database
include('../db_connect.php');

// Cek jika pengguna bukan admin, arahkan ke login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    $_SESSION['error_message'] = "Oops, kamu salah masuk!";
    header("Location: login.php");
    exit;
}

// Jika ID klinik tidak ada di URL, arahkan ke halaman manage_klinik.php
if (!isset($_GET['id'])) {
    header("Location: manage_klinik.php");
    exit;
}

// Ambil ID klinik dari URL
$clinic_id = $_GET['id'];

// Ambil data klinik berdasarkan ID
$query = "SELECT * FROM clinic WHERE clinic_id = '$clinic_id'";
$result = mysqli_query($conn, $query);

// Jika data tidak ditemukan, arahkan ke halaman manage_klinik.php
if (mysqli_num_rows($result) == 0) {
    header("Location: manage_klinik.php");
    exit;
}

$clinic = mysqli_fetch_assoc($result);

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clinic_name = mysqli_real_escape_string($conn, $_POST['clinic_name']);
    $clinic_address = mysqli_real_escape_string($conn, $_POST['clinic_address']);
    $clinic_phone = mysqli_real_escape_string($conn, $_POST['clinic_phone']);

    $update_query = "UPDATE clinic 
                     SET clinic_name = '$clinic_name', 
                         clinic_address = '$clinic_address', 
                         clinic_phone = '$clinic_phone' 
                     WHERE clinic_id = '$clinic_id'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: manage_klinik.php");
        exit;
    } else {
        echo "Error updating clinic: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Klinik</title>
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
        <h2>Edit Klinik</h2>

        <form action="edit_klinik.php?id=<?php echo $clinic['clinic_id']; ?>" method="POST">
            <input type="text" name="clinic_name" value="<?php echo $clinic['clinic_name']; ?>" placeholder="Clinic Name" required>
            <input type="text" name="clinic_address" value="<?php echo $clinic['clinic_address']; ?>" placeholder="Clinic Address" required>
            <input type="text" name="clinic_phone" value="<?php echo $clinic['clinic_phone']; ?>" placeholder="Clinic Phone" required>
            <button type="submit" class="btn">Update Klinik</button>
        </form>

        <a href="manage_klinik.php">
            <button class="btn-back">Kembali</button>
        </a>
    </div>
</div>

</body>
</html>
