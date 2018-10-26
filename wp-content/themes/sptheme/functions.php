<?php

/**
 * SimplePAVE
 * info@simplepave.ru
 */

/**
 *
 */

require 'classes/SP_Woo.php';
require 'classes/Header_Walker_Nav_Menu.php';
require 'classes/Service_Walker_Nav_Menu.php';

/**
 *
 */

add_filter('show_admin_bar', '__return_false');
remove_action('load-update-core.php', 'wp_update_themes');
add_filter('auto_update_theme', '__return_false');
add_filter('pre_site_transient_update_themes', '__return_null');
wp_clear_scheduled_hook('wp_update_themes');

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

function my_custom_woocommerce_theme_support() {
    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'my_custom_woocommerce_theme_support');

/**
 *
 */

function sp_add_role() {
    add_role('employee_role', 'Сотрудник', ['read' => true]);
}

/**
 *
 */

function sp_scripts() {// wp_dequeue_style ();
    wp_enqueue_style('styles', get_template_directory_uri().'/css/styles.css', array(), null);
    wp_enqueue_style('custom-media', get_template_directory_uri().'/css/media.css', array(), null);
    wp_enqueue_style('animate.min', get_template_directory_uri().'/css/animate.min.css', array(), null);
    wp_enqueue_style ('owl.carousel.min', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), null);
    wp_enqueue_style ('magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), null);

    if (get_query_var('shop-product')) {
        wp_enqueue_style('ion.rangeSlider', get_template_directory_uri().'/css/ion.rangeSlider.css', array(), null);
        wp_enqueue_style('ion.rangeSlider.skinFlat', get_template_directory_uri().'/css/ion.rangeSlider.skinFlat.css', array(), null);
    }

    wp_enqueue_style('bootstrap', get_template_directory_uri().'/css/bootstrap.css', array(), null);
    wp_enqueue_style('bootstrap-grid', get_template_directory_uri().'/css/bootstrap-grid.css', array(), null);

    wp_deregister_script('jquery');
    wp_enqueue_script( 'jquery', get_template_directory_uri() .'/js/jquery-2.0.3.min.js', array(), '2.0.3', false);

    wp_enqueue_script('jquery.inputmask.bundle', get_template_directory_uri() .'/js/jquery.inputmask.bundle.min.js', array(), '4.0.1', true);
    wp_enqueue_script('jquery.magnific-popup', get_template_directory_uri() .'/js/jquery.magnific-popup.js', array(), '0.9.4', true);

    if (get_query_var('shop-product')) {
        wp_enqueue_script('ion.rangeSlider', get_template_directory_uri() .'/js/ion.rangeSlider.min.js', array(), '2.2.0', true);
        wp_enqueue_script('calc', get_template_directory_uri() .'/js/calc.js', array(), false, true);
    }

    wp_enqueue_script('jquery.placeholder', get_template_directory_uri() .'/js/jquery.placeholder.min.js', array(), false, true);
    wp_enqueue_script('jquery.formstyler', get_template_directory_uri() .'/js/jquery.formstyler.js', array(), false, true);
    wp_enqueue_script('owl.carousel', get_template_directory_uri() .'/js/owl.carousel.js', array(), false, true);
    wp_enqueue_script('scripts', get_template_directory_uri() .'/js/scripts.js', array(), false, true);
    wp_enqueue_script('sp', get_template_directory_uri() .'/js/sp.js', array(), '0.1.0', true);
}

if(!is_admin())
    add_action('wp_enqueue_scripts', 'sp_scripts');

/**
 *
 */

add_action('after_setup_theme', 'sp_setup');

