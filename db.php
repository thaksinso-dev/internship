<?php
$host = 'localhost';
$user = 'root';
$pass = '12345678'; // เปลี่ยนเป็นรหัสผ่าน AppServ ของคุณ
$dbname = 'internship_db';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>