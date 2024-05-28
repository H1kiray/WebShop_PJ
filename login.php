<?php
session_start();

$db = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8', 'root', 'sw2004sw');

$login_error_message = '';
$register_error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $db->prepare("SELECT * FROM user WHERE username=? AND password=? LIMIT 1");
        $stmt->execute([$username, $password]);
        $user = $stmt->fetch();

        if ($user && $user['username'] == 'admin') {
            $_SESSION['username'] = $user['username'];
            header("Location: admin_dashboard.php");
            exit();
        } else if ($user) {
            $_SESSION['username'] = $user['username'];
            header("Location: user_dashboard.php");
            exit();
        } else {
            $login_error_message = "Неправильний логін або пароль";
        }
    } else if (isset($_POST['register'])) {
        $new_username = $_POST['new_username'];
        $new_password = $_POST['new_password'];
        $new_email = $_POST['new_email'];

        $stmt = $db->prepare("SELECT * FROM user WHERE username=? OR email=? LIMIT 1");
        $stmt->execute([$new_username, $new_email]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $register_error_message = "Логін або почта вже зайняті";
        } else {
            $stmt = $db->prepare("INSERT INTO user (username, password, email) VALUES (?, ?, ?)");
            $stmt->execute([$new_username, $new_password, $new_email]);
            $register_error_message = "Реєстрація успішна";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .login-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .login-form input[type="text"], .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .login-form input[type="submit"] {
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: none;
            color: #fff;
            background-color: #007BFF;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Login</h2>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>
        <?php if($login_error_message != ''): ?>
            <p class="error"><?php echo $login_error_message; ?></p>
        <?php endif; ?>
        <h2>Реєстрація</h2>
        <form method="post" action="">
            <input type="text" name="new_username" placeholder="Новий логін" required>
            <input type="password" name="new_password" placeholder="Новий пароль" required>
            <input type="email" name="new_email" placeholder="Почта" required>
            <input type="submit" name="register" value="Реєструватися">
        </form>
        <?php if($register_error_message != ''): ?>
            <p class="error"><?php echo $register_error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>



