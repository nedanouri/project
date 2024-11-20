<?php
$host = 'db'; // نام هاست برای DDEV
$dbname = 'db';
$username = 'db';
$password = 'db';

try {
    // اتصال به پایگاه داده با استفاده از PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // چک کردن وجود ردیف با id = 1
    $check_row_sql = "SELECT COUNT(*) FROM site_statistics WHERE id = 1";
    $check_row_result = $conn->query($check_row_sql);
    $row_count = $check_row_result->fetchColumn();

    if ($row_count == 0) {
        // اگر ردیف وجود ندارد، ردیف جدید اضافه کنید
        $insert_default_stats_sql = "INSERT INTO site_statistics (id, page_visits, form_submissions) VALUES (1, 0, 0)";
        $conn->exec($insert_default_stats_sql);
    }

    // **افزایش تعداد بازدید صفحه** بدون شرط POST
    $update_page_visits_sql = "UPDATE site_statistics SET page_visits = page_visits + 1 WHERE id = 1";
    $update_page_visits_stmt = $conn->prepare($update_page_visits_sql);
    $update_page_visits_stmt->execute();

    // بررسی اینکه آیا فرم ارسال شده است
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // گرفتن داده‌ها از فرم
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // وارد کردن داده‌ها به پایگاه داده (جدول users)
        $sql = "INSERT INTO users (first_name, last_name, email, phone) VALUES (:first_name, :last_name, :email, :phone)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':phone' => $phone
        ]);

        // به‌روزرسانی آمار در جدول site_statistics
        // افزایش تعداد فرم‌های ارسال شده
        $update_form_submissions_sql = "UPDATE site_statistics SET form_submissions = form_submissions + 1 WHERE id = 1";
        $update_form_submissions_stmt = $conn->prepare($update_form_submissions_sql);
        $update_form_submissions_stmt->execute();
    }

    // دریافت آمار از پایگاه داده (برای نمایش تعداد فرم‌های ارسال شده و بازدیدها)
    $sql = "SELECT form_submissions, page_visits FROM site_statistics WHERE id = 1";
    $result = $conn->query($sql);

    if ($result->rowCount() > 0) {
        // گرفتن داده‌های آمار
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // ارسال داده‌ها به صورت JSON برای استفاده در JavaScript
        echo json_encode($row);
    } else {
        echo json_encode(['form_submissions' => 0, 'page_visits' => 0]);
    }

} catch (PDOException $e) {
    echo "خطا: " . $e->getMessage();
}
?>
