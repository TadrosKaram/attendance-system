<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? mysqli_real_escape_string($conn, $_POST['id']) : null;
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    if (!empty($name) && !empty($phone) && !empty($address)) {
        $stmt = $conn->prepare("INSERT INTO afrad (id,name, phone, address) VALUES (?,?, ?, ?)");
        $stmt->bind_param("isss", $id, $name, $phone, $address);
        $stmt->execute();
echo "<script>alert('تم إضافة الفرد بنجاح');</script>";
     
    } else {
        $error = "يرجى ملء جميع الحقول.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>إضافة فرد</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .error {
            color: red;
            text-align: center;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #333;
            text-decoration: none;
        }
    </style>
</head>
<body>

<form method="post" action="add_user.php">
    <h2 style="text-align:center;">إضافة فرد جديد</h2>

  
<input type="text" name="id" placeholder="ID (اختياري)" pattern="\d*" title="يرجى إدخال أرقام فقط">
    <input type="text" name="name" placeholder="الاسم" required>
    <input type="text" name="phone" placeholder="رقم الهاتف" required>
    <input type="text" name="address" placeholder="العنوان" required>

    <button type="submit">إضافة</button>

    
</form>

<a href="index.php" style="text-decoration:none; color: #fff; background-color: #b2b923ff; padding: 10px 20px; border-radius: 5px;">العودة</a>

</body>
</html>
