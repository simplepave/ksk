<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 *
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['author'], $_POST['email'])) {
    $author  = esc_attr(substr($_POST['author'], 0, 64));
    $email = substr($_POST['email'], 0, 64);
    $comment = isset($_POST['comment'])? substr($_POST['comment'], 0, 250): false;
    $subject = isset($_POST['subject'])? esc_attr($_POST['subject']): '';

    $to = get_option('admin_email');
    $subject   = get_bloginfo('name') .' '. $subject;

    $headers = [
        'MIME-Version: 1.0',
        'From: ' . $author . '<' . get_option('admin_email') . '>',
        'Content-Type: text/html; charset="' . get_option('blog_charset') . '"',
    ];

    $message = '';
    $message .= '<b>Имя:</b> ' . $author . '<br />';
    $message .= '<b>E-mail:</b> ' . $email . '<br />';
    $message .= $comment? '<br /><b>Комментарий:</b> ' . str_replace('\n', '<br />', $comment): '';

    if (wp_mail($to, $subject, $message, $headers)) {
        $json['response'] = true;
        $json['message'] = 'Сообщение успешно отправлено!';
    } else {
        $json['response'] = false;
        $json['message'] = 'Ошибка, попробуйте позже!';
    }
} else {
    $json['response'] = false;
    $json['message'] = 'Вы не заполнили обязательные поля!';
}

echo json_encode($json);
exit();