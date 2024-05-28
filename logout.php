<?php
    session_start();
    session_unset(); // видаляє всі змінні сесії
    session_destroy(); // знищує сесію

    header("Location: login.php"); // перенаправляє користувача на сторінку входу
    exit();
?>
