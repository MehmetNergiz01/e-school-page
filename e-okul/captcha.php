<?php
session_start();

function generateCaptcha() {
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $operators = ['+', '-', '*'];
    $operator = $operators[array_rand($operators)];

    switch ($operator) {
        case '+':
            $answer = $num1 + $num2;
            break;
        case '-':
            $answer = $num1 - $num2;
            break;
        case '*':
            $answer = $num1 * $num2;
            break;
    }

    $_SESSION['captcha'] = $answer;

    return "$num1 $operator $num2";
}

header('Content-Type: image/png'); // Add this line
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Pragma: no-cache');

$question = generateCaptcha();

$image = imagecreatetruecolor(150, 30);
$bgColor = imagecolorallocate($image, 255, 255, 255);
$textColor = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 0, 0, 150, 30, $bgColor);
imagettftext($image, 14, 0, 10, 20, $textColor, './arial.ttf', $question);

imagepng($image);
imagedestroy($image);
?>