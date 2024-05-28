<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != 'admin') {
    header("Location: login.php");
    exit();
}

$db = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8', 'root', 'sw2004sw');

// Додавання нової секції
if (isset($_POST['add_section'])) {
    $stmt = $db->prepare("INSERT INTO section (name) VALUES (?)");
    $stmt->execute([$_POST['section_name']]);
}

// Додавання нового товару
if (isset($_POST['add_product'])) {
    $stmt = $db->prepare("INSERT INTO product (name, price, availability, description, image_url, section_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['price'], $_POST['availability'], $_POST['description'], $_POST['image_url'], $_POST['section_name']]);
}

if (isset($_POST['update'])) {
    $stmt = $db->prepare("UPDATE product SET name = ?, price = ?, availability = ?, description = ?, image_url = ?, section_id = ? WHERE product_id = ?");
    $stmt->execute([$_POST['name'], $_POST['price'], $_POST['availability'], $_POST['description'], $_POST['image_url'], $_POST['section_name'], $_POST['product_id']]);
}

$stmt = $db->prepare("SELECT p.product_id, p.name, p.price, p.availability, p.description, p.image_url, s.name as section_name FROM product p INNER JOIN section s ON p.section_id = s.name");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Отримання списку секцій для випадаючого списку
$sections = $db->query("SELECT * FROM section")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Редагування товарів</title>
    <!-- Стилі CSS -->
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
        .add-section-container, .add-product-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            margin-top: 20px;
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group textarea {
            resize: vertical;
        }
    </style>
</head>
<body>
    <!-- Ваш попередній HTML код ... -->
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
    <!-- Форма для додавання нової секції -->
    <div class="add-section-container">
        <h2>Додати нову секцію</h2>
        <form method="post">
            <div class="form-group">
                <label for="section_name">Назва секції:</label>
                <input type="text" id="section_name" name="section_name" required>
            </div>
            <input type="submit" name="add_section" value="Додати секцію" class="button">
        </form>
    </div>

    <!-- Форма для додавання нового товару -->
    <div class="add-product-container">
        <h2>Додати новий товар</h2>
        <form method="post">
            <div class="form-group">
                <label for="name">Назва товару:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="price">Ціна:</label>
                <input type="text" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="availability">Кількість:</label>
                <input type="text" id="availability" name="availability" required>
            </div>
            <div class="form-group">
                <label for="description">Опис:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="image_url">Image URL:</label>
                <input type="text" id="image_url" name="image_url" required>
            </div>
            <div class="form-group">
                <label for="section_name">Секція:</label>
                <select id="section_name" name="section_name" required>
                    <?php foreach ($sections as $section): ?>
                        <option value="<?php echo htmlspecialchars($section['name']); ?>">
                            <?php echo htmlspecialchars($section['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="submit" name="add_product" value="Додати товар" class="button">
        </form>
    </div>

    <div class="edit-products-container">
        <h2>Редагування товарів</h2>
        <table>
            <!-- Шапка таблиці -->
            <tr>
                <th>ID</th>
                <th>Назва</th>
                <th>Ціна</th>
                <th>Кількість</th>
                <th>Опис</th>
                <th>Image URL</th>
            </tr>
            <!-- Вивід товарів -->
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['price']); ?></td>
                <td><?php echo htmlspecialchars($product['availability']); ?></td>
                <td><?php echo htmlspecialchars($product['description']); ?></td>
                <td><?php echo htmlspecialchars($product['image_url']); ?></td>
                <td>
                </td>
            </tr>
            <!-- Модальне вікно для редагування товару -->
            <div id="editModal-<?php echo $product['product_id']; ?>" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="document.getElementById('editModal-<?php echo $product['product_id']; ?>').style.display='none'">×</span>
                    <form method="post">
                        <!-- Поля для редагування товару -->
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                        <label for="name">Назва:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                        <label for="price">Ціна:</label>
                        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>">
                        <label for="availability">Кількість:</label>
                        <input type="text" id="availability" name="availability" value="<?php echo htmlspecialchars($product['availability']); ?>">
                        <label for="description">Опис:</label>
                        <textarea id="description" name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
                        <label for="image_url">Image URL:</label>
                        <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>">
                        <input type="submit" name="update" value="Оновити" class="button">
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>

