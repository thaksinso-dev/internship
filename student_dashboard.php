<?php
session_start();
include 'db.php';

// สมมติว่าล็อกอินด้วย student_id = 1 (ในการใช้งานจริงให้ดึงจาก Session ตอน Login)
$student_id = 1; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $week_no = $_POST['week_no'];
    $work_summary = $_POST['work_summary'];
    
    // จัดการอัปโหลดรูปภาพ
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
    $image_name = time() . "_" . basename($_FILES["report_image"]["name"]);
    $target_file = $target_dir . $image_name;
    
    if (move_uploaded_file($_FILES["report_image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO weekly_reports (student_id, week_no, work_summary, image_path) VALUES ('$student_id', '$week_no', '$work_summary', '$target_file')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('ส่งรายงานสำเร็จ!');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ส่งรายงานการฝึกงาน - วิทยาลัยเทคนิคขอนแก่น</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="mb-4 text-primary">กรอกรายงานการฝึกงานประจำสัปดาห์ (ไฟฟ้ากำลัง)</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">สัปดาห์ที่:</label>
                <input type="number" name="week_no" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">สรุปผลการปฏิบัติงาน / งานที่ได้รับมอบหมาย:</label>
                <textarea name="work_summary" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">อัปโหลดรูปภาพการปฏิบัติงาน:</label>
                <input type="file" name="report_image" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-success">ส่งรายงาน</button>
        </form>
    </div>
</div>
</body>
</html>