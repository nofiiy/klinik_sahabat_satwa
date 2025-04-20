<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    $_SESSION['error_message'] = "Oops, kamu salah masuk!";
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: manage_owner.php");
    exit;
}

$owner_id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM owners WHERE owner_id = '$owner_id'");
if (mysqli_num_rows($result) == 0) {
    header("Location: manage_owner.php");
    exit;
}
$owner = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $givenname = mysqli_real_escape_string($conn, $_POST['owner_givenname']);
    $familyname = mysqli_real_escape_string($conn, $_POST['owner_familyname']);
    $address = mysqli_real_escape_string($conn, $_POST['owner_address']);
    $phone = mysqli_real_escape_string($conn, $_POST['owner_phone']);

    $query = "UPDATE owners 
              SET owner_givenname = '$givenname', owner_familyname = '$familyname', 
                  owner_address = '$address', owner_phone = '$phone' 
              WHERE owner_id = '$owner_id'";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_owner.php");
        exit;
    } else {
        echo "Error updating owner: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Owner</title>
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
        <h2>Edit Owner</h2>
        <form method="POST">
            <input type="text" name="owner_givenname" value="<?= $owner['owner_givenname'] ?>" required>
            <input type="text" name="owner_familyname" value="<?= $owner['owner_familyname'] ?>" required>
            <input type="text" name="owner_address" value="<?= $owner['owner_address'] ?>" required>
            <input type="text" name="owner_phone" value="<?= $owner['owner_phone'] ?>" required>
            <button type="submit" class="btn">Update</button>
        </form>
    </div>
</div>
</body>
</html>
