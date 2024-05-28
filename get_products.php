<?php
    // Підключення до бази даних
    $db = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8', 'root', 'sw2004sw');

    // Отримання назви секції з POST запиту
    $section_name = $_POST['section_name'];

    // Отримання списку товарів за назвою секції
    $stmt = $db->prepare("SELECT * FROM product WHERE section_id = ?");
    $stmt->execute([$section_name]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Виведення товарів у форматі HTML
    if ($products) {
        foreach($products as $product) {
            echo '<div class="product">';
            // Перевірка наявності URL зображення
            if (!empty($product['image_url'])) {
                echo '<img src="' . htmlspecialchars($product['image_url']) . '" alt="' . htmlspecialchars($product['name']) . '">';
            }
            echo '<div class="product-info">';
            echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
            echo '<p>Ціна: ' . htmlspecialchars($product['price']) . '</p>';
            echo '<p>Наявність: ' . htmlspecialchars($product['availability']) . '</p>';
            echo '<p>Опис: ' . htmlspecialchars($product['description']) . '</p>';
            // Кнопка додавання в корзину
            echo '<button class="add-to-cart" data-product-id="' . $product['product_id'] . '">Додати в корзину</button>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>Товари в цій категорії відсутні.</p>';
    }
?>






