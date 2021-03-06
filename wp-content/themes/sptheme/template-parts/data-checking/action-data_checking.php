<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 *
 */

$json = ['status' => 0];
$message = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['phone'])) {
    $sp_valid = new SP_Validation();

    $validation = $sp_valid->validation([
        'last_name'       => 'bail|nullable|min:3|max:25',
        'first_name'      => 'bail|nullable|min:3|max:25',
        'middle_name'     => 'bail|nullable|min:3|max:25',
        'date_birth'      => 'bail|nullable|date_format:d.m.Y',
        'passport_series' => 'bail|nullable|min:10|max:25',
        'passport_issued' => 'bail|nullable|date_format:d.m.Y',
        'phone'           => 'bail|required|phone|max:25',
        'email'           => 'bail|required|email|max:100',
        'cc'              => 'accepted',
    ]);

    if ($sp_valid->status) {
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

                if (isset($request->Success, $request->ErrorCode) && $request->Success && $request->ErrorCode === '0') {
                    $json = ['status' => 'success', 'paymentURL' => $request->PaymentURL];
                    $message['payment'] = ['status' => 1, 'title' => 'Перенаправление на оплату!'];
                }
                else $message['payment'] = ['status' => 0, 'title' => 'платежного шлюза'];
            }
            else $message['woo_order'] = ['status' => 0, 'title' => 'ордер не создан'];
        }
        else {
            require 'mail-data_checking.php';
        }
    }
    else {
        $json = ['status' => 'error'];
        $message = $sp_valid->get_errors();
    }
}

if (is_array($message)) $json['message'] = $message;
else $json['message'] = ['error' => ['status' => 0, 'title' => 'обратитесь к администратору']];

if ($json['status'] !== 'error') {
    foreach ($json['message'] as $key => $value) {
        if (!$value['status']) {
            $log = '[' . date('D M d H:i:s Y', time()) . '] ';
            $log .= $key . ' = Ошибка, ' . $value['title'] . '!';
            $log .= "\n";
            file_put_contents(dirname(__FILE__) . "/error.log", $log, FILE_APPEND);

            $json['message'][$key]['title'] = '<strong>Ошибка</strong>, ' . $value['title'] . '!';
        }
    }
}

echo json_encode($json);
exit();