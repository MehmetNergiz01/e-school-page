<?php
session_start();
include_once 'db.php';

// Öğrenci oturumu kontrolü
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['student']['id'])) {
    header('Location: student_login.php');
    exit();
}

$student_id = $_SESSION['user']['student']['id']; // Correct session access

try {
    // Öğrencinin notlarını ve ders adlarını çek
    $query = $conn->prepare("SELECT s.name AS subject, g.grade, g.verbal_grade, g.grade2, g.verbal_grade2, 
                             (g.grade + g.verbal_grade + g.grade2 + g.verbal_grade2) / 4 AS total_grade
                             FROM grades g 
                             JOIN subjects s ON g.subject_id = s.id 
                             WHERE g.student_id = :student_id");
    $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $query->execute();
    $grades = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . htmlspecialchars($e->getMessage());
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sınav Notları</title>
    <link rel="stylesheet" href="styles2.css">
    <style>
        header {
            background-color: #007bff;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
        }
        main {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>E-Okul - Sınav Sonuçları</h1>
    </header>
    <main>
        <section>
            <h2>Notlar</h2>
            <table>
                <thead>
                    <tr>
                        <th>Ders</th>
                        <th>1. Yazılı Notu</th>
                        <th>1. Sözlü Notu</th>
                        <th>2. Yazılı Notu</th>
                        <th>2. Sözlü Notu</th>
                        <th>Toplam Not</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($grades)): ?>
                        <?php foreach ($grades as $grade): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($grade['subject']); ?></td>
                                <td><?php echo htmlspecialchars($grade['grade']); ?></td>
                                <td><?php echo htmlspecialchars($grade['verbal_grade']); ?></td>
                                <td><?php echo htmlspecialchars($grade['grade2']); ?></td>
                                <td><?php echo htmlspecialchars($grade['verbal_grade2']); ?></td>
                                <td><?php echo htmlspecialchars($grade['total_grade']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Henüz notunuz bulunmamaktadır.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
        <a href="student_dashboard_home.php" class="back-button">Geri Dön</a>
    </main>
    <footer>
        <p>Tüm hakları Milli Eğitim Bakanlığı'na aittir.</p>
    </footer>
</body>
</html>
