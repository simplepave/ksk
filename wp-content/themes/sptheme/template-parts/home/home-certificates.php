<?php

/**
 *
 */

$post = get_post(33);
$ids = sp_gallery($post->post_content);

if ($ids) :
    $images = get_posts([
        'posts_per_page' => -1,
        'post__in'       => $ids,
        'post_type'      => 'attachment',
        'orderby'        => 'post__in',
    ]);
?>
    <div class="certificates">
        <div class="container">
            <div class="head_certificates"><?php echo $post->post_title; ?></div>
            <div class="row no-gutters justify-content-between popup_gallery">
<?php
$num = 0;
foreach ($images as $img) :
    $num++;

    if (($num % 2)) {
        $src = $img->guid;
        continue;
    }
?>
                <div class="item_certificates">
                    <a href="<?php echo $img->guid; ?>">
                        <img src="<?php echo $src; ?>" alt="">
                        <span></span>
                    </a>
                </div>
<?php
endforeach;
?>
            </div>
        </div>
    </div>
<?php endif;