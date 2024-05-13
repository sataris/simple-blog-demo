<header>
    <?php include __DIR__.'/../components/notifications.php';?>
    <h1><?php echo $headerTitle; ?></h1>
        <form id="searchform" action="search.php" method="get">
            <input type="text" name="search" placeholder="Search post titles and body...">
            <button type="submit">Search</button>
        </form>
    </header>
    <style>
 .nav-right {
   margin-left: auto;
     display: flex;
 }
</style>

<nav style='display: flex; justify-content: flex-start;'>
    <a href="/index.php">Home</a>
    <div class="nav-right">
        <?php if (!$userAuthenticated) { ?>
        <a href="/login.php">Login</a>
        <a href="/register.php">Register</a>
        <?php } else { ?>
                <a>Hello <?php echo ucfirst($_SESSION['user_name']); ?></a>
        <a href="/create_post.php">Create New Post</a>
            <a href="/logout.php">Logout</a>
        <?php } ?>
    </div>
</nav>