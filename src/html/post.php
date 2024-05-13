<?php

namespace  SimpleDemoBlog\html;
include(__DIR__.'/../components/dependencies.php');



use SimpleDemoBlog\Models\Post;

$blogPost = Post::find($_GET['id']);
if (!$blogPost) {
        header("Location: index.php");
        exit();
    }

$pageTitle = $blogPost->getTitle().' | Simple Blog';
$headerTitle = 'Single Blog Page';
include(__DIR__.'/../components/auth.php');
include(__DIR__.'/../components/header.php');
include(__DIR__.'/../components/navbar.php');
include(__DIR__.'/../components/captcha.php');
?>
    <script>
        $(document).ready(function () {
            var dialog = $("#dialog").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    Ok: function () {
                        $(this).dialog("close");
                    }
                }
            });
            $("#submitComment").submit(function (e) {
                var username = $("#username").val();
                var body = $("#comment").val();
                var captcha = $("#captcha").val();
                var text = '<ul>';
                var areFieldsEmpty = false;

                if (username == "") {
                    e.preventDefault();
                    text += "<li>Please fill in the User Name field.</li>";
                    areFieldsEmpty = true;
                }
                if (body == "") {
                    e.preventDefault();
                    text += "<li>Please fill in the Comment field.</li>";
                    areFieldsEmpty = true;
                }
                if (captcha == "") {
                    e.preventDefault();
                    text += "<li>Please fill in the Captcha field.</li>";
                    areFieldsEmpty = true;
                }

                text += '</ul>'; // closes the <ul> after list items

                if (areFieldsEmpty) {
                    e.preventDefault();
                    $("#modalMessage").html(text); // use .html() to render HTML tags
                    dialog.dialog("open");
                }
            });
        });
    </script>
<body>
<main>
    <article>
        <h2><?php echo $blogPost->getTitle(); if ($userAuthenticated && ($blogPost->getUser_id() === $_SESSION['user_id'])) { ?> <a href="edit_post.php?id=<?php echo $blogPost->getId()?>">(edit)</a> <?php } ?></h2>
        <p><?php echo $blogPost->getBody(); ?></p>
        <p>Published on:
            <time datetime="<?php echo $blogPost->getCreated_At()->format('Y-m-d H:i:s'); ?>"><?php echo $blogPost->getCreated_At()->format('F j, Y'); ?></time>
        </p>
    </article>
    <hr>

    <?php
    $commentCount = count($blogPost->comments());
    ?>
    <section>
        <h3>Comments (<?php echo $commentCount; ?>)</h3>

        <div>
            <?php foreach ($blogPost->comments() as $comment) { ?>
                <!-- Each comment -->
                <div class="comment">
                    <h4><?php echo $comment->getUserName(); ?></h4>
                    <p><?php echo $comment->getComment(); ?></p>
                </div>
            <?php } ?>
        </div>
    </section>
    <h2>Add Comment</h2>
    <section style="display: flex; justify-content: center; align-items: center;">
        <!-- Add comment form -->

        <form id="submitComment" action="add_comment.php" method="post"
              style="width: 100%; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
            <label for="name" style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">Name:</label>
        <br/>
            <input type="text" id="username" name="username" <?php if ($userAuthenticated) { ?>readonly value="<?= $_SESSION['user_name']?>" <?php }?>
                   style="width: 80%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ddd;">
            <br/>
            <label for="comment" style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">Comment:</label>
            <br/>
            <textarea id="comment" name="comment"
                      style="width: 80%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ddd;"></textarea>
            <br/>
            <label for="captcha"
                   style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">Captcha: <?php echo $_SESSION["captcha"]; ?></label>
            <br/>
            <input type="text" id="captcha" name="captcha"
                   style="width: 80%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ddd;">
            <br/>
            <input type="hidden" id="postId" name="postId" value="<?php echo $blogPost->getId(); ?>"/>
            <button type="submit"
                    style="background-color: #007BFF; color: #fff; padding: 10px 20px; border-radius: 4px; border: none; cursor: pointer;">
                Submit
            </button>
            <?php include __DIR__ .'/../components/errors.php';?>
        </form>
    </section>
</main>
<?php include __DIR__.'/../components/footer.php'; ?>
</body>
</html>