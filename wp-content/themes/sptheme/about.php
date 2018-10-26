<?php

/**
 * Template name: О нас
 */

$post = get_post();
$post_image_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full')[0];

get_header();

$breadcrumbs[] = [
    'title' => $post->post_title,
    'href'  => $post->post_name . '/',
];

set_query_var('var_breadcrumbs', $breadcrumbs);
get_template_part('template-parts/parts/bread', 'crumbs');
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
<?php
get_template_part('template-parts/home/home', 'video');
get_template_part('template-parts/home/home', 'partners');
get_template_part('template-parts/home/home', 'employees');
get_template_part('template-parts/home/home', 'certificates');

get_footer();