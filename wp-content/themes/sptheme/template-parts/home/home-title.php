<?php

/**
 *
 */

$post = get_post(32);

?>
    <div class="main_title">
        <div class="head_title"><?php bloginfo('description'); ?></div>
        <?php echo $post->post_content; ?>
    </div>