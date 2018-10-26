<?php

/**
 *
 */

wp_reset_postdata();
$post = get_post();

?>
    <div class="main_text">
        <div class="container">
            <div class="row no-gutters">
                <?php echo $post->post_content; ?>
            </div>
        </div>
    </div>