<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 *
 */

if (!class_exists('SP_Woo')) :

class SP_Woo {

    /**
     *
     */

    public function __construct(){}

    /**
     *
     */

    public function create_order_woo($data = false){
        $data = [
            'name'       => isset($_POST['author'])? $_POST['author']: 'No name',
            'email'      => $_POST['email']?: '',
            'product_id' => is_numeric($_POST['product_id'])? $_POST['product_id']: 0,
            'comment'    => isset($_POST['comment'])? $_POST['comment']: '',
        ];

        $address = [
            'first_name' => $data['name'],
            'last_name'  => '',
            'company'    => '',
            'email'      => $data['email'],
            'phone'      => '',
            'address_1'  => '',
            'address_2'  => '',
            'city'       => '',
            'state'      => '',
            'postcode'   => '',
            'country'    => ''
        ];

        $order = wc_create_order();

        if ($data['comment'])
            update_post_meta($order->id, 'comment', sanitize_text_field($data['comment']));

        $product = wc_get_product($data['product_id']);
        $order->add_product($product, 1);

        $order->set_address($address, 'billing');
        // $order->set_address($address, 'shipping');
        $order->update_status('completed', _x('Completed', 'Order status', 'woocommerce'));
        $order->calculate_totals();
        $order->save();

        if ($order->id)
            $response['success'] = 'Ваш заказ принят!';
        else
            $response['error'] = '<strong>Ошибка</strong>, обратитесь к администратору.';

        return $response;
    }
}

endif;