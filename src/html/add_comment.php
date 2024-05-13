<?php

namespace SimpleDemoBlog\html;
use SimpleDemoBlog\Models\Comment;

include(__DIR__.'/../components/dependencies.php');
include (__DIR__ .'/../components/auth.php');

if ($_POST['captcha'] !== $_SESSION['captcha']) {
    $_SESSION['errors'][] = 'Captcha Incorrect';
    header('Location: /post.php?id='.$_POST['postId']);
    exit;
}
$comment = new Comment();
$comment->setComment($_POST['comment']);
$comment->setUserName($_POST['username']);
$comment->setPostId($_POST['postId']);
$comment->setCaptcha($_POST['captcha']);
$comment->save();

header('Location: /post.php?id='.$_POST['postId']);
exit;
