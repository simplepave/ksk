<?php

/**
 * product
 */

$products = shop_product_data();

if ($products) :
    $shop_data = shop_data();
    $left_right = is_front_page();

    // $post = get_post(66);
    // $post_image_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full')[0];
?>
    <div class="services">
        <div class="container">
<?php
$services_block = <<<BLOCK
    <div class="services_block">
        <div class="why_we_table">$shop_data->post_title</div>
    </div>
BLOCK;

foreach ($products as $key => $product) :
    $card_url = esc_url(home_url($shop_data->post_name . '/' . $product->post_name . '/'));
    $product_image_full = wp_get_attachment_image_src(get_post_thumbnail_id($product->ID), 'full')[0];

    if (!$key) :
?>
            <div class="row no-gutters justify-content-between top_row">
                <?php if (!$left_right) echo $services_block; ?>
                <div class="services_row">
<?php endif; ?>
                    <div class="item_services">
                        <a href="<?php echo $card_url; ?>">
                            <img src="<?php echo $product_image_full; ?>" alt="">
                            <p><?php echo $product->post_title; ?></p>
                        </a>
                    </div>
<?php if (!$key) : ?>
                </div>
                <?php if ($left_right) echo $services_block; ?>
            </div>
            <div class="row no-gutters justify-content-between services_list">
<?php
endif;
endforeach;
/*
                <div class="item_services">
                    <a href="<?php echo esc_url(home_url($post->post_name . '/')); ?>">
                        <img src="<?php echo $post_image_full; ?>" alt="">
                        <p><?php echo $post->post_title; ?></p>
                    </a>
                </div>
*/
?>
            </div>
        </div>
    </div>
<?php endif;