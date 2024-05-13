<?php
if (!empty($_SESSION['notifications'])) { ?>
    <section style="width: 100%; position: fixed; background-color:  navy; color: white;">
        <?php foreach($_SESSION['notifications'] as $notification) { ?>
        <span>
        <?php echo $notification . PHP_EOL; ?>     </span>
        <?php } ?>
    </section>
<?php
    unset($_SESSION['notifications']);
} ?>