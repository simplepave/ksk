<?php

/**
 *
 */

$post_id = isset($post->ID)? $post->ID: 0;
$post_arr = [44];

$args = [
    'role'   => 'employee_role',
    'order'  => 'ASC',
];

if ($users = get_users($args)) :
?>
    <div class="our_employees">
        <div class="container">
<?php if (!in_array($post_id, $post_arr)) : ?>
            <div class="head_employees">наши сотрудники</div>
<?php endif; ?>
            <div class="row no-gutters justify-content-between">
<?php
foreach ($users as $user) :
    $description = explode("\n", $user->description, 2);
    $avatar_src = get_wp_user_avatar_src($user->ID, 'full');
?>
                <div class="item_employees">
                    <div class="img_employees"><img src="<? echo $avatar_src; ?>" alt="<? echo $user->display_name; ?>"></div>
                    <div class="text_employees">
                        <div class="head_our"><? echo $user->display_name; ?></div>
                        <em><? echo $description[0]; ?></em>
                        <p><? echo $description[1]; ?></p>
                        <strong>Связаться со специалистом</strong>
                        <a class="phone_link" href="tel:<?php echo href_tel($user->wp_user_phone); ?>"><? echo $user->wp_user_phone; ?></a>
                        <a class="mail_link" href="mailto:<? echo $user->user_email; ?>"><? echo $user->user_email; ?></a>
                    </div>
                </div>
<?php
endforeach;
?>
            </div>
        </div>
    </div>
<?php endif;