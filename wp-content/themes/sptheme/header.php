<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <title><?php is_front_page() ? bloginfo('description') : wp_title('|', true, 'right') . bloginfo('name');?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
</head>
    <body <?php body_class(isset($var_body_class)? $var_body_class: ''); ?>>
        <header>
            <div class="container">
                <div class="row no-gutters justify-content-between align-items-start">
                    <div class="col-auto">
                        <a class="header_logo" href="<?php echo esc_url(home_url('/')); ?>"></a>
                    </div>
                    <div class="col align-self-center">
                        <div class="col-auto align-self-center">
                            <div class="header-info">
                                <div class="address"><?php echo option_address('<br />'); ?></div>
                                <div class="work_schedule">График работы: <?php echo esc_html(get_option('work_schedule', '')); ?></div>

                                <div class="phone">
                                    <a class="tel" href="tel:<?php echo href_tel(get_option('phone', '')); ?>"><?php echo esc_html(get_option('phone', '')); ?></a>
                                    <a class="popup button_call" href="#free_consultation">Заказать звонок</a>
                                </div>
                            </div>
                        </div>
<?php
if (has_nav_menu('header-menu'))
    get_template_part('template-parts/navigation/navigation', 'header');
?>
                    </div>
                </div>
            </div>
        </header>
<?php
if (has_nav_menu('service-menu'))
    get_template_part('template-parts/navigation/navigation', 'service');
?>