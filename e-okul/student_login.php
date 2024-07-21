<?php
session_start();
include_once 'db.php';

if (isset($_POST['login'])) {
    $school_id = $_POST['school_id'];
    $tc_number = $_POST['tc_number'];
    $random_number_input = $_POST['random_number'];

    if ($random_number_input == $_SESSION['random_number']) {
        // Öğrenci giriş bilgilerini doğrula
        $query = $conn->prepare("SELECT * FROM students WHERE school_id = :school_id AND tc_number = :tc_number");
        $query->bindParam(':school_id', $school_id, PDO::PARAM_STR);
        $query->bindParam(':tc_number', $tc_number, PDO::PARAM_STR);
        $query->execute();
        
        if ($query->rowCount() == 1) {
            // Öğrenci bilgilerini al ve oturumda sakla
            $student = $query->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user']['student'] = $student;
            header('Location: student_dashboard_home.php');
            exit();
        } else {
            $error_message = "Geçersiz okul numarası veya TC kimlik numarası!";
        }
    } else {
        $error_message = "Yanlış doğrulama kodu!";
    }
}

// Yeni bir doğrulama kodu oluştur ve oturumda sakla
$_SESSION['random_number'] = rand(1000, 9999);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Girişi</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Öğrenci Girişi</h1>
        <?php if (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        } ?>
        <form action="student_login.php" method="post">
            <div class="form-group">
                <label for="school_id">Okul Numarası</label>
                <input type="text" id="school_id" name="school_id" required>
            </div>
            <div class="form-group">
                <label for="tc_number">TC Kimlik Numarası</label>
                <input type="text" id="tc_number" name="tc_number" required>
            </div>
            <div class="form-group">
                <label for="random_number_input">Doğrulama Kodu: <?php echo $_SESSION['random_number']; ?></label>
                <input type="text" id="random_number_input" name="random_number" required>
            </div>
            <button type="submit" name="login">Giriş Yap</button>
        </form>
    </div>
</body>
</html>
