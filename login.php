<?php include 'koneksi.php'; ?>
<?php
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
    if ($query->num_rows > 0) {
        $data = $query->fetch_assoc(); 
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $data['role'];

        header('Location: index.php');
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Billiard Herta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1e1e2f; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: 'Segoe UI', sans-serif; }
        .login-box { background-color: #2a2d3e; padding: 30px; border-radius: 10px; width: 100%; max-width: 400px; }
    </style>
</head>
<body>
<div class="login-box">
    <h3 class="mb-4 text-center">Login Admin/Kasir</h3>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
    </form>
</div>
</body>
</html>