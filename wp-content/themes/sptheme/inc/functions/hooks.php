<?php

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

/**
 *
 */

add_action('init', 'do_rewrite');

function do_rewrite() {
    add_rewrite_rule('^услуги-компании/([^/]*)/?$', 'index.php?page_id=53&shop-product=$matches[1]', 'top');
    add_rewrite_rule('^oтзывы/?([^/]*)?/?$', 'index.php?page_id=43&reviews-more=$matches[1]', 'top');

    add_filter('query_vars', function($vars) {
        $vars[] = 'shop-product';
        $vars[] = 'reviews-more';
        return $vars;
    });
}

/**
 *
 */

function shop_wp_title($title, $sep) {

    if (get_query_var('shop-product'))
        $title = product_data('post_title') . ' ' . $sep . ' ';

    return $title;
}

add_filter('wp_title', 'shop_wp_title', 10, 2);

/**
 *
 */

function sp_ajax_data() {
    wp_localize_script('sp', 'spAjax', ['url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('spAjax-nonce')]);
}

add_action('wp_enqueue_scripts', 'sp_ajax_data', 99);

if (wp_doing_ajax()) {
    add_action('wp_ajax_woo-order', 'woo_order_callback');
    add_action('wp_ajax_nopriv_woo-order', 'woo_order_callback');
    add_action('wp_ajax_order-write', 'order_write_callback');
    add_action('wp_ajax_nopriv_order-write', 'order_write_callback');
    add_action('wp_ajax_feedback', 'feedback_callback');
    add_action('wp_ajax_nopriv_feedback', 'feedback_callback');
}

function woo_order_callback() {
    if(!wp_verify_nonce($_POST['nonce_code'], 'spAjax-nonce')) exit();
    get_template_part('template-parts/shop/shop', 'mail');
    wp_die();
}

function order_write_callback() {
    if(!wp_verify_nonce($_POST['nonce_code'], 'spAjax-nonce')) exit();
    get_template_part('template-parts/mail/mail', 'order_write');
    wp_die();
}

function feedback_callback() {
    if(!wp_verify_nonce($_POST['nonce_code'], 'spAjax-nonce')) exit();
    get_template_part('template-parts/mail/mail', 'feedback');
    wp_die();
}

/**
 *
 */

add_filter('excerpt_length', function(){return 21;});
add_filter('excerpt_more', function($more){return ' ...';});

/**
 *
 */

add_filter('nav_menu_css_class', 'filter_function_name_8591', 10, 4);
function filter_function_name_8591($classes, $item, $args, $depth) {
    return [];
}

add_filter('nav_menu_item_id', 'filter_function_name_471', 10, 4);
function filter_function_name_471($menu_id, $item, $args, $depth) {
    return false;
}