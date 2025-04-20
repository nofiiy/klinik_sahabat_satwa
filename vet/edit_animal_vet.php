<?php
session_start();

// Koneksi ke database
include('../db_connect.php');  // Pastikan path-nya sesuai dengan folder struktur Anda

// Cek apakah pengguna sudah login dan memiliki role 'vet'
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'vet') {
    header("Location: login.php");
    exit;
}

// Validasi animal_id
if (!isset($_GET['id'])) {
    header("Location: hewan_vet.php");  // Jika ID hewan tidak ada di URL, arahkan ke halaman daftar hewan
    exit;
}

// Ambil ID animal dari URL
$animal_id = $_GET['id'];

// Query untuk mendapatkan data hewan berdasarkan ID
$query = "SELECT * FROM animal WHERE animal_id = '$animal_id'";
$result = mysqli_query($conn, $query);

// Jika tidak ada data yang ditemukan, arahkan ke halaman daftar hewan
if (mysqli_num_rows($result) == 0) {
    header("Location: hewan_vet.php");
    exit;
}

$animal = mysqli_fetch_assoc($result);

// Ambil daftar pemilik untuk dipilih di form
$owners = mysqli_query($conn, "SELECT owner_id FROM owners");

// Proses form submission untuk mengupdate data hewan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan sanitasi
    $animal_name = mysqli_real_escape_string($conn, $_POST['animal_name']);
    $animal_born = mysqli_real_escape_string($conn, $_POST['animal_born']);
    $owner_id = mysqli_real_escape_string($conn, $_POST['owner_id']);

    // Query untuk mengupdate data hewan
    $update_query = "UPDATE animal 
                     SET animal_name = '$animal_name', animal_born = '$animal_born', owner_id = '$owner_id' 
                     WHERE animal_id = '$animal_id'";

    // Eksekusi query
    if (mysqli_query($conn, $update_query)) {
        header("Location: hewan_vet.php");  // Redirect ke halaman daftar hewan setelah berhasil update
        exit;
    } else {
        echo "Error updating animal: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Animal - Klinik Sahabat Satwa</title>
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

        .form-container {
            background-color: white;
            padding: 40px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            margin: 0 auto;
        }

        input, select {
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

        /* Tombol Kembali dengan panah kiri */
        .btn-back-arrow {
            background-color: transparent;
            border: none;
            color: #2980B9;
            font-size: 24px;
            cursor: pointer;
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px;
        }

        .btn-back-arrow:hover {
            color: #3498DB;
        }
    </style>
</head>
<body>

<!-- Tombol Kembali dengan ikon panah kiri -->
<a href="hewan_vet.php">
    <button class="btn-back-arrow">&#8592; Kembali ke Daftar Hewan</button>
</a>

<header>
    <h1>Edit Animal</h1>
</header>

<div class="container">
    <h2>Edit Data Hewan</h2>

    <!-- Form untuk mengedit data hewan -->
    <form action="edit_animal_vet.php?id=<?php echo $animal['animal_id']; ?>" method="POST">
        <!-- ID Hewan -->
        <input type="text" name="animal_id" value="<?php echo $animal['animal_id']; ?>" readonly placeholder="ID Hewan" required>

        <!-- Nama Hewan -->
        <input type="text" name="animal_name" value="<?php echo $animal['animal_name']; ?>" placeholder="Nama Hewan" required>

        <!-- Tanggal Lahir Hewan -->
        <input type="date" name="animal_born" value="<?php echo $animal['animal_born']; ?>" placeholder="Tanggal Lahir" required>
        
        <!-- Dropdown untuk memilih Owner -->
        <select name="owner_id" required>
            <option value="">Pilih Pemilik</option>
            <?php while($owner = mysqli_fetch_assoc($owners)): ?>
                <option value="<?php echo $owner['owner_id']; ?>" 
                    <?php echo $owner['owner_id'] == $animal['owner_id'] ? 'selected' : ''; ?> >
                    <?php echo $owner['owner_id']; ?> <!-- Menampilkan Owner ID -->
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit" class="btn">Update Animal</button>
    </form>
</div>

<footer>
    <p>© 2025 Klinik Sahabat Satwa | All rights reserved.</p>
</footer>

</body>
</html>