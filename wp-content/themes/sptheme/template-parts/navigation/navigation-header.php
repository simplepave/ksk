<?php
    wp_nav_menu([
        'theme_location'  => 'header-menu',
        'container_class' => 'col-auto',
        'fallback_cb'     => '',
        'items_wrap'      => '<div class="nav_header">%3$s</div>',
        'depth'           => 1,
        'walker'          => new Header_Walker_Nav_Menu(),
    ]);