<?php
/**
 *Generate a random 8-character string made up of numbers, letters, and stores this string in a session.
 */

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $_SESSION["captcha"] = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        ceil(5 / strlen($x)))), 1, 5);
}