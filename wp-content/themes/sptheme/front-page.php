<?php

/**
 * Front page
 */

get_header();

get_template_part('template-parts/home/home', 'title');
get_template_part('template-parts/home/home', 'about');
get_template_part('template-parts/home/home', 'why_we');
get_template_part('template-parts/home/home', 'video');
get_template_part('template-parts/shop/shop', 'products');

?>
    <div class="main_order">
        <a class="button_order popup" href="#free_consultation">Заказать бесплатную консультацию</a>
    </div>
<?php

get_template_part('template-parts/home/home', 'partners');
get_template_part('template-parts/home/home', 'employees');
get_template_part('template-parts/home/home', 'certificates');
get_template_part('template-parts/reviews/reviews', 'home');
get_template_part('template-parts/home/home', 'content');

get_footer();