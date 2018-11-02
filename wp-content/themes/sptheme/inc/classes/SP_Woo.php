<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

if (!class_exists('SP_Woo')) :

class SP_Woo {

    private $data = false;

    /**
     *
     */

    public function __construct()
    {
        $this->data = [
            'first_name' => isset($_POST['first_name'])? $_POST['first_name']: 'No name',
            'last_name'  => isset($_POST['last_name'])? $_POST['last_name']: '',
            'company'    => isset($_POST['company'])? $_POST['company']: '',
            'email'      => isset($_POST['email'])? $_POST['email']: '',
            'phone'      => isset($_POST['phone'])? $_POST['phone']: '',
            'address_1'  => isset($_POST['address_1'])? $_POST['address_1']: '',
            'address_2'  => isset($_POST['address_2'])? $_POST['address_2']: '',
            'city'       => isset($_POST['city'])? $_POST['city']: '',
            'state'      => isset($_POST['state'])? $_POST['state']: '',
            'postcode'   => isset($_POST['postcode'])? $_POST['postcode']: '',
            'country'    => isset($_POST['country'])? $_POST['country']: '',
            'product_id' => isset($_POST['product_id']) && is_numeric($_POST['product_id'])? (int)$_POST['product_id']: 0,
        ];
    }

    /**
     *
     */

    public function create_order_woo($data = false, $status = 'pending')
    {
        $data = is_array($data)? $this->data + ['meta_fields' => $data]: $this->data;

        if ($data['product_id']) {
            $address = [
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'company'    => $data['company'],
                'email'      => $data['email'],
                'phone'      => $data['phone'],
                'address_1'  => $data['address_1'],
                'address_2'  => $data['address_2'],
                'city'       => $data['city'],
                'state'      => $data['state'],
                'postcode'   => $data['postcode'],
                'country'    => $data['country']
            ];

            $order = wc_create_order();

            if ($data['meta_fields'])
                foreach ($data['meta_fields'] as $meta => $field) {
                    update_post_meta($order->id, $meta, sanitize_text_field($field));
                }

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