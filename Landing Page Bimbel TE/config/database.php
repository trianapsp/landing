<?php
$host = 'localhost';
$port = '3306';
$dbname = 'toucheducation';
$username = 'root';
$password = ''; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>