<?php
if (!$userAuthenticated) {
    $_SESSION['errors'][] = 'You need an account to access this page.';
    header('Location: /login.php');
    exit;
}
?>