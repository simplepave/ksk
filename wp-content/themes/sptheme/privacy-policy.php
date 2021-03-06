<?php

/**
 * Template name: Политика конфиденциальности
 */

$post = get_post();

get_header();

$breadcrumbs[] = [
    'title' => $post->post_title,
    'href'  => $post->post_name . '/',
];

set_query_var('var_breadcrumbs', $breadcrumbs);
get_template_part('template-parts/parts/bread', 'crumbs');
?>
    <div class="main_text">
        <div class="container">
            <div class="row no-gutters"><?php echo $post->post_content; ?></div>
        </div>
    </div>
<?php get_footer();