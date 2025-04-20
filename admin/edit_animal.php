<?php
session_start();

// Koneksi ke database
include('../db_connect.php');  // Pastikan path-nya sesuai dengan folder struktur Anda

// Cek jika pengguna bukan admin, arahkan kembali ke login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    $_SESSION['error_message'] = "Oops, kamu salah masuk!";
    header("Location: login.php");
    exit;
}

// Jika ID hewan tidak ada di URL, arahkan ke halaman manage_animals.php
if (!isset($_GET['id'])) {
    header("Location: manage_animals.php");
    exit;
}

// Ambil ID hewan dari URL
$animal_id = $_GET['id'];

// Query untuk mendapatkan data hewan berdasarkan ID
$query = "SELECT * FROM animal WHERE animal_id = '$animal_id'";
$result = mysqli_query($conn, $query);

// Jika tidak ada data yang ditemukan, arahkan ke halaman manage_animals.php
if (mysqli_num_rows($result) == 0) {
    header("Location: manage_animals.php");
    exit;
}

$animal = mysqli_fetch_assoc($result);

// Proses form submission untuk mengupdate data hewan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $animal_name = mysqli_real_escape_string($conn, $_POST['animal_name']);
    $animal_born = mysqli_real_escape_string($conn, $_POST['animal_born']);
    $owner_id = mysqli_real_escape_string($conn, $_POST['owner_id']);
    $at_id = mysqli_real_escape_string($conn, $_POST['at_id']);

    // Query untuk mengupdate data hewan
    $update_query = "UPDATE animal 
                     SET animal_name = '$animal_name', animal_born = '$animal_born', owner_id = '$owner_id', at_id = '$at_id' 
                     WHERE animal_id = '$animal_id'";

    // Eksekusi query
    if (mysqli_query($conn, $update_query)) {
        header("Location: manage_animals.php");  // Redirect ke halaman manage animals
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
    <title>Edit Animal</title>
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

        /* For mobile responsiveness */
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
        <h2>Edit Animal Details</h2>

        <!-- Form untuk mengedit data hewan -->
        <form action="edit_animal.php?id=<?php echo $animal['animal_id']; ?>" method="POST">
            <input type="text" name="animal_name" value="<?php echo $animal['animal_name']; ?>" placeholder="Animal Name" required>
            <input type="date" name="animal_born" value="<?php echo $animal['animal_born']; ?>" placeholder="Date of Birth" required>
            <input type="number" name="owner_id" value="<?php echo $animal['owner_id']; ?>" placeholder="Owner ID" required>
            <input type="number" name="at_id" value="<?php echo $animal['at_id']; ?>" placeholder="Treatment/Clinic ID" required>
            <button type="submit" class="btn">Update Animal</button>
        </form>
    </div>
</div>

</body>
</html>