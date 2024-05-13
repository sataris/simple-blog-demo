<?php

include __DIR__.'/../../vendor/autoload.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if ($key === 'id') {
            if (!is_numeric($value)) {
                $_SESSION['errors'][] = $key.' should be a number';
                header('Location: /index.php');
                exit;
            }
        }
        if (empty($value)) {
            $_SESSION['errors'][] = $key.' cannot be blank';
        }
        $_POST[$key] = nl2br(htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8'));
    }
}
foreach ($_GET as $key => $value) {
    if ($key === 'id') {
        if (!is_numeric($value)) {
            $_SESSION['errors'][] = $key.' should be a number';
            header('Location: /index.php');
            exit;
        }
    }
}