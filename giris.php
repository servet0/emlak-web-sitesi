<?php
session_start();
include 'baglan.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_giris'] = true;
            header("Location: index.php");
            exit;
        } else {
            $error = "Hatalı şifre!";
        }
    } else {
        $error = "Kullanıcı bulunamadı!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - Es Emlak</title>
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .login-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 60px 0;
            background: #f8f9fa;
        }
        .login-card {
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border: none;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }
        .login-header {
            background: #2eca6a;
            color: white;
            padding: 25px;
            border-radius: 15px 15px 0 0;
            text-align: center;
        }
        .login-body {
            padding: 35px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            border-color: #2eca6a;
            box-shadow: 0 0 0 0.2rem rgba(46, 202, 106, 0.25);
        }
        .btn-login {
            background: #2eca6a;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 10px;
        }
        .btn-login:hover {
            background: #25a85a;
            color: white;
        }
        .register-link {
            color: #2eca6a;
            text-decoration: none;
            font-weight: 600;
        }
        .register-link:hover {
            color: #25a85a;
            text-decoration: underline;
        }
        .form-group label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card login-card">
                        <div class="login-header">
                            <h3>Giriş Yap</h3>
                        </div>
                        <div class="login-body">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php endif; ?>
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="email">E-posta Adresi</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Şifre</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-login">Giriş Yap</button>
                            </form>
                            <div class="text-center mt-4">
                                <p>Hesabınız yok mu? <a href="kayit.php" class="register-link">Hemen Kayıt Olun</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html> 