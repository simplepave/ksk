<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 *
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['author'], $_POST['email'], $_POST['phone'], $_POST['product_id'])) {
    $sp_woo = new SP_Woo();
    $response = $sp_woo->create_order_woo();

    if (isset($response['success'])) {
        $order_id = (int)$response['order_id'];

        $sp_tinkoff = new SP_tinkoff();
        $request = $sp_tinkoff->tinkoff_subscription_payment($order_id);

        if (isset($request->Success, $request->ErrorCode) && $request->Success && $request->ErrorCode === '0')
            $json = [
                'status' => 'success',
                'message' => 'Перенаправление на оплату!',
                'paymentURL' => $request->PaymentURL,
            ];

        else $json = ['status' => 0, 'message' => '<strong>Ошибка</strong>, обратитесь к администратору.'];
    }
    else $json = ['status' => 0, 'message' => $response['error']];
}
else $json = ['status' => 0, 'message' => '<strong>Ошибка</strong>, обратитесь к администратору.'];

echo json_encode($json);
exit();
?>