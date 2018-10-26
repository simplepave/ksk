<?php

/**
 * Template name: Отзывы
 */

if (get_query_var('reviews-more'))
    get_template_part('template-parts/reviews/reviews', 'more');
else
    get_template_part('template-parts/reviews/reviews', 'all');