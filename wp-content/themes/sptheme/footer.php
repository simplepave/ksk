<?php

/**
 * Footer
 */

?>
    <?php get_template_part('template-parts/form/form', 'free_consultation'); ?>
    <footer>
        <div class="container">
            <div class="row no-gutters justify-content-between">
                <div class="row_footer">
<?php
if (has_nav_menu('footer-menu'))
    get_template_part('template-parts/navigation/navigation', 'footer');
?>
                    <div class="logo_block">
                        <a class="footer_logo" href="<?php echo esc_url(home_url('/')); ?>"></a>
                        <p>&copy; <?php echo '2018' . (('2018' != date('Y')) ? '-' . date('Y') : '');?> «<?php echo esc_html(get_option('blogname', '')); ?>»</p>
                    </div>
                </div>
                <ul class="social">
<?php if ($social = get_option('social_vk', '')) : ?>
                    <li><a href="<?php echo $social; ?>"></a></li>
<?php endif;
if ($social = get_option('social_facebook', '')) : ?>
                    <li><a href="<?php echo $social; ?>"></a></li>
<?php endif;
if ($social = get_option('social_instagram', '')) : ?>
                    <li><a href="<?php echo $social; ?>"></a></li>
<?php endif; ?>
                </ul>
                <div class="phone_address">
                    <a class="footer_phone" href="tel:<?php echo href_tel(get_option('phone', '')); ?>"><?php echo esc_html(get_option('phone', '')); ?></a>
                    <div class="footer_address"><?php echo option_address(); ?></div>
                </div>
            </div>
        </div>
    </footer>
<?php wp_footer(); ?>
</body></html>