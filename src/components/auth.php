<?php
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    $userAuthenticated = false;
} else {
    $userAuthenticated = true;
}