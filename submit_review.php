<?php
require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $peran = $_POST['peran'];
    $review = $_POST['review'];

    try {
        $stmt = $conn->prepare("INSERT INTO reviews (nama, email, peran, review, status) 
                               VALUES (:nama, :email, :peran, :review, 'pending')");

        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':peran', $peran);
        $stmt->bindParam(':review', $review);

        $stmt->execute();

        // Redirect kembali dengan pesan sukses
        header("Location: index.php?review=success#review-section");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>