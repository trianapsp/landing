<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Ambil review yang perlu disetujui
$stmt = $conn->query("SELECT * FROM reviews WHERE status = 'pending' ORDER BY tanggal DESC");
$pending_reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil review yang sudah disetujui
$stmt = $conn->query("SELECT * FROM reviews WHERE status = 'approved' ORDER BY tanggal DESC");
$approved_reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Proses aksi (approve/reject)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'approve') {
        $stmt = $conn->prepare("UPDATE reviews SET status = 'approved' WHERE id = :id");
    } elseif ($action == 'reject') {
        $stmt = $conn->prepare("UPDATE reviews SET status = 'rejected' WHERE id = :id");
    } elseif ($action == 'delete') {
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = :id");
    }

    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: review.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Review - Admin</title>
    <link rel="stylesheet" href="../style/style-3.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
</head>

<body class="main-wrapper">
    <div class="sidebar">
        <div class="logo-wrapper">
            <img src="../assets/img/logo-2.png" alt="Logo Touch Education" class="logo">
        </div>  
        <ul class="menu">
            <li><a href="data_pendaftar.php">Data Pendaftar</a></li>
            <li><a href="dashboard.php" class="active">Review</a></li>
            <li><a href="logout.php" class="logout">Keluar</a></li>
        </ul>
    </div>

    <div class="container-review">
        <div class="card-review">
        <h2>Data Review</h2>
        <table class="table-review">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Peran</th>
                    <th>Review</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($pending_reviews) === 0): ?>
                    <tr><td colspan="6">Tidak ada review menunggu.</td></tr>
                <?php endif; ?>
                <?php $no = 1; foreach ($pending_reviews as $review): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($review['nama']) ?></td>
                    <td><?= htmlspecialchars($review['email']) ?></td>
                    <td><?= htmlspecialchars($review['peran']) ?></td>
                    <td><?= htmlspecialchars($review['review']) ?></td>
                    <td class="action-buttons">
                        <a href="review.php?action=reject&id=<?php echo $review['id']; ?>" class="btn-circle btn-reject">✖</a>
                        <a href="review.php?action=approve&id=<?php echo $review['id']; ?>" class="btn-circle btn-approve">✔</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
