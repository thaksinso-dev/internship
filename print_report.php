<?php
include 'db.php';
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : 1;

// ดึงข้อมูลนักศึกษา
$student_result = $conn->query("SELECT * FROM users WHERE id = $student_id");
$student = $student_result->fetch_assoc();

// ดึงรายงานทั้งหมดของนักศึกษาคนนี้
$reports = $conn->query("SELECT * FROM weekly_reports WHERE student_id = $student_id ORDER BY week_no ASC");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>พิมพ์รายงานการฝึกงาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-white">
<div class="container mt-4">
    <div class="text-center mb-4">
        <h4>รายงานผลการฝึกงานวิชาชีพ สาขาไฟฟ้ากำลัง</h4>
        <h5>วิทยาลัยเทคนิคขอนแก่น</h5>
        <p>ชื่อ-นามสกุล: <b><?php echo $student['fullname']; ?></b> | ระดับชั้น: <b><?php echo $student['level']; ?></b></p>
    </div>

    <table class="table table-bordered">
        <thead class="table-secondary text-center">
            <tr>
                <th width="10%">สัปดาห์ที่</th>
                <th width="50%">สรุปผลการปฏิบัติงาน</th>
                <th width="40%">รูปภาพการปฏิบัติงาน</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $reports->fetch_assoc()) { ?>
            <tr>
                <td class="text-center"><?php echo $row['week_no']; ?></td>
                <td><?php echo nl2br($row['work_summary']); ?></td>
                <td class="text-center">
                    <?php if($row['image_path']) { ?>
                        <img src="<?php echo $row['image_path']; ?>" width="150" class="img-thumbnail">
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary">พิมพ์รายงาน (Print)</button>
    </div>
</div>
</body>
</html>