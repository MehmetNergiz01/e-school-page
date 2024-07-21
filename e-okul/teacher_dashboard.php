<?php
session_start();
include_once 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: student_login.php');
    exit();
}

$student_id = $_SESSION['user']['id'];

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    echo "Veritabanı bağlantı hatası: " . $e->getMessage();
    exit();
}

// Öğrenci notlarını getir
$query = $db->prepare("SELECT subjects.name AS subject, grades.grade, grades.verbal_grade FROM grades JOIN subjects ON grades.subject_id = subjects.id WHERE grades.student_id = :student_id");
$query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
$query->execute();
$grades = $query->fetchAll(PDO::FETCH_ASSOC);

// Öğrenci devamsızlık bilgilerini getir
$query = $db->prepare("SELECT days_present, days_absent FROM attendance WHERE student_id = :student_id");
$query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
$query->execute();
$attendance = $query->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Paneli</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <header>
        <h1>E-Okul</h1>
        <nav>
            <ul>
                <li><a href="student_exam.php">Notlar</a></li>
                <li><a href="student_discontinuity.php">Devamsızlık</a></li>
                <li><a href="dersprogrami.php">Ders Programı</a></li>
                <li><a href="logout.php">Çıkış</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>Notlar</h2>
            <ul>
                <?php if ($grades): ?>
                    <?php foreach ($grades as $grade): ?>
                        <li><?php echo htmlspecialchars($grade['subject']) . ": " . htmlspecialchars($grade['grade']) . " (Sözlü: " . htmlspecialchars($grade['verbal_grade']) . ")"; ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Not bilgisi bulunamadı.</li>
                <?php endif; ?>
            </ul>
        </section>
        <section>
            <h2>Devamsızlık</h2>
            <?php if ($attendance): ?>
                <p>Gün: <?php echo htmlspecialchars($attendance['days_present']); ?></p>
                <p>Devamsızlık: <?php echo htmlspecialchars($attendance['days_absent']); ?></p>
            <?php else: ?>
                <p>Devamsızlık bilgisi bulunamadı.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>Tüm hakları Milli Eğitim Bakanlığı'na aittir.</p>
    </footer>
</body>
</html>
