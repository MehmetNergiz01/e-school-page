<?php
session_start();
include_once 'db.php';

// Check if the student is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    header('Location: student_login.php');
    exit();
}

$student_id = $_SESSION['user']['id']; // Oturumdan öğrenci ID'si alınır
$query = $conn->prepare("SELECT days_present, days_absent FROM attendance WHERE student_id = :student_id");
$query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
$query->execute();
$attendance = $query->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devamsızlık</title>
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
            width: 50%;
            margin: auto;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
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
    </style>
</head>
<body>
    <header>
        <h1>E-Okul Devamsızlık Durumu</h1>
    </header>
    <main>
        <section>
            <h2>Devamsızlık</h2>
            <?php if ($attendance): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Gün</th>
                            <th>Devamsızlık</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($attendance['days_present']); ?></td>
                            <td><?php echo htmlspecialchars($attendance['days_absent']); ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Devamsızlık bilgisi bulunamadı.</p>
            <?php endif; ?>
        </section>
        <a href="student_dashboard_home.php" class="back-button">Geri Dön</a>
    </main>
    <footer>
        <p>Tüm hakları Milli Eğitim Bakanlığı'na aittir.</p>
    </footer>
</body>
</html>
