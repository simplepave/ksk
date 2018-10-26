<?php

/**
 * 404 page
 */

get_header();

set_query_var('var_post_title', 'Ошибка 404');
set_query_var('var_breadcrumbs', []);
get_template_part('template-parts/parts/bread', 'crumbs');
?>
    <div class="our_partners">
        <div class="container">
            <div class="head_partners">Ой! Страница не найдена.</div>
        </div>
    </div>
    <?php get_template_part('template-parts/shop/shop', 'products'); ?>
    <div class="main_order">
        <a class="button_order popup" href="#free_consultation">Заказать бесплатную консультацию</a>
    </div>
<?php get_footer();