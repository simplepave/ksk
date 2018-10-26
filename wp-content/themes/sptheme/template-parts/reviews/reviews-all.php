<?php

/**
 *
 */

$post = get_post();

$args = [
    'number'  => 30,
    'post_id' => $post->ID,
    'status'  => 'approve',
];

$comments = get_comments($args);

get_header();

$breadcrumbs[] = [
    'title' => $post->post_title,
    'href'  => $post->post_name . '/',
];

set_query_var('var_breadcrumbs', $breadcrumbs);
get_template_part('template-parts/parts/bread', 'crumbs');
?>
    <div class="reviews">
        <div class="container">
<?php if ($comments) : ?>
            <div class="row no-gutters">
                <div class="reviews_slider owl-carousel">
<?php
foreach ($comments as $comment) :
    // $comment_href = get_comment_link($comment->comment_ID);
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
<?php
endif;
if ($otzivov_net = get_option('otzivov_net', '')) :
?>
            <a class="reviews_link" href="<?php echo $otzivov_net; ?>">otzivov.net</a>
<?php endif; ?>
        </div>
    </div>
<?php
get_template_part('template-parts/reviews/reviews', 'popup');
get_footer();