function sp_setup() {
    register_nav_menus([
        'header-menu'  => 'Меню в шапке',
        'service-menu' => 'Сервисное меню',
        'footer-menu'  => 'Меню в подвале',
    ]);
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

if (!function_exists('shop_data')) {
    function shop_data($item = false) {
        $post = get_post(53);
        return $item? $post->$item: $post;
    }
}

if (!function_exists('shop_product_data')) {
    function shop_product_data($item = false) {
        $args = [
            'post_type'      => 'product',
            'tax_query'      => [[
                'taxonomy'  => 'product_cat',
                'field'     => 'id',
                'terms'     => 19,
            ]],
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

add_action('admin_init', 'sp_settings_api_init');

function sp_settings_api_init() {
    register_setting('general', 'phone', 'sanitize_text_field');

    add_settings_field(
        'phone',
        '<label for="phone">Телефон</label>',
        'phone_field_html',
        'general'
    );

    register_setting('general', 'address', 'sanitize_text_field');

    add_settings_field(
        'address',
        '<label for="address">Адрес</label>',
        'address_field_html',
        'general'
    );

    register_setting('general', 'work_schedule', 'sanitize_text_field');

    add_settings_field(
        'work_schedule',
        '<label for="work_schedule">График работы</label>',
        'work_schedule_field_html',
        'general'
    );

    register_setting('general', 'vimeo', 'sanitize_text_field');

    add_settings_field(
        'vimeo',
        '<label for="vimeo">Vimeo</label>',
        'vimeo_field_html',
        'general'
    );

    register_setting('general', 'otzivov_net', 'sanitize_text_field');

    add_settings_field(
        'otzivov_net',
        '<label for="otzivov_net">otzivov.net</label>',
        'otzivov_net_field_html',
        'general'
    );

// ---------------

    register_setting('general', 'social_vk', 'sanitize_text_field');

    add_settings_field(
        'social_vk',
        '<label for="social_vk">VK</label>',
        'social_vk_field_html',
        'general'
    );

    register_setting('general', 'social_facebook', 'sanitize_text_field');

    add_settings_field(
        'social_facebook',
        '<label for="social_facebook">Facebook</label>',
        'social_facebook_field_html',
        'general'
    );

    register_setting('general', 'social_instagram', 'sanitize_text_field');

    add_settings_field(
        'social_instagram',
        '<label for="social_instagram">Instagram</label>',
        'social_instagram_field_html',
        'general'
    );

// ---------------

    register_setting('general', 'google_maps', 'sanitize_text_field');

    add_settings_field(
        'google_maps',
        '<label for="google_maps">Google Maps</label>',
        'google_maps_field_html',
        'general'
    );

    // register_setting('general', 'google_maps_lat', 'sanitize_text_field');

    // add_settings_field(
    //     'google_maps_lat',
    //     '<label for="google_maps_lat">Google Maps lat</label>',
    //     'google_maps_lat_field_html',
    //     'general'
    // );

    // register_setting('general', 'google_maps_lng', 'sanitize_text_field');

    // add_settings_field(
    //     'google_maps_lng',
    //     '<label for="google_maps_lng">Google Maps lng</label>',
    //     'google_maps_lng_field_html',
    //     'general'
    // );
}

function phone_field_html() {
    $value = get_option('phone', '');
    printf('<input type="text" id="phone" class="regular-text" name="phone" value="%s" />', esc_attr($value));
}

function address_field_html() {
    $value = get_option('address', '');
    printf('<input type="text" id="address" class="regular-text" name="address" value="%s" />', esc_attr($value));
}

function work_schedule_field_html() {
    $value = get_option('work_schedule', '');
    printf('<input type="text" id="work_schedule" class="regular-text" name="work_schedule" value="%s" />', esc_attr($value));
}

function vimeo_field_html() {
    $value = get_option('vimeo', '');
    printf('<input type="text" id="vimeo" class="regular-text" name="vimeo" value="%s" />', esc_attr($value));
}

function otzivov_net_field_html() {
    $value = get_option('otzivov_net', '');
    printf('<input type="text" id="otzivov_net" class="regular-text" name="otzivov_net" value="%s" />', esc_attr($value));
}

// ---------------

function social_vk_field_html() {
    $value = get_option('social_vk', '');
    printf('<input type="text" id="social_vk" class="regular-text" name="social_vk" value="%s" />', esc_attr($value));
}

function social_facebook_field_html() {
    $value = get_option('social_facebook', '');
    printf('<input type="text" id="social_facebook" class="regular-text" name="social_facebook" value="%s" />', esc_attr($value));
}

function social_instagram_field_html() {
    $value = get_option('social_instagram', '');
    printf('<input type="text" id="social_instagram" class="regular-text" name="social_instagram" value="%s" />', esc_attr($value));
}

// ---------------

function google_maps_field_html() {
    $value = get_option('google_maps', '');
    printf('<input type="text" id="google_maps" class="regular-text" name="google_maps" value="%s" />', esc_attr($value));
}

// function google_maps_lat_field_html() {
//     $value = get_option('google_maps_lat', '');
//     printf('<input type="text" id="google_maps_lat" class="regular-text" name="google_maps_lat" value="%s" />', esc_attr($value));
// }

// function google_maps_lng_field_html() {
//     $value = get_option('google_maps_lng', '');
//     printf('<input type="text" id="google_maps_lng" class="regular-text" name="google_maps_lng" value="%s" />', esc_attr($value));
// }

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
        if ($address = get_option('address', '')) {
            if ($tag) {
                $arr = explode('|', $address, 2);
                $output = '';

                foreach ($arr as $val) {
                    if (!empty($val))
                        $output .= '<' . $tag . '>' . $val . '</' . $tag . '>';
                }

                return $output;
            }

            return str_replace('|', $sep, $address);
        }

        return '';
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

add_action('show_user_profile', 'my_show_extra_profile_fields');
add_action('edit_user_profile', 'my_show_extra_profile_fields');
add_action('user_new_form', 'my_show_extra_profile_fields');

function my_show_extra_profile_fields($user) { ?>
<table class="form-table">
<tr>
    <th><label for="wp_user_phone">Телефон</label></th>
    <td>
        <input type="text" name="wp_user_phone" id="wp_user_phone" value="<?php echo esc_attr(get_the_author_meta('wp_user_phone', $user->ID)); ?>" class="regular-text" /><br />
        <span class="description">Пожалуйста, введите свой номер телефона.</span>
    </td>
</tr>
</table>
<?php }

add_action('personal_options_update', 'my_save_extra_profile_fields');
add_action('edit_user_profile_update', 'my_save_extra_profile_fields');
add_action('user_register', 'my_save_extra_profile_fields');

function my_save_extra_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) return false;
    update_user_meta($user_id, 'wp_user_phone', $_POST['wp_user_phone']);
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