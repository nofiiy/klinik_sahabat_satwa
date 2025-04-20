<?php
// Create a connection to the database
$conn = mysqli_connect("localhost", "root", "", "klinik_sahabat_satwa_fix", 3307);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
