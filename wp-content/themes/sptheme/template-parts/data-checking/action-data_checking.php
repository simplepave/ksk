<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 *
 */

$json = ['status' => 0, 'message' => '<strong>Ошибка</strong>, обратитесь к администратору.'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['phone'])) {
    $product_id = isset($_POST['product_id']) && is_numeric($_POST['product_id'])? (int)$_POST['product_id']: 0;

    if ($product_id) {
        $meta_fields = false;
        $variable = ['middle_name', 'date_birth', 'passport_series', 'passport_issued'];

        foreach ($variable as $value) {
            $field = isset($_POST[$value])? trim($_POST[$value]): false;
            if ($field) $meta_fields[$value] = $field;
        }

        $sp_woo = new SP_Woo();
        $response = $sp_woo->create_order_woo($meta_fields);

        if (isset($response['success'])) {
            $order_id = (int)$response['order_id'];
            $sp_tinkoff = new SP_tinkoff();
            $request = $sp_tinkoff->tinkoff_subscription_payment($order_id);

            require 'mail-data_checking.php';

            if (isset($request->Success, $request->ErrorCode) && $request->Success && $request->ErrorCode === '0')
                $json = [
                    'status' => 'success',
                    'message' => 'Перенаправление на оплату!',
                    'paymentURL' => $request->PaymentURL,
                ];
        }
    } else {
        require 'mail-data_checking.php';
    }
}

echo json_encode($json);
exit();