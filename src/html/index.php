<?php
use SimpleDemoBlog\Models\Post;

include(__DIR__.'/../components/dependencies.php');
$pageTitle = 'Simple Blog';
$headerTitle = 'Welcome to Simple Blog';
include(__DIR__.'/../components/auth.php');

$limit = 5;  // number of posts per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$total_posts = count(Post::all()); // Get total count of posts

$total_pages = ceil($total_posts / $limit); // calculate total pages

$posts = Post::pagination($start,$limit);
include(__DIR__.'/../components/header.php');
include(__DIR__.'/../components/navbar.php');
?>
<body>
<main>
    <?php if (!empty($posts)) {
        foreach ($posts as $post) {
            ?>

            <article>
                <h2><a href="post.php?id=<?php echo $post->getId(); ?>"><?php echo $post->getTitle(); ?></a></h2>
                <p><?php echo $post->getBody(); ?></p>
                <p>Published on:
                    <time datetime="<?php echo $post->getCreated_At()->format('Y-m-d H:i:s'); ?>"><?php echo $post->getCreated_At()->format('F j, Y'); ?></time>
                </p>
            </article>
        <?php } ?>
    <div class="pagination-wrap">
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <a href="?page=<?php echo $i; ?>" class="<?php if ($page == $i) {
                echo 'active-link';
            } ?>"><?php echo $i; ?></a>
        <?php }
        } else { ?>
            <article>
                <h2>Start Blogging today!</h2>
                <p>No blog posts yet!</p>
            </article>

        <?php } ?>
    </div>
</main>

<?php include __DIR__ .'../../components/footer.php'; ?>



</body>
</html>