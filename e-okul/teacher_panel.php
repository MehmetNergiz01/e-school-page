<?php
session_start();
if (!isset($_SESSION['teacher'])) {
    header('Location: teacher_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğretmen Paneli</title>
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
        <h1>E-Okul - Öğretmen Paneli</h1>
        <nav>
            <ul>
                <li><a href="teacher_add_grades.php">Not Güncelle</a></li>
                <li><a href="teacher_add_attendance.php">Devamsızlık Ekle</a></li>
                <li><a href="teacher_add_schedule.php">Ders Programı Ekle</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Hoşgeldiniz, Öğretmen</h2>
        <p>Yapmak istediğiniz işlemi yukarıdaki menüden seçin.</p>
    </main>
    <footer>
        <p>Tüm hakları Milli Eğitim Bakanlığı'na aittir.</p>
    </footer>
</body>
</html>
