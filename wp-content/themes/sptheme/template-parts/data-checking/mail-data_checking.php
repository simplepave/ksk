<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 *
 */

$variable = [
    'subject'         => ['name' => 'Тема письма', 'body' => false],
    'last_name'       => ['name' => 'Фамилия'],
    'first_name'      => ['name' => 'Имя'],
    'middle_name'     => ['name' => 'Отчество'],
    'date_birth'      => ['name' => 'Дата рождения'],
    'passport_series' => ['name' => 'Серия паспорта'],
    'passport_issued' => ['name' => 'Дата выдачи'],
    'phone'           => ['name' => 'Телефон'],
    'email'           => ['name' => 'e-mail']
];

$form_fields = false;

foreach ($variable as $name => $value) {
    $field = isset($_POST[$name])? trim($_POST[$name]): false;

    if ($field) {
        $form_fields[$name] = $value;
        $form_fields[$name]['value'] = $field;
    }
}

/**
 *
 */

$to = get_option('admin_email');
$subject   = get_bloginfo('name') .' '. $form_fields['subject']['value'];

$headers = [
    'MIME-Version: 1.0',
    'From: ' . $author . '<' . get_option('admin_email') . '>',
    'Content-Type: text/html; charset="' . get_option('blog_charset') . '"',
];

$message = '';
foreach ($form_fields as $value) {
    if (!isset($value['body']))
        $message .= '<b>' . $value['name'] . ' :</b> ' . $value['value'] . '<br />';
}

if (wp_mail($to, $subject, $message, $headers))
    $json = [
        'status' => 'success',
        'message' => 'Сообщение успешно отправлено!',
    ];