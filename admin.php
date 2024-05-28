<!DOCTYPE html>
<html>
<head>
    <title>Панель управління CMS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .section {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Панель управління CMS</h1>
    <?php
    // Тут ви можете додати код PHP для отримання секцій з вашої бази даних
    // і відображення їх на сторінці. Наприклад:
    /*
    $sections = getSectionsFromDatabase(); // Функція, яку ви повинні реалізувати
    foreach ($sections as $section) {
        echo '<div class="section">';
        echo '<h2>' . $section['name'] . '</h2>';
        echo '<p><a href="edit_section.php?id=' . $section['section_id'] . '">Редагувати</a></p>';
        echo '</div>';
    }
    */
    ?>
    <p><a href="add_section.php">Додати нову секцію</a></p>
</body>
</html>
