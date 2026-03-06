<?php
$host = '127.0.0.1';
$user = 'root';
$pass = ''; // Por defecto XAMPP/MariaDB local normalmente no tiene pass

$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully\n";

$sql = "CREATE DATABASE IF NOT EXISTS gestion_residuos";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}
$conn->close();
?>
