<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }
    // Підключення до бази даних
    $db = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8', 'root', 'sw2004sw');

    // Отримання списку секцій
    $stmt = $db->prepare("SELECT * FROM section");
    $stmt->execute();
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Products</title>
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

        .section {
    background-color: #007BFF; /* Синій колір фону */
    color: white; /* Білий колір тексту */
    padding: 10px 15px; /* Відступи для тексту всередині кнопки */
    border: none; /* Відсутність рамки */
    border-radius: 20px; /* Заокруглені кути */
    cursor: pointer; /* Курсор у вигляді руки при наведенні */
    outline: none; /* Відсутність контуру при фокусі */
    margin: 5px; /* Відступи навколо кнопки */
    transition: background-color 0.3s; /* Плавна зміна кольору при наведенні */
}
.sections {
    display: flex;
    justify-content: center; /* Вирівнювання елементів по центру */
    align-items: center; /* Вертикальне вирівнювання по центру, якщо потрібно */
    /* Інші стилі */
}
.section:hover {
    background-color: #0056b3; /* Темно-синій колір фону при наведенні */
}

.products {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    margin-top: 20px;
    width: 80%;
    margin: 20px auto;
}

.product {
    width: 30%;
    margin: 10px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
}

.product img {
    width: 100%; /* Змінено на 100% для кращого відображення */
    height: auto;
    border-radius: 5px; /* для круглих кутів */
}

.product-info {
    padding: 10px;
}

.add-to-cart {
    background-color: #007BFF;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border: none;
    border-radius: 20px; /* Заокруглені краї */
}
    </style>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".section").click(function(){
                var section_name = $(this).text(); // Отримання назви секції з тексту кнопки
                $.ajax({
                    url: 'get_products.php',
                    type: 'post',
                    data: {section_name: section_name},
                    success: function(response){
                        $("#products").html(response); 
                    }
                });
            });

            // Обробник кліку на кнопку "Додати в корзину"
            $(document).on('click', '.add-to-cart', function(){
                var product_id = $(this).data('product-id');
                // Тут можна додати код для додавання товару в корзину
                // Наприклад, відправка AJAX запиту до сервера
                $.ajax({
                    url: 'add_to_cart.php', // Файл на сервері, який обробляє додавання в корзину
                    type: 'post',
                    data: {product_id: product_id},
                    success: function(response){
                        // Тут можна додати повідомлення про успішне додавання товару
                        alert('Товар додано в корзину');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="header">
        <h2>Категорії Товарів для Дому</h2>
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
    <div class="sections">
        <?php foreach($sections as $section): ?>
            <button class="section" data-section-id="<?php echo $section['section_id']; ?>"><?php echo htmlspecialchars($section['name']); ?></button>
        <?php endforeach; ?>
    </div>
    <div id="products" class="products">
        <!-- Товари будуть завантажені тут -->
    </div>
</body>
</html>


