<?php

/**
 *
 */

$post = get_post(32);
$content = $post? ($post->post_content?: ''): '';

?>
    <div class="main_title">
        <div class="head_title">Ипотека от 8,99%</div>
        <?php echo $content; ?>
    </div>