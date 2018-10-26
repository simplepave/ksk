<?php

/**
 *
 */

$product = product_data();

if (!$product)
    page_404();

$shop_data = shop_data();
// set_query_var('var_product_id', $product->ID);
$product_image_full = wp_get_attachment_image_src(get_post_thumbnail_id($product->ID), 'full')[0];

get_header();

$breadcrumbs[] = [
    'title' => $shop_data->post_title,
    'href'  => $shop_data->post_name . '/',
];

$breadcrumbs[] = [
    'title' => $product->post_title,
    'href'  => $shop_data->post_name . '/' . $product->post_name . '/',
];

set_query_var('var_post_title', $product->post_title);
set_query_var('var_breadcrumbs', $breadcrumbs);
get_template_part('template-parts/parts/bread', 'crumbs');
?>
    <div class="hypothec">
        <div class="container">
            <div class="row no-gutters justify-content-between">
                <div class="services_row">
                    <div class="item_services">
                        <a href="<?php echo esc_url(home_url($shop_data->post_name.'/'.$product->post_name.'/')); ?>">
                            <img src="<?php echo $product_image_full; ?>" alt="">
                            <p><?php echo $product->post_title; ?></p>
                        </a>
                    </div>
                </div>
                <div class="hypothec_text">
                    <?php echo $product->post_content; ?>
                </div>
            </div>
        </div>
        <div class="calculator_wrap">
            <div class="container">
                <div class="head_calculator">кредитный калькулятор</div>
                <div class="row no-gutters">
                    <div class="calculator">
                        <div class="row no-gutters justify-content-between row_calculator">
                            <div class="input_count">
                                <p>Сумма кредита</p>
                                <input class="js-price" value="10000">
                            </div>
                            <div class="row_range">
                                <input type="text" id="tabSlider1">
                            </div>
                        </div>
                        <div class="row no-gutters justify-content-between row_calculator">
                            <div class="input_count">
                                <p>Срок кредита</p>
                                <input class="js-fee" value="10">
                            </div>
                            <div class="row_range">
                                <input type="text" id="tabSlider3">
                            </div>
                        </div>
                        <div class="row no-gutters justify-content-between row_calculator">
                            <div class="input_count">
                                <p>Ставка</p>
                                <input class="js-p-percent" value="2">
                            </div>
                            <div class="row_range">
                                <input type="text" id="tabSlider7">
                            </div>
                        </div>
                        <div class="row no-gutters justify-content-between row_calculator">
                            <div class="input_count">
                                <p>Ежемесячный платеж</p>
                                <input type="text" value="123 000 руб.">
                            </div>
                            <div class="row_range">
                                <input class="calculator_but" type="button" value="Оставить заявку"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php get_template_part('template-parts/home/home', 'why_we'); ?>
    <?php get_template_part('template-parts/home/home', 'certificates'); ?>
    <div class="main_order">
        <a class="button_order popup" href="#free_consultation">Заказать бесплатную консультацию</a>
    </div>
    <div class="main_text">
        <div class="container">
            <div class="row no-gutters"><?php echo $product->post_excerpt; ?></div>
        </div>
    </div>
<?php get_footer();