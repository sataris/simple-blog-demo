<?php

namespace SimpleDemoBlog\html;
$errors = false;
use SimpleDemoBlog\Models\Post;
$headerTitle = 'Create New Post';
$pageTitle = "Create New Post";

include(__DIR__.'/../components/dependencies.php');
include (__DIR__ .'/../components/auth.php');
include (__DIR__ .'/../components/needAuth.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $post = new Post();

    $post->setUser_id($_SESSION['user_id']);
    $post->setBody($_POST['body']);
    $post->setTitle($_POST['title']);
    $post->save();

    header('Location: /post.php?id='.$post->getId());
    exit;

}

include(__DIR__ .'/../components/header.php');
include (__DIR__ .'/../components/navbar.php');
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
            $("#create_post").submit(function (e) {
                var title = $("#title").val();
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                var body = $("#body").val();
                var text = '<ul>';
                var areFieldsEmpty = false;
                if (title === "") {
                    e.preventDefault();
                    text += "<li>Please fill in the title field.</li>";
                    areFieldsEmpty = true;
                }
                if (body === "") {
                    e.preventDefault();
                    text += "<li>Please fill in the body field.</li>";
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

        <section style="display: flex; justify-content: center; align-items: center;">
            <!-- Add comment form -->

            <form id="create_post" action="create_post.php" method="POST"
                  style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                <h2><?php echo $headerTitle; ?></h2>
                <div><?php if ($errors == true) { ?>Please correct any errors and try again.<?php } ?></div>
                <label for="title" style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">Title:</label><br/>
                <input type="title" id="title" name="title"
                       style="width: 80%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ddd;">
                <br/>

                <label for="body" style="font-size: 0.9em; font-weight: bold; margin-bottom: 5px;">Body:</label>
                <textarea id="body" name="body"
                       style="width: 80%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ddd;"></textarea>

                <?php include __DIR__ .'/../components/errors.php';?>

                <button type="submit"
                        style="background-color: #007BFF; color: #fff; padding: 10px 20px; border-radius: 4px; border: none; cursor: pointer;">
                    Submit
                </button>
            </form>
        </section>
    </main>
    </body>
<?php
include(__DIR__ .'/../components/footer.php');

