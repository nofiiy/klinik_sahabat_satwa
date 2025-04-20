<?php
// Koneksi ke database
include('db_connect.php'); // Pastikan file koneksi sudah benar

// Data pengguna yang ingin ditambahkan
$admin_username = 'admin_user';
$admin_password = 'admin123';
$vet_username = 'vet_user';
$vet_password = 'vet123';
$owner_username = 'owner_user';
$owner_password = 'owner123';

// Membuat password hash menggunakan password_hash
$admin_hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
$vet_hashed_password = password_hash($vet_password, PASSWORD_DEFAULT);
$owner_hashed_password = password_hash($owner_password, PASSWORD_DEFAULT);

// Menyimpan data pengguna ke database
$query_admin = "INSERT INTO users (username, password, role) VALUES ('$admin_username', '$admin_hashed_password', 'admin')";
$query_vet = "INSERT INTO users (username, password, role) VALUES ('$vet_username', '$vet_hashed_password', 'vet')";
$query_owner = "INSERT INTO users (username, password, role) VALUES ('$owner_username', '$owner_hashed_password', 'owner')";

// Eksekusi query untuk setiap pengguna
if (mysqli_query($conn, $query_admin)) {
    echo "Admin user added successfully.<br>";
} else {
    echo "Error adding admin user: " . mysqli_error($conn) . "<br>";
}

if (mysqli_query($conn, $query_vet)) {
    echo "Vet user added successfully.<br>";
} else {
    echo "Error adding vet user: " . mysqli_error($conn) . "<br>";
}

if (mysqli_query($conn, $query_owner)) {
    echo "Owner user added successfully.<br>";
} else {
    echo "Error adding owner user: " . mysqli_error($conn) . "<br>";
}

// Menutup koneksi database
mysqli_close($conn);
?>
