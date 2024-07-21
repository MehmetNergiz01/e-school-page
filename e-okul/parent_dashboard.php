<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: parent_login.php');
    exit();
}

include('db.php');
$parent_id = $_SESSION['user']['id'];

// Veli ismini oturumdan al
$parent_name = $_SESSION['user']['name'];

// Öğrenci bilgilerini çek
$query = $conn->prepare("SELECT * FROM students WHERE tc_number = (SELECT tc_number FROM parents WHERE id = :parent_id)");
$query->bindParam(':parent_id', $parent_id);
$query->execute();

if ($query->rowCount() > 0) {
    $student = $query->fetch(PDO::FETCH_ASSOC);
} else {
    $student = null;
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veli Paneli</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Veli Paneli</h1>
        <p>Hoş geldiniz, <?php echo htmlspecialchars($parent_name); ?>!</p>
        <?php if ($student): ?>
            <h2>Öğrenci Bilgileri</h2>
            <p>Öğrenci Adı: <?php echo htmlspecialchars($student['name']); ?></p>
            <p>Öğrenci Numarası: <?php echo htmlspecialchars($student['school_id']); ?></p>
            <!-- Daha fazla alan ekleyebilirsiniz -->
        <?php else: ?>
            <p>Öğrenci bilgisi bulunamadı.</p>
        <?php endif; ?>
        <a href="parent_logout.php">Çıkış Yap</a>
    </div>
</body>
</html>
