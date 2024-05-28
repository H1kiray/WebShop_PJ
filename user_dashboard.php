<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
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
        .store-info {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            margin-top: 20px;
            width: 100%;
            margin: 20px auto;
        }
        .store-column {
            flex: 1;
            padding: 10px;
            text-align: center;
        }
        .store-column img {
            max-width: 200px; /* Приклад розміру для логотипу та іконок */
            height: auto;
            margin-bottom: 10px;
        }
        .store-column h3 {
            margin-bottom: 10px;
        }
        .store-column p {
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Онлайн Магазин Товарів для Дому</h2>
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
    <div class="store-info">
        <div class="store-column">
            <img src="logo.png" alt="Логотип Компанії">
        </div>
        <div class="store-column">
            <h3>Ласкаво просимо до HouseShop!</h3>
            <p>Вітаємо вас на офіційному сайті HouseShop – вашого надійного партнера у створенні затишного та комфортного домашнього середовища. Наш магазин пропонує широкий асортимент товарів для дому, які задовольнять будь-які ваші потреби та допоможуть зробити ваш дім справжнім оазисом затишку..</p>
            <h4>Про нас</h4>
            <p>HouseShop – це більше ніж просто магазин. Це місце, де ваші мрії про ідеальний дім стають реальністю. Ми працюємо на ринку вже багато років, і за цей час зарекомендували себе як відповідальний і надійний постачальник товарів для дому. Ми пишаємося своєю репутацією та прагнемо забезпечити кожного клієнта найвищим рівнем сервісу.</p>
            <h5>Наші переваги</h5>
            <p> Широкий вибір товарів: ми постійно оновлюємо наш асортимент, щоб ви могли знайти все, що потрібно саме вам.</p>
            <p> Якість та надійність: ми співпрацюємо лише з перевіреними постачальниками та брендами, щоб забезпечити високу якість кожного товару.</p>
            <p> Конкурентні ціни: у HouseShop ми пропонуємо справедливі ціни та регулярні акції, щоб кожен міг дозволити собі якісний товар для дому.</p>
            <p> Зручний сервіс: наш інтуїтивно зрозумілий веб-сайт дозволяє легко знаходити та замовляти необхідні товари. Крім того, ми пропонуємо швидку та надійну доставку.</p>
            <p> Професійна підтримка: наша команда завжди готова допомогти вам з будь-якими питаннями та надати консультацію щодо вибору товарів.</p>
            <h6>Завітайте до нас сьогодні і переконайтеся самі, чому HouseShop – це найкращий вибір для вашого дому. Ми завжди раді вітати нових клієнтів і робимо все можливе, щоб ваші покупки були приємними та вигідними. Дякуємо, що обрали HouseShop!</h6>
        </div>
        <div class="store-column">
            <img src="delivery.png" alt="Швидка доставка">
            <p>Швидка доставка</p>
            <img src="discount.png" alt="Знижка на перше замовлення">
            <p>Знижка на перше замовлення</p>
            <img src="return.png" alt="Легке повернення">
            <p>Легке повернення</p>
        </div>
    </div>
</body>
</html>





