<?php
    session_start();
    if(!isset($_SESSION['username']) || $_SESSION['username'] != 'admin') {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
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
        <h2>Welcome, Admin  CMS System</h2>
    </div>
    <div class="dashboard">
        <ul>
            <li><a href="edit_users.php">Редагування користувачів</a></li>
            <li><a href="edit_products.php">Редагування товарів</a></li>
            <li><a href="view_orders.php">Перегляд поточних замовлень</a></li>
            <li><a href="edit_content.php">Редагування контенту сайта</a></li>
            <li><a href="view_products.php">Перегляд товарів на сайті</a></li>
        </ul>
        <div class="profile">
            <a href="profile_admin.php">Мій профіль</a> | <a href="logout.php">Вихід</a>
        </div>
    </div>
</body>
</html>








