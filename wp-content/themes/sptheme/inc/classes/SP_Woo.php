<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
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

    public function create_order_woo($data = false, $status = 'pending') {
        $data = [
            'name'       => isset($_POST['author'])? $_POST['author']: 'No name',
            'email'      => isset($_POST['email'])? $_POST['email']: '',
            'phone'      => isset($_POST['phone'])? $_POST['phone']: '',
            'product_id' => isset($_POST['product_id']) && is_numeric($_POST['product_id'])? $_POST['product_id']: 0,
            'comment'    => isset($_POST['comment'])? $_POST['comment']: '',
        ];

        if ($data['product_id']) {
            $address = [
                'first_name' => $data['name'],
                'last_name'  => '',
                'company'    => '',
                'email'      => $data['email'],
                'phone'      => $data['phone'],
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
            $order->update_status($status); // completed
            $order->calculate_totals();
            $order->save();

            if ($order->id)
                return ['success' => 'Ваш заказ принят!', 'order_id' => $order->id];
        }

        return $response['error'] = '<strong>Ошибка</strong>, обратитесь к администратору.';
    }
}

endif;