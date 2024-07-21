<?php
session_start();
include_once 'db.php';

if (!isset($_SESSION['teacher'])) {
    header('Location: teacher_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $grade = $_POST['grade'];
    $verbal_grade = $_POST['verbal_grade'];
    $grade2 = $_POST['grade2'];
    $verbal_grade2 = $_POST['verbal_grade2'];
    $teacher_id = $_SESSION['teacher']['id'];

    $query = $conn->prepare("INSERT INTO grades (student_id, subject_id, grade, verbal_grade, teacher_id, grade2, verbal_grade2) VALUES (:student_id, :subject_id, :grade, :verbal_grade, :teacher_id, :grade2, :verbal_grade2)");
    $query->execute([
        'student_id' => $student_id,
        'subject_id' => $subject_id,
        'grade' => $grade,
        'verbal_grade' => $verbal_grade,
        'teacher_id' => $teacher_id,
        'grade2' => $grade2,
        'verbal_grade2' => $verbal_grade2
    ]);
    $success_message = "Notlar başarıyla eklendi!";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Not Ekle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #007bff;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
        }
        button:hover {
            background-color: #0056b3;
        }
        .success {
            color: green;
            text-align: center;
            font-weight: bold;
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
                <li><a href ="index.php">Çıkış</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Not Ekle</h1>
        <?php if (isset($success_message)) {
            echo "<p class='success'>$success_message</p>";
        } ?>
        <form action="teacher_add_grades.php" method="post">
            <div class="form-group">
                <label for="student_id">Öğrenci ID</label>
                <input type="number" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="subject_id">Ders ID</label>
                <input type="number" id="subject_id" name="subject_id" required>
            </div>
            <div class="form-group">
                <label for="grade">Sınav Notu 1</label>
                <input type="number" id="grade" name="grade" required>
            </div>
            <div class="form-group">
                <label for="verbal_grade">Sözlü Notu 1</label>
                <input type="number" id="verbal_grade" name="verbal_grade" required>
            </div>
            <div class="form-group">
                <label for="grade2">Sınav Notu 2</label>
                <input type="number" id="grade2" name="grade2" required>
            </div>
            <div class="form-group">
                <label for="verbal_grade2">Sözlü Notu 2</label>
                <input type="number" id="verbal_grade2" name="verbal_grade2" required>
            </div>
            <button type="submit">Notları Ekle</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2024 E-Okul. Tüm hakları saklıdır.</p>
    </footer>
</body>
</html>
