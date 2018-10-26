<?php

/**
 * Template name: Контакты
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
        <div class="contacts">
            <div class="container">
                <div class="row no-gutters justify-content-between">
                    <div class="contacts_item">
                        <div class="row_flex row_contacts">
                            <div class="contacts_icon"><img src="<?php echo esc_url(home_url('wp-content/uploads/2018/10/icon1.png')); ?>" alt=""></div>
                            <div class="contacts_text">
                                <a href="tel:<?php echo href_tel(get_option('phone', '' )); ?>"><?php echo esc_html(get_option('phone', '')); ?></a>
                            </div>
                        </div>
                        <div class="row_flex row_contacts">
                            <div class="contacts_icon"><img src="<?php echo esc_url(home_url('wp-content/uploads/2018/10/icon2.png')); ?>" alt=""></div>
                            <div class="contacts_text">
                                <?php echo option_address(false, 'p'); ?>
                            </div>
                        </div>
                        <div class="row_flex row_contacts">
                            <div class="contacts_icon"><img src="<?php echo esc_url(home_url('wp-content/uploads/2018/10/icon3.png')); ?>" alt=""></div>
                            <div class="contacts_text">
                                <p>График работы:</p>
                                <p><?php echo esc_html(get_option('work_schedule', '')); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="map">
                        <iframe src="<?php echo esc_html(get_option('google_maps', '')); ?>" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <div class="bottom_text">
                <div class="container">
                    <div class="row no-gutters justify-content-between">
                        <div class="text_long"><?php echo $post->post_content; ?></div>
                        <div class="text_small">
                            <p>Наш отдел по обслуживанию клиентов работает</p>
                            <p><?php echo esc_html(get_option('work_schedule', '')); ?>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php get_template_part('template-parts/home/home', 'employees'); ?>
<?php get_footer();