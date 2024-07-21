<?php
session_start();
include_once 'db.php';

// Check if the student is logged in
if (!isset($_SESSION['user'])) {
    header('Location: student_login.php');
    exit();
}

$student = $_SESSION['user'];
$student_id = $student['id'];

// Fetch student attendance information
$query = $db->prepare("SELECT days_present, days_absent FROM attendance WHERE student_id = :student_id");
$query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
$query->execute();
$attendance = $query->fetch(PDO::FETCH_ASSOC);

// Fetch student grades
$query = $db->prepare("SELECT subjects.name AS subject, grades.grade, grades.verbal_grade FROM grades JOIN subjects ON grades.subject_id = subjects.id WHERE grades.student_id = :student_id");
$query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
$query->execute();
$grades = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Paneli</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>E-Okul</h1>
    </header>
    <main>
        <section class="attendance-section">
            <h2>Devamsızlık Bilgileri</h2>
            <p>Gün: <?php echo isset($attendance['days_present']) ? $attendance['days_present'] : 'Bilgi bulunamadı'; ?></p>
            <p>Devamsızlık: <?php echo isset($attendance['days_absent']) ? $attendance['days_absent'] : 'Bilgi bulunamadı'; ?></p>
        </section>
        <section class="grades-section">
            <h2>Notlar</h2>
            <ul>
                <?php if (!empty($grades)): ?>
                    <?php foreach ($grades as $grade): ?>
                        <li><?php echo $grade['subject'] . ": " . $grade['grade'] . " (Sözlü: " . $grade['verbal_grade'] . ")"; ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Not bilgisi bulunamadı.</li>
                <?php endif; ?>
            </ul>
        </section>
    </main>
    <footer>
        <p>Tüm hakları Milli Eğitim Bakanlığı'na aittir.</p>
    </footer>
</body>
</html>
