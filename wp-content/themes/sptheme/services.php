<?php

/**
 * Template name: Услуги
 */

if (get_query_var('shop-product'))
    get_template_part('template-parts/shop/shop', 'card');
else
    get_template_part('template-parts/shop/shop', 'catalog');