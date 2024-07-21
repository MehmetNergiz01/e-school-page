<?php
session_start();
include_once 'db.php';

// Öğrenci oturumu kontrolü
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['student'])) {
    header('Location: student_login.php');
    exit();
}

$student = $_SESSION['user']['student'];

// Öğrenci ID'sini oturumdan alın
if (!isset($student['id'])) {
    $error_message = "Öğrenci ID bilgisi eksik!";
    die($error_message); // Hata mesajını ekrana yazdır ve çalışmayı durdur
}

$student_id = $student['id'];

// Ders programını veritabanından çek
$query = $conn->prepare("SELECT s.name AS subject, sch.day 
                         FROM schedule sch 
                         JOIN subjects s ON sch.subject_id = s.id 
                         WHERE sch.student_id = :student_id");
$query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
$query->execute();
$schedule = $query->fetchAll(PDO::FETCH_ASSOC);

// Günleri ve dersleri organize et
$days = ["Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma"];
$schedule_by_day = array_fill_keys($days, array_fill(0, 5, 'Boş'));

// Gün isimleri eşleştirme
$day_mapping = [
    'Pazartesi' => 'Pazartesi',
    'Salı' => 'Salı',
    'Çarşamba' => 'Çarşamba',
    'Perşembe' => 'Perşembe',
    'Cuma' => 'Cuma'
];

foreach ($schedule as $lesson) {
    $day = $lesson['day'];
    if (isset($day_mapping[$day])) {
        // Gün için uygun boş bir ders saati bul
        for ($i = 0; $i < 5; $i++) {
            if ($schedule_by_day[$day_mapping[$day]][$i] == 'Boş') {
                $schedule_by_day[$day_mapping[$day]][$i] = $lesson['subject'];
                break;
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
    <title>Ders Programı</title>
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
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
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
        <h1>E-Okul-Ders Programı</h1>
    </header>
    <main>
        <section>
            <h2>Ders Programı</h2>
            <?php if (!empty($schedule)): ?>
                <table>
                    <thead>
                        <tr>
                            <?php foreach ($days as $day): ?>
                                <th><?php echo htmlspecialchars($day); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <tr>
                                <?php foreach ($days as $day): ?>
                                    <td>
                                        <?php echo htmlspecialchars($schedule_by_day[$day][$i]); ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Ders programı bilgisi bulunamadı.</p>
            <?php endif; ?>
            <a href="student_dashboard_home.php" class="back-button">Geri Dön</a>
        </section>
    </main>
    <footer>
        <p>Tüm hakları Milli Eğitim Bakanlığı'na aittir.</p>
    </footer>
</body>
</html>
