<?php

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

/**
 *
 */

if (!function_exists('page_404')) {
    function page_404() {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        get_template_part( 404 );
        exit();
    }
}

/**
 *
 */

if (!function_exists('image_title')) {
    function image_title($id) {
        $post = get_post($id);
        echo isset($post->post_title)? $post->post_title: '';
    }
}

/**
 *
 */

if (!function_exists('shop_data')) {
    function shop_data($item = false) {
        $post = get_post(53);
        return $item? $post->$item: $post;
    }
}

if (!function_exists('shop_product_data')) {
    function shop_product_data($item = false, $cat_id = 19) {
        $args = [
            'post_type'      => 'product',
            'tax_query'      => [[
                'taxonomy'  => 'product_cat',
                'field'     => 'id',
                'terms'     => $cat_id,
            ]],
            // 'product_tag'    => 'display',
            'post_status'    => 'publish',
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'posts_per_page' => -1,
        ];

        $query = new WP_Query($args);
        wp_reset_query();
        $posts = $query->posts;

        if ($item == 'ids')
            foreach ($posts as $post) {
                $ids[$post->ID] = $post->post_title;
            }

        return $item == 'ids'? $ids: $posts;
    }
}

/**
 *
 */

if (!function_exists('product_data')) {
    function product_data($item = false) {

        $query = new WP_Query([
                'name'           => get_query_var('shop-product')?: '',
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'posts_per_page' => 1
            ]);
        wp_reset_query();
        $product = $query->posts[0];

        return $item? $product->$item: $product;
    }
}

/**
 *
 */

if (!function_exists('href_tel')) {
    function href_tel($tel) {
        return esc_html(preg_replace('/\(|\)|\s+|\-/', '', $tel));
    }
}

/**
 *
 */

if (!function_exists('privacy_policy')) {
    function privacy_policy() {
        if ($id = get_option('wp_page_for_privacy_policy', '')) {
            $post = get_post((int)$id);

            return $post? $post->post_name: '';
        }

        return '';
    }
}

/**
 *
 */

if (!function_exists('option_address')) {
    function option_address($sep = ' ', $tag = false) {
        $output = '';

        if ($address = get_option('address', '')) {
            $arr = explode(', ', $address, 2);
            $arr[0] .= ',';

            if ($tag)
                foreach ($arr as $val) {
                    if (!empty($val))
                        $output .= '<' . $tag . '>' . $val . '</' . $tag . '>';
                }

            else $output = $arr[0] . $sep . $arr[1];
        }

        return $output;
    }
}

/**
 *
 */

if (!function_exists('sp_gallery')) {
    function sp_gallery($content) {
        if (false === strpos($content, '['))
            return false;

        preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches);

        if (!in_array('gallery', $matches[1]))
            return false;

        $pattern = get_shortcode_regex(['gallery']);
        $content = preg_match('/' . $pattern . '/', $content, $matches);
        $attr = shortcode_parse_atts($matches[3]);

        $ids = explode(',', $attr['ids']);
        return array_map('trim', $ids);
    }
}

/**
 *
 */

if (!function_exists('mb_strtolower')) {
    function mb_strtolower($str, $encoding = 'UTF-8') {
        return strtolower($str);
    }
}

/**
 *
 */

if (!function_exists('array_key_last')) {
    function array_key_last($array) {
        if (!is_array($array) || empty($array))
            return NULL;

        return array_keys($array)[count($array)-1];
    }
}