<?php
session_start();
include_once 'db.php';

if (isset($_POST['login'])) {
    $tc_number = $_POST['tc_number'];
    $password = $_POST['password'];
    $captcha_input = $_POST['captcha'];

    // Debug: Display input values
    // echo "TC Number: $tc_number, Password: $password, Captcha: $captcha_input";

    if ($captcha_input == $_SESSION['captcha_code']) {
        // Validate parent login credentials using prepared statements
        $query = $conn->prepare("SELECT * FROM parents WHERE tc_number = :tc_number");
        $query->bindParam(':tc_number', $tc_number, PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount() == 1) {
            // Fetch parent details
            $parent = $query->fetch(PDO::FETCH_ASSOC);

            // Verify the password (temporarily using plain text comparison for debugging)
            // if (password_verify($password, $parent['password'])) {
            if ($password == $parent['password']) { // Temporary plain text comparison
                // Fetch student details associated with the parent
                $student_query = $conn->prepare("SELECT s.* FROM students s
                                                 JOIN parent_student ps ON s.id = ps.student_id
                                                 WHERE ps.parent_id = :parent_id");
                $student_query->bindParam(':parent_id', $parent['id'], PDO::PARAM_INT);
                $student_query->execute();

                if ($student_query->rowCount() == 1) {
                    $student = $student_query->fetch(PDO::FETCH_ASSOC);

                    // Store both parent and student information in the session
                    $_SESSION['user'] = [
                        'parent' => $parent,
                        'student' => $student
                    ];

                    header('Location: student_dashboard_home.php');
                    exit();
                } else {
                    $error_message = "Bu veliye ait öğrenci bulunamadı!";
                }
            } else {
                $error_message = "Geçersiz TC kimlik numarası veya şifre!";
            }
        } else {
            $error_message = "Geçersiz TC kimlik numarası veya şifre!";
        }
    } else {
        $error_message = "Yanlış doğrulama kodu!";
    }
}

// Yeni bir doğrulama kodu oluştur ve oturumda sakla
$_SESSION['captcha_code'] = rand(1000, 9999);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veli Girişi</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Veli Girişi</h1>
        <?php if (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        } ?>
        <form action="parent_login.php" method="post">
            <div class="form-group">
                <label for="tc_number">TC Kimlik Numarası</label>
                <input type="text" id="tc_number" name="tc_number" required>
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
