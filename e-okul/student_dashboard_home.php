<?php
session_start();
include_once 'db.php';

// Öğrenci oturumu kontrolü
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['student'])) {
    header('Location: student_login.php');
    exit();
}

$student = $_SESSION['user']['student'];

// Oturumda 'id' anahtarının olup olmadığını kontrol edin
if (!isset($student['id'])) {
    $error_message = "Öğrenci ID bilgisi eksik!";
    die($error_message); // Hata mesajını ekrana yazdır ve çalışmayı durdur
}

$student_id = $student['id'];
$_SESSION['user']['id'] = $student_id; // Add this line to ensure the 'id' key is set in the session

$student_name = $student['name'];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Paneli</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <header>
        <h1>E-Okul</h1>
    </header>
    <main>
        <section class="welcome-section">
            <h2>Hoşgeldin <?php echo htmlspecialchars($student_name); ?></h2>
        </section>
        <section class="dashboard-section">
            <div class="dashboard-card">
                <a href="student_discontinuity.php">
                    <div class="card-content">
                        <h3>Devamsızlık</h3>
                    </div>
                </a>
            </div>
            <div class="dashboard-card">
                <a href="student_lesson.php">
                    <div class="card-content">
                        <h3>Ders Programı</h3>
                    </div>
                </a>
            </div>
            <div class="dashboard-card">
                <a href="student_exam.php">
                    <div class="card-content">
                        <h3>Sınav Sonuçları</h3>
                    </div>
                </a>
            </div>
            <div class="dashboard-card">
                <a href="index.php">
                    <div class="card-content">
                        <h3>Çıkış</h3>
                    </div>
                </a>
            </div>
        </section>
    </main>
    <footer>
        <p>Tüm hakları Milli Eğitim Bakanlığı'na aittir.</p>
    </footer>
</body>
</html>
