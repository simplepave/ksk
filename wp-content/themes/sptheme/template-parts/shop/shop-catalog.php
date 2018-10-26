<?php

/**
 *
 */

$category = get_categories([
        'taxonomy'   => 'product_cat',
        'include'    => '19',
    ])[0];

if (!$category)
    page_404();

$shop_data = shop_data();

get_header();

$breadcrumbs[] = [
    'title' => $shop_data->post_title,
    'href'  => $shop_data->post_name . '/',
];

set_query_var('var_breadcrumbs', $breadcrumbs);
get_template_part('template-parts/parts/bread', 'crumbs');
get_template_part('template-parts/shop/shop', 'products');
?>
    <div class="main_order">
        <a class="button_order popup" href="#free_consultation">Заказать бесплатную консультацию</a>
    </div>
    <div class="company_text">
        <div class="container">
            <div class="row no-gutters">
                <?php echo $shop_data->post_content; ?>
            </div>
        </div>
    </div>
<?php get_footer();