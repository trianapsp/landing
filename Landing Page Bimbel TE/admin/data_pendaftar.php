<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$stmt = $conn->query("SELECT * FROM pendaftaran");
$pendaftar = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Data Pendaftar</title>
  <link rel="stylesheet" href="../style/style-4.css">
</head>
<body>
<div class="sidebar">
  <div class="logo-wrapper">
    <img src="../assets/img/logo-2.png" class="logo" />
  </div>
  <ul class="menu">
    <li><a href="data_pendaftar.php" class="active">Data Pendaftar</a></li>
    <li><a href="review.php">Review</a></li>
    <li><a href="logout.php">Keluar</a></li>
  </ul>
</div>

<div class="main-content">
  <div class="table-container">
    <h2>Data Siswa Kelas 9A</h2>
    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama Lengkap</th>
          <th>Kelas</th>
          <th>Asal Sekolah</th>
          <th>No WhatsApp</th>
          <th>Instagram</th>
          <th>Nama Orang Tua</th>
          <th>No WhatsApp Orang Tua</th>
          <th>Alamat</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($pendaftar) > 0): ?>
          <?php $no = 1; foreach ($pendaftar as $row): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= htmlspecialchars($row['kelas']) ?></td>
              <td><?= htmlspecialchars($row['asal_sekolah']) ?></td>
              <td><?= htmlspecialchars($row['whatsapp']) ?></td>
              <td><?= htmlspecialchars($row['instagram']) ?></td>
              <td><?= htmlspecialchars($row['nama_ortu']) ?></td>
              <td><?= htmlspecialchars($row['wa_ortu']) ?></td>
              <td><?= htmlspecialchars($row['alamat']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="9">Belum ada data pendaftar.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
