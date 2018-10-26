<?php
    wp_nav_menu([
        'theme_location'  => 'footer-menu',
        'container_class' => 'footer_nav',
        'fallback_cb'     => '',
        'items_wrap'      => '<ul>%3$s</ul>',
        'depth'           => 1,
    ]);