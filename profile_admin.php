<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    // Підключення до бази даних
    $db = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8', 'root', 'sw2004sw');

    // Отримання даних користувача
    $stmt = $db->prepare("SELECT username, email FROM user WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Якщо користувача не знайдено, виведіть повідомлення або перенаправте
        echo "Користувача не знайдено.";
        exit; // Зупиніть подальше виконання скрипта
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Мій профіль</title>
    <style>
        .profile-info {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 100px; /* Враховуючи фіксований header */
            width: 70%;
            text-align: center;
        }
        /* CSS стилі для модуля profile.php */
        .error {
    color: red;
    margin: 10px 0;
}
.profile-info {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
    padding: 20px;
    margin-top: 100px; /* Враховуючи фіксований header */
    width: 70%;
    text-align: center;
}

body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: header;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .header {
            background-color: #007BFF;
            color: #fff;
            width: 100%;
            padding: 20px 0;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
        }
        .dashboard {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            margin-top: 70px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        .dashboard ul {
            display: flex;
            justify-content: space-around;
            list-style-type: none;
            padding: 0;
            width: 70%;
        }
        .dashboard ul li {
            margin-bottom: 10px;
            margin-right: 20px;
        }
        .dashboard ul li a {
            text-decoration: none;
            color: #007BFF;
        }
        .profile {
            width: 20%;
            text-align: right;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<div class="header">
        <h2>Профіль адміна</h2>
    </div>
    <div class="dashboard">
        <ul>
            <li><a href="edit_users.php">Редагування користувачів</a></li>
            <li><a href="edit_products.php">Редагування товарів</a></li>
            <li><a href="view_orders.php">Перегляд поточних замовлень</a></li>
            <li><a href="edit_content.php">Редагування контенту сайта</a></li>
        </ul>
        <div class="profile">
            <a href="profile_admin.php">Мій профіль</a> | <a href="logout.php">Вихід</a>
        </div>
    </div>
    <div class="profile-info">
        <h2>Інформація користувача</h2>
        <p>Логін: <?php echo htmlspecialchars($user['username']); ?></p>
        <p>Електронна пошта: <?php echo htmlspecialchars($user['email']); ?></p>
    </div>
</body>
</html>
