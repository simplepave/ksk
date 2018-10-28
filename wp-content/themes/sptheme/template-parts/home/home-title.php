<?php

/**
 *
 */

$post = get_post(32);
$content = $post? ($post->post_content?: ''): '';

?>
    <div class="main_title">
        <?php echo $content; ?>
    </div>