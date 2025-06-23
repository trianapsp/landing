<?php
session_start();
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: data_pendaftar.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk Admin - Touch Education</title>
  <link rel="stylesheet" href="../style/style-2.css">
</head>
<body>
  <div class="login-wrapper">
    <div class="left-panel">
      <img src="../assets/img/img-login.png" alt="Ilustrasi Admin">
    </div>
    <div class="right-panel">
      <img src="../assets/img/logo.png" alt="Logo Touch Education" class="logo">
      <h2>MASUK ADMIN</h2>
      <p>BIMBEL TOUCH EDUCATION</p>
      <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
      <form method="POST">
        <label for="username">Nama Pengguna</label>
        <input type="text" name="username" id="username" placeholder="Masukan Nama Pengguna" required>

        <label for="password">Kata Sandi</label>
        <div class="password-field">
          <input type="password" name="password" id="password" placeholder="Masukan Kata Sandi" required>
          <span class="toggle-password" onclick="togglePassword()">👁️</span>
        </div>

        <button type="submit">Masuk</button>
      </form>
      <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
  </div>

  <script>
    function togglePassword() {
      const password = document.getElementById("password");
      password.type = password.type === "password" ? "text" : "password";
    }
  </script>
</body>
</html>
