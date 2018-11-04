<?php

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

/**
 *
 */

require 'inc/classes/SP_Woo.php';
require 'inc/classes/SP_tinkoff.php';
require 'inc/classes/Header_Walker_Nav_Menu.php';
require 'inc/classes/Service_Walker_Nav_Menu.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
require 'inc/classes/SP_Validation.php';

/**
 *
 */

require 'inc/functions/helpers.php';
require 'inc/functions/hooks.php';
require 'inc/functions/woo-hooks.php';

/**
 *
 */

add_filter('show_admin_bar', '__return_false');
remove_action('load-update-core.php', 'wp_update_themes');
add_filter('auto_update_theme', '__return_false');
add_filter('pre_site_transient_update_themes', '__return_null');
wp_clear_scheduled_hook('wp_update_themes');

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
    wp_enqueue_style('styles', get_template_directory_uri().'/assets/css/styles.css', array(), null);
    wp_enqueue_style('custom-media', get_template_directory_uri().'/assets/css/media.css', array(), null);
    wp_enqueue_style('animate.min', get_template_directory_uri().'/assets/css/animate.min.css', array(), null);
    wp_enqueue_style ('owl.carousel.min', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), null);
    wp_enqueue_style ('magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css', array(), null);

    if (get_query_var('shop-product')) {
        wp_enqueue_style('ion.rangeSlider', get_template_directory_uri().'/assets/css/ion.rangeSlider.css', array(), null);
        wp_enqueue_style('ion.rangeSlider.skinFlat', get_template_directory_uri().'/assets/css/ion.rangeSlider.skinFlat.css', array(), null);
    }

    wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/css/bootstrap.css', array(), null);
    wp_enqueue_style('bootstrap-grid', get_template_directory_uri().'/assets/css/bootstrap-grid.css', array(), null);

    wp_deregister_script('jquery');
    wp_enqueue_script( 'jquery', get_template_directory_uri() .'/assets/js/jquery-2.0.3.min.js', array(), '2.0.3', false);

    wp_enqueue_script('jquery.inputmask.bundle', get_template_directory_uri() .'/assets/js/jquery.inputmask.bundle.min.js', array(), '4.0.1', true);
    wp_enqueue_script('jquery.magnific-popup', get_template_directory_uri() .'/assets/js/jquery.magnific-popup.js', array(), '0.9.4', true);

    if (get_query_var('shop-product')) {
        wp_enqueue_script('ion.rangeSlider', get_template_directory_uri() .'/assets/js/ion.rangeSlider.min.js', array(), '2.2.0', true);
        wp_enqueue_script('calc', get_template_directory_uri() .'/assets/js/calc.js', array(), false, true);
    }

    wp_enqueue_script('jquery.placeholder', get_template_directory_uri() .'/assets/js/jquery.placeholder.min.js', array(), false, true);
    wp_enqueue_script('jquery.formstyler', get_template_directory_uri() .'/assets/js/jquery.formstyler.js', array(), false, true);
    wp_enqueue_script('owl.carousel', get_template_directory_uri() .'/assets/js/owl.carousel.js', array(), false, true);
    wp_enqueue_script('scripts', get_template_directory_uri() .'/assets/js/scripts.js', array(), false, true);
    wp_enqueue_script('sp', get_template_directory_uri() .'/assets/js/sp.js', array(), '0.1.0', true);
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