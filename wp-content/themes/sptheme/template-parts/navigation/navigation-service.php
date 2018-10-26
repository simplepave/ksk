        <nav>
            <div class="icon-menu">
                <div class="sw-topper"></div>
                <div class="sw-bottom"></div>
                <div class="sw-footer"></div>
            </div>
<?php
    wp_nav_menu([
        'theme_location'  => 'service-menu',
        'container_class' => 'nav_block',
        'fallback_cb'     => '',
        'items_wrap'      => '<ul>%3$s</ul>',
        'depth'           => 1,
        'walker'          => new Service_Walker_Nav_Menu(),
    ]);
?>
        </nav>