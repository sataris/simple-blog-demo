<?php

use SimpleDemoBlog\Models\Post;

include(__DIR__.'/../components/dependencies.php');

$searchTerm = htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8');
$pageTitle = 'Search Results';
$headerTitle = 'Search Results';
include(__DIR__ .'/../components/auth.php');
include(__DIR__ .'/../components/header.php');
include(__DIR__ .'/../components/navbar.php');
$posts = Post::search($searchTerm);
?>
<body>
    <main>
        <?php foreach ($posts as $post) {
            ?>

        <article>
            <h2><a href="post.php?id=<?php echo $post->getId();?>"><?php echo $post->getTitle();?></a></h2>
            <p><?php echo $post->getBody();?></p>
            <p>Published on: <time datetime="<?php echo $post->getCreated_At()->format('Y-m-d H:i:s'); ?>"><?php echo $post->getCreated_At()->format('F j, Y'); ?></time></p>
        </article>
        <?php } ?>
    </main>



    <footer>
        <p>© <?php echo date('Y');  ?> Simple Blog</p>
    </footer>

    <script>
        $(document).ready(function(){
            // When user clicks on Login or Register link
            $('.trigger-modal').click(function(e) {
                e.preventDefault();
                $('#modalBox').fadeIn(); // Show the modal box
            });

            // When user clicks anywhere outside of the modal, close it
            $(window).click(function(e) {
                if ($(e.target).is('.modal')) {
                    $('.modal').fadeOut();
                }
            });
        });
    </script>

</body>
</html>