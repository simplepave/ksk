<?php

/**
 *
 */

wp_reset_postdata();
$post = get_post();

if (!isset($var_post_title))
    $post_title = $post->post_title;
else $post_title = $var_post_title;

if (!isset($var_breadcrumbs))
    $breadcrumbs[] = [
        'title' => $post->post_title,
        'href'  => esc_url(home_url($post->post_name . '/')),
    ];
else $breadcrumbs = $var_breadcrumbs;

?>
    <div class="title">
        <div class="container">
            <div class="row_title">
                <div class="head_article"><?php echo $post_title; ?></div>
            </div>
        </div>
    </div>
    <div class="bread-crumbs">
        <div class="container">
            <div class="row no-gutters">
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php echo get_the_title(get_option('page_on_front')); ?></a></li>
<?php
$last_key = array_key_last($breadcrumbs);
foreach($breadcrumbs as $key => $breadcrumb) :
    $title = $breadcrumb['title'];
    $href = esc_url(home_url($breadcrumb['href']));
    $class = $last_key == $key? ' class="active"': '';
?>
                    <li<?php echo $class; ?>><a href="<?php echo $href; ?>"><?php echo $title; ?></a></li>
<?php
endforeach;
?>
                </ul>
            </div>
        </div>
    </div>