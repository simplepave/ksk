<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 *
 */

$sp = new SP_Woo();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['author'], $_POST['email'])) {
    $response = $sp->create_order_woo();
    $json['response'] = isset($response['success'])? 1: 0;
    $json['message'] = isset($response['success'])? $response['success']: $response['error'];
} else {
    $json['response'] = 0;
    $json['message'] = 'Вы не заполнили обязательные поля!';
}

echo json_encode($json);
exit();
?>