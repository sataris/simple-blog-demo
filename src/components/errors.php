<?php
if (!empty($_SESSION['errors'])) { ?>
    <ul>
        <?php foreach($_SESSION['errors'] as $error) { ?>
            <li style="color: red"><?php echo $error;?></li>
        <?php } ?>
    </ul>
<?php
    unset($_SESSION['errors']);
} ?>