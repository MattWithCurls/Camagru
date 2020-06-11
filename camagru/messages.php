<?php

        session_start();

        if (empty($_SESSION['messages'])){
            return;
        }

        $messages = $_SESSION['messages'];
        unset($_SESSION['messages']);
 ?>
<ul>
    <?php foreach ($messages as $messages): ?>
        <li><?php echo $messages; ?></li>
        <?php endforeach?>
</ul>