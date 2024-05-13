<?php

namespace SimpleDemoBlog\html;
use SimpleDemoBlog\Models\Post;


include __DIR__ . "/../components/dependencies.php";
include (__DIR__ .'/../components/auth.php');
include (__DIR__ .'/../components/needAuth.php');

$post = Post::find($_GET['id']);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {


    if ($post->getUser_Id() !== $_SESSION['user_id']) {
        $_SESSION['errors'][] = 'You are not authorized to edit this post.';
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($post->getUser_Id() !== $_SESSION['user_id']) {
        $_SESSION['errors'][] = 'You are not authorized to edit this post.';
        header('Location: index.php');
        exit();
    }
    $post->setTitle($_POST['title']);
    $post->setBody($_POST['body']);
    $post->save();
    header('Location: /edit_post.php?id=' . $post->getId());
        exit();
}
$headerTitle = 'Edit ' . $post->getTitle();
    $pageTitle = $headerTitle . ' | Simple Blog';
include(__DIR__.'/../components/header.php');
include(__DIR__.'/../components/navbar.php');
include(__DIR__.'/../components/captcha.php');
?>
<body>
<main>
<h2><?php echo $headerTitle;?></h2>
    <section style="display: flex; justify-content: center; align-items: center;">
        <!-- Add comment form -->

        <form id="editPost" action="edit_post.php?id=<?php echo $post->getId();?>" method="post"
              style="width: 100%; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
            <label for="name" style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">Title:</label>
        <br/>
            <input type="text" id="title" name="title"
                   style="width: 80%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ddd;" value="<?php echo $post->getTitle();?>" >
            <br/>
            <label for="body" style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">Body:</label>
            <br/>

            <textarea id="body" name="body"
                      style="width: 80%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ddd;"><?php echo $post->getBody();?></textarea>
            <br/>
            <button type="submit"
                    style="background-color: #007BFF; color: #fff; padding: 10px 20px; border-radius: 4px; border: none; cursor: pointer;">
                Submit
            </button>
            <?php include __DIR__ .'/../components/errors.php';?>
        </form>
    </section>
</main>
</body>
<?php
include __DIR__ .'/../components/footer.php';




