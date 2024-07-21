<?php
session_start();
include_once 'db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $captcha_input = $_POST['captcha'];

    if ($captcha_input == $_SESSION['captcha_code']) {
        // Validate teacher login credentials using prepared statements
        $query = $conn->prepare("SELECT * FROM teachers WHERE username = :username AND password = :password");
        $query->execute(['username' => $username, 'password' => $password]);
        if ($query->rowCount() == 1) {
            $_SESSION['teacher'] = $query->fetch(PDO::FETCH_ASSOC);
            header('Location: teacher_panel.php');
            exit();
        } else {
            $error_message = "Geçersiz kullanıcı adı veya şifre!";
        }
    } else {
        $error_message = "Yanlış doğrulama kodu!";
    }
}

// Generate a new captcha code and store it in the session
$_SESSION['captcha_code'] = rand(1000, 9999);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğretmen Girişi</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Öğretmen Girişi</h1>
        <?php if (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        } ?>
        <form action="teacher_login.php" method="post">
            <div class="form-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="captcha">Doğrulama Kodu: <?php echo $_SESSION['captcha_code']; ?></label>
                <input type="text" id="captcha" name="captcha" required>
            </div>
            <button type="submit" name="login">Giriş Yap</button>
        </form>
    </div>
</body>
</html>
