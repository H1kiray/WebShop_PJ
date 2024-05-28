<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != 'admin') {
    header("Location: login.php");
    exit();
}

$db = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8', 'root', 'sw2004sw');

if (isset($_POST['delete']) && isset($_POST['user_id'])) {
    $stmt = $db->prepare("DELETE FROM user WHERE user_id = ?");
    $stmt->execute([$_POST['user_id']]);
}

if (isset($_POST['update'])) {
    $stmt = $db->prepare("UPDATE user SET username = ?, email = ? WHERE user_id = ?");
    $stmt->execute([$_POST['username'], $_POST['email'], $_POST['user_id']]);
}

$stmt = $db->prepare("SELECT user_id, username, email FROM user");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Редагування користувачів</title>
    <style>
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
        .edit-users-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            margin-top: 70px;
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
        }
        .button:hover {background-color: #0066cc}
        .button:active {
            background-color: #0066cc;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 10px;
        }
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Welcome, Admin in CMS System</h2>
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
    <div class="edit-users-container">
        <h2>Редагування користувачів</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Логін</th>
                <th>Почта</th>
                <th>Дії</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                        <input type="submit" name="delete" value="Видалити" class="button">
                    </form>
                </td>
            </tr>
            <div id="editModal-<?php echo $user['user_id']; ?>" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="document.getElementById('editModal-<?php echo $user['user_id']; ?>').style.display='none'">×</span>
                    <form method="post">
                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                        <label for="username">Логін:</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                        <label for="email">Почта:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                        <input type="submit" name="update" value="Оновити" class="button">
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>


