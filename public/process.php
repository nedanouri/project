<?php
$host = 'db'; // نام هاست برای DDEV
$dbname = 'db';
$username = 'db';
$password = 'db';

try {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // اتصال به پایگاه داده با استفاده از PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // بررسی اینکه آیا فرم ارسال شده است
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // گرفتن داده‌ها از فرم
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // گرفتن داده‌های ریکوئست از چک‌باکس‌ها
        $requests = isset($_POST['request']) ? $_POST['request'] : [];

        // تبدیل داده‌های ریکوئست به فرمت JSON
        $requests_json = json_encode($requests);

        // وارد کردن داده‌ها به پایگاه داده (جدول users)
        $sql = "INSERT INTO users (first_name, last_name, email, phone, request) VALUES (:first_name, :last_name, :email, :phone, :request)";
        $stmt = $conn->prepare($sql);
        if (!$stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':phone' => $phone,
            ':request' => $requests_json
        ])) {
            var_dump($stmt->errorInfo());
        }

        // پس از ذخیره موفقیت آمیز، تعداد کل ثبت‌نام‌ها را دوباره بخوانید
        $sql = "SELECT COUNT(*) AS form_submissions FROM users";
        $result = $conn->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // ارسال تعداد ثبت‌نام‌ها به صورت JSON
        header('Content-Type: application/json');
        if ($row) {
            echo json_encode(['form_submissions' => $row['form_submissions']]);
        } else {
            echo json_encode(['form_submissions' => 0]);
        }
        exit;
    }

    // دریافت تعداد ثبت‌نام‌ها از جدول users
    $sql = "SELECT COUNT(*) AS form_submissions FROM users";
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    // ارسال داده‌ها به صورت JSON
    header('Content-Type: application/json');
    if ($row) {
        echo json_encode(['form_submissions' => $row['form_submissions']]);
    } else {
        echo json_encode(['form_submissions' => 0]);
    }

} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
