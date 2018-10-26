<?php

/**
 *
 */

$id = get_query_var('reviews-more')? (int)get_query_var('reviews-more'): 0;

$comm = get_comment($id = $id);

if (!$comm)
    page_404();

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
    <div class="reviews_more">
        <div class="container">
            <div class="row no-gutters justify-content-between">
                <div class="left_col">
<?php if ($comments) : ?>
                    <div class="reviews_more_slider owl-carousel">
                        <div class="item">
<?php
$num = 0;
foreach ($comments as $comment) :
    if ($num && !($num % 2))
        echo '</div><div class="item">';

    $num++;
    $comment_href = esc_url(home_url($post->post_name . '/' . $comment->comment_ID . '/'));
    $comment_content = wp_trim_words($comment->comment_content, 10, ' ...');
?>
                            <div class="item_bg">
                                <div class="head_slider"><?php echo $comment->comment_author; ?></div>
                                <p><?php echo $comment_content; ?></p>
                                <a href="<?php echo $comment_href; ?>">Читать еще</a>
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
                <div class="right_col">
                    <div class="head_slider"><?php echo $comm->comment_author; ?></div>
                    <div class="text_reviews_more">
                        <p><?php echo $comm->comment_content; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_template_part('template-parts/reviews/reviews', 'popup');
get_footer();