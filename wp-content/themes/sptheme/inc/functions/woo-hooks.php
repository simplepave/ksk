<?php

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

/**
 *
 */

function my_custom_woocommerce_theme_support() {
    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'my_custom_woocommerce_theme_support');

/**
 * https://gist.github.com/DevinWalker/7621777
 */

if (!is_woocommerce() && !is_cart() && !is_checkout()) {
    // add_filter('woocommerce_enqueue_styles', '__return_false');
    remove_action('wp_enqueue_scripts', [WC_Frontend_Scripts::class, 'load_scripts']);
    remove_action('wp_print_scripts', [WC_Frontend_Scripts::class, 'localize_printed_scripts'], 5);
    remove_action('wp_print_footer_scripts', [WC_Frontend_Scripts::class, 'localize_printed_scripts'], 5);
}

/**
 *
 */

function shop_redirect() {
    $request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = explode('/', trim($request,'/'));

    $url = ['shop', 'product', 'product-category', 'my-account'];

    if(in_array($path[0], $url)) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        get_template_part(404);
        exit();
    }
}

add_action('template_redirect', 'shop_redirect', 1);

/**
 *
 */

function woo_admin_order_meta($order) {
    if ($comment = get_post_meta($order->id, 'comment', true))
        echo '<p><strong>Комментарий:</strong> ' . $comment . '</p>';
}

add_action('woocommerce_admin_order_data_after_billing_address', 'woo_admin_order_meta', 10, 1);

function custom_woocommerce_get_order_item_totals($total_rows, $order, $tax_display) {
    if(is_wc_endpoint_url()) return $total_rows;
    unset($total_rows['cart_subtotal']);
    unset($total_rows['order_total']);
    return $total_rows;
}

add_filter('woocommerce_get_order_item_totals', 'custom_woocommerce_get_order_item_totals', 10, 3);

function custom_woocommerce_email_order_meta_fields($fields, $sent_to_admin, $order) {

    $items = $order->get_items();
    foreach ($items as $item) {
        $product_name = $item->get_name();
        $product_id = $item->get_product_id();

        $fields['product_' . $product_id] = [
            'label' => 'Услуга',
            'value' => $product_name,
        ];
    }

    if ($comment = get_post_meta($order->id, 'comment', true))
        $fields['comment'] = [
            'label' => 'Комментарий',
            'value' => $comment,
        ];

    return $fields;
}

add_filter('woocommerce_email_order_meta_fields', 'custom_woocommerce_email_order_meta_fields', 10, 3);

function so_39251827_remove_order_details($order, $sent_to_admin, $plain_text, $email){
    $mailer = WC()->mailer();
    remove_action('woocommerce_email_order_details', array($mailer, 'order_details'), 10, 4);
}

add_action('woocommerce_email_order_details', 'so_39251827_remove_order_details', 5, 4);