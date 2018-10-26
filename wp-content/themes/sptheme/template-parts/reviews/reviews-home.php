<?php

/**
 *
 */

$post = get_post(43);

$args = [
    'number'  => 10,
    'post_id' => $post->ID,
    'status'  => 'approve',
];

$comments = get_comments($args);
if ($comments) :
?>
    <div class="reviews">
        <div class="container">
            <div class="head_reviews">отзывы наших клиентов</div>
            <div class="row no-gutters">
                <div class="reviews_slider owl-carousel">
<?php
foreach ($comments as $comment) :
    $comment_href = esc_url(home_url($post->post_name . '/' . $comment->comment_ID . '/'));
    $comment_content = wp_trim_words($comment->comment_content, 23, ' ...');
?>
                    <div class="item">
                        <div class="head_slider"><?php echo $comment->comment_author; ?></div>
                        <p><?php echo $comment_content; ?><a href="<?php echo $comment_href; ?>">Читать еще</a></p>
                    </div>
<?php endforeach; ?>
                </div>
            </div>
<?php if ($otzivov_net = get_option('otzivov_net', '')) : ?>
            <a class="reviews_link" href="<?php echo $otzivov_net; ?>">otzivov.net</a>
<?php endif; ?>
        </div>
    </div>
<?php endif;