<?php
session_start();
include_once 'db.php';

if (isset($_POST['submit'])) {
    $student_id = $_POST['student_id'];
    $days_present = $_POST['days_present'];
    $days_absent = $_POST['days_absent'];

    // Check if student_id exists in students table
    $check_student = $conn->prepare("SELECT * FROM students WHERE id = :student_id");
    $check_student->execute(['student_id' => $student_id]);

    if ($check_student->rowCount() > 0) {
        $query = $conn->prepare("INSERT INTO attendance (student_id, days_present, days_absent) VALUES (:student_id, :days_present, :days_absent)");
        try {
            $query->execute([
                'student_id' => $student_id,
                'days_present' => $days_present,
                'days_absent' => $days_absent
            ]);
            $success_message = "Attendance added successfully!";
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    } else {
        $error_message = "Student ID does not exist!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devamsızlık Ekleme</title>
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
            display: inline-block;
            padding: 10px 20px;
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
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            font-size: 16px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
        }
        .back-button:hover {
            background-color: #218838;
        }
        .success {
            color: green;
            text-align: center;
            font-weight: bold;
        }
        .error {
            color: red;
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
                <li><a href ="index.php"></a>Çıkış</li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1>Devamsızlık Ekleme</h1>
        <?php if (isset($success_message)) { ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
        <form action="teacher_add_attendance.php" method="post">
            <div class="form-group">
                <label for="student_id">Öğrenci ID</label>
                <input type="number" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="days_present">Geldiği Gün</label>
                <input type="number" id="days_present" name="days_present" required>
            </div>
            <div class="form-group">
                <label for="days_absent">Devamsızlık Gün</label>
                <input type="number" id="days_absent" name="days_absent" required>
            </div>
            <button type="submit" name="submit">Ekle</button>
            <a href="teacher_dashboard.php" class="back-button">Geri</a>
        </form>
    </div>
    <footer>
        <p>&copy; 2024 E-Okul. Tüm hakları saklıdır.</p>
    </footer>
</body>
</html>
