<?php
session_start();
include 'baglan.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    // Şifre kontrolü
    if ($password !== $password_confirm) {
        $error = "Şifreler eşleşmiyor!";
    } else {
        // Kullanıcı adı ve email kontrolü
        $check_query = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $error = "Bu kullanıcı adı veya e-posta adresi zaten kullanılıyor!";
        } else {
            // Yeni kullanıcıyı kaydet
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
            
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success'] = "Kayıt başarılı! Şimdi giriş yapabilirsiniz.";
                header("Location: giris.php");
                exit;
            } else {
                $error = "Kayıt sırasında bir hata oluştu!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - Es Emlak</title>
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .register-section {
            padding: 100px 0;
            background: #f8f9fa;
        }
        .register-card {
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border: none;
        }
        .register-header {
            background: #2eca6a;
            color: white;
            padding: 20px;
            border-radius: 15px 15px 0 0;
            text-align: center;
        }
        .register-body {
            padding: 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 15px;
        }
        .btn-register {
            background: #2eca6a;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-register:hover {
            background: #25a85a;
            color: white;
        }
        .login-link {
            color: #2eca6a;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link:hover {
            color: #25a85a;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section class="register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card register-card">
                        <div class="register-header">
                            <h3>Kayıt Ol</h3>
                        </div>
                        <div class="register-body">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php endif; ?>
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="username">Kullanıcı Adı</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">E-posta Adresi</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Şifre</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirm">Şifre Tekrar</label>
                                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                                </div>
                                <button type="submit" class="btn btn-register">Kayıt Ol</button>
                            </form>
                            <div class="text-center mt-4">
                                <p>Zaten hesabınız var mı? <a href="giris.php" class="login-link">Giriş Yapın</a></p>
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