<?php

require_once 'connection.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_date'])) {
    $date = $_POST['selected_date'];


    $stmt = $conn->prepare("INSERT IGNORE INTO attendance_days (date) VALUES (?)");
    $stmt->bind_param("s", $date);
    $stmt->execute();


    $res = mysqli_query($conn, "SELECT id FROM attendance_days WHERE date = '$date'");
    $row = mysqli_fetch_assoc($res);
    $day_id = $row['id'];


    $users = mysqli_query($conn, "SELECT id FROM afrad");
    while ($user = mysqli_fetch_assoc($users)) {
        $user_id = $user['id'];
        mysqli_query($conn, "INSERT IGNORE INTO attendance_records (user_id, day_id, attended) VALUES ($user_id, $day_id, '0')");
    }

    header("Location: index.php?day_id=$day_id");
    exit();
}


session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


// Get day_id from query
$day_id = isset($_GET['day_id']) ? (int)$_GET['day_id'] : 0;

// If not set, ask to start a day
if ($day_id === 0) {
    echo "<h2 style='text-align:center;'>يرجى اختيار يوم أولاً</h2>";
echo '
<form method="post" style="text-align:center;">
    <label>اختر تاريخاً لبدء يوم جديد:</label><br>
    <input type="date" name="selected_date" required>
    <button type="submit" style="margin-top: 10px; background: #4CAF50; color: white; padding: 8px 16px; border: none; border-radius: 5px;">بدء اليوم</button>
</form>
';
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Reset all to absent
    mysqli_query($conn, "UPDATE attendance_records SET attended = '0', excuse = NULL WHERE day_id = $day_id");

    // Mark attended users
    if (isset($_POST['attended'])) {
        foreach ($_POST['attended'] as $user_id => $val) {
            $user_id = (int) $user_id;
            mysqli_query($conn, "UPDATE attendance_records SET attended = '1' WHERE user_id = $user_id AND day_id = $day_id");
        }
    }

    // Save excuses for all users
    if (isset($_POST['excuse'])) {
        foreach ($_POST['excuse'] as $user_id => $excuse) {
            $user_id = (int) $user_id;
            $excuse = mysqli_real_escape_string($conn, trim($excuse));
            mysqli_query($conn, "
                UPDATE attendance_records
                SET excuse = " . ($excuse !== '' ? "'$excuse'" : "NULL") . "
                WHERE user_id = $user_id AND day_id = $day_id
            ");
        }
    }
    header("Location: index.php?day_id=$day_id");
    exit();
}

// Fetch attendance records for that day
$query = "
SELECT af.id, af.name, af.phone, af.address, ar.attended, ar.excuse
FROM attendance_records ar
JOIN afrad af ON af.id = ar.user_id
WHERE ar.day_id = $day_id
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>الغياب</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; padding: 20px; }
        h1 { text-align: center; }
        table {
            margin: auto; border-collapse: collapse; width: 90%;
            background: #fff; box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        th, td { border: 1px solid #ddd; padding: 12px 15px; text-align: center; }
        th { background-color: #f4b400; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .logout, .add-user { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>


<h1>افراد</h1>

<form action="index.php?day_id=<?= $day_id ?>" method="post">
<table>
    <tr>
        <th>ID</th><th>Name</th><th>Phone</th><th>Address</th><th>حضر؟</th><th>اعذار</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td><?= htmlspecialchars($row['address']) ?></td>
        <td>
            <input type="checkbox" name="attended[<?= $row['id'] ?>]" value="1" <?= $row['attended'] === '1' ? 'checked' : '' ?> id="checks">
        </td>
        <td>
            <input type="text" name="excuse[<?= $row['id'] ?>]" value="<?= htmlspecialchars($row['excuse']) ?>" style="width: 100%;">
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<div style="text-align:center; margin-top:20px;">
    <button type="submit" style="padding:10px 20px; background-color:#f4b400; color:white; border:none; border-radius:5px; cursor:pointer;" onclick="return confirm('هل أنت متأكد من تأكيد الحضور؟')">
        تأكيد الحضور
    </button>
</div>
</form>

<div class="add-user">
    <a href="add_user.php" style="text-decoration:none; color: #fff; background-color: #4CAF50; padding: 10px 20px; border-radius: 5px;">إضافة فرد</a>
</div>



<div class="logout">
    <a href="logout.php" style="text-decoration:none; color: #fff; background-color: #f44336; padding: 10px 20px; border-radius: 5px;">logout (for testing only)</a>
<script>
    const checkboxes = document.querySelectorAll('input[type=\"checkbox\"]');
    checkboxes.forEach(checkbox => {
        // Set initial background on page load
        if (checkbox.checked) {
            checkbox.closest('tr').style.backgroundColor = '#c8e6c9';
        }
        checkbox.addEventListener('change', function() {
            this.closest('tr').style.backgroundColor = this.checked ? '#c8e6c9' : '';
        });
    });
</script>

</body>
</html>
