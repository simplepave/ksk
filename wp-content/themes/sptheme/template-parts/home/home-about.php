<?php

/**
 *
 */

$post = get_post(11);
$post_image_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full')[0];

?>
    <div class="main_about">
        <div class="container">
            <div class="row no-gutters justify-content-between align-items-center">
                <div class="img_ubout"><img src="<?php echo $post_image_full; ?>" alt=""></div>
                <div class="text_about">
                    <div class="head_about"><?php bloginfo('description'); ?></div>
                    <?php echo $post->post_content; ?>
                </div>
            </div>
        </div>
    </div>