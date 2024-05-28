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

   // Логіка зміни даних користувача (припускаючи, що форма відправлена)
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = []; // Масив для зберігання повідомлень про помилки

    // Оновлення логіна
    if (isset($_POST['new_username']) && $_POST['new_username'] !== '') {
        $new_username = $_POST['new_username'];
        // Перевірка чи логін вже існує
        $stmt = $db->prepare("SELECT COUNT(*) FROM user WHERE username = ?");
        $stmt->execute([$new_username]);
        $count = $stmt->fetchColumn();
        if ($count == 0) {
            // Логін не існує, можна оновлювати
            $stmt = $db->prepare("UPDATE user SET username = ? WHERE username = ?");
            $stmt->execute([$new_username, $_SESSION['username']]);
            $_SESSION['username'] = $new_username; // Оновлення сесії з новим логіном
        } else {
            $errors[] = "Цей логін вже використовується.";
        }
    }

    // Оновлення електронної пошти
    if (isset($_POST['new_email']) && $_POST['new_email'] !== '') {
        $new_email = $_POST['new_email'];
        // Перевірка чи електронна пошта вже існує
        $stmt = $db->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
        $stmt->execute([$new_email]);
        $count = $stmt->fetchColumn();
        if ($count == 0) {
            // Електронна пошта не існує, можна оновлювати
            $stmt = $db->prepare("UPDATE user SET email = ? WHERE username = ?");
            $stmt->execute([$new_email, $_SESSION['username']]);
        } else {
            $errors[] = "Ця електронна пошта вже використовується.";
        }
    }

    // Виведення помилок, якщо вони є
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<p class="error">' . htmlspecialchars($error) . '</p>';
        }
    }
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
    width: 100%;
    text-align: center;
}

.edit-button {
    background-color: #007BFF;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 20px;
}

.modal {
    display: none; /* Приховано за замовчуванням */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0); /* Фон з прозорістю */
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    border-radius: 5px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
body {
            margin: 0;
            padding-top: 60px; /* Відступ зверху для фіксованого хедера */
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .header {
            background-color: #007BFF;
            color: #fff;
            width: 100%;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .dashboard {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            margin: 20px auto;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        .dashboard ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-around;
            width: 100%;
        }
        .dashboard ul li {
            padding: 20px;
        }
        .dashboard ul li a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
        .profile {
            text-align: left;
            color: #007BFF;
        }
    </style>
</head>
<body>
    <div class="header">
    <h2>Профіль користувача</h2>
    </div>
    <div class="dashboard">
        <ul>
            <li><a href="user_dashboard.php">Головна</a></li>
            <li><a href="view_products.php">Товари</a></li>
            <li><a href="view_cart.php">Корзина</a></li>
        </ul>
        <div class="profile">
            <a href="profile.php">Мій профіль</a> | <a href="logout.php">Вихід</a>
        </div>
    </div>
    <div class="profile-info">
        <h2>Інформація користувача</h2>
        <p>Логін: <?php echo htmlspecialchars($user['username']); ?></p>
        <p>Електронна пошта: <?php echo htmlspecialchars($user['email']); ?></p>
        <button class="edit-button" onclick="document.getElementById('editModal').style.display='block'">Змінити дані</button>
    </div>

    <!-- Модальне вікно для редагування -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('editModal').style.display='none'">×</span>
            <form method="post">
                <label for="new_username">Новий логін:</label>
                <input type="text" id="new_username" name="new_username" value="<?php echo htmlspecialchars($user['username']); ?>">
                <label for="new_email">Нова електронна пошта:</label>
                <input type="email" id="new_email" name="new_email" value="<?php echo htmlspecialchars($user['email']); ?>">
                <input type="submit" value="Зберегти зміни">
            </form>
        </div>
    </div>
</body>
</html>
