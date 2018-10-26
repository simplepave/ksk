<?php

/**
 *
 */

$post_id = isset($post->ID)? $post->ID: 0;
$post_arr = [49];

$post = get_post(21);
$ids = sp_gallery($post->post_content);

if ($ids) {
    $images = get_posts([
        'posts_per_page' => -1,
        'post__in'       => $ids,
        'post_type'      => 'attachment',
        'orderby'        => 'post__in',
    ]);

    foreach ($images as $img) {
        $src = $img->guid;
        $t = esc_attr($img->post_title);
        $title = ($t && false === strpos($src, $t))? $t: '';

        $gallery .= '<div class="item"><img src="'. $src .'" alt="'. $title .'"></div>';
    }
}

if (isset($gallery)) :
?>
    <div class="our_partners">
        <div class="container">
<?php if (!in_array($post_id, $post_arr)) : ?>
            <div class="head_partners"><?php echo $post->post_title; ?></div>
<?php endif; ?>
            <div class="row no-gutters">
                <div class="our_partners_slider owl-carousel">
                    <?php echo $gallery; ?>
                    <?php echo $gallery; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif;