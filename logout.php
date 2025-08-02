<?php
session_start();
session_unset(); // حذف كل متغيرات الجلسة
session_destroy(); // تدمير الجلسة

header("Location: login.php"); // الرجوع لصفحة تسجيل الدخول
exit();
?>