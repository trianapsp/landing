<?php
require_once 'config/database.php';
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $asal_sekolah = $_POST['asal_sekolah'];
    $whatsapp = $_POST['whatsapp'];
    $instagram = $_POST['instagram'];
    $nama_ortu = $_POST['nama_ortu'];
    $wa_ortu = $_POST['wa_ortu'];
    $alamat = $_POST['alamat'];

    try {
        $stmt = $conn->prepare("INSERT INTO pendaftaran (nama, kelas, asal_sekolah, whatsapp, instagram, nama_ortu, wa_ortu, alamat)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nama, $kelas, $asal_sekolah, $whatsapp, $instagram, $nama_ortu, $wa_ortu, $alamat]);
        echo "sukses";
    } catch (Exception $e) {
        echo "gagal";
    }
}
?>