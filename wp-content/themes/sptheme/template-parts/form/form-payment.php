<?php

/**
 * Заказать отчёт
 * form-payment
 */

if (isset($var_product_id)) :
?>
    <div id="order-payment" class="order_report">
        <div class="head_order_report">Данные для оплаты</div>
        <p>Заполните форму оплаты</p>
        <form id="woo-order-form" action="" method="post">
            <input name="author" class="input_popup" type="text" placeholder="Фамилия Имя Отчество" required="required">
            <input name="phone" class="input_popup phone-mask-payment" type="tel" placeholder="Ваш телефон" required="required">
            <input name="email" class="input_popup" type="email" placeholder="E-mail" required="required">
            <div class="row_flex check">
                <div class="check_box">
                    <input type="checkbox" id="c1" name="cc" required="required" checked="checked">
                    <label for="c1"><span></span>Я даю согласие на передачу и обработку своих персональных данных
                        согласно <a href="<?php echo esc_url(home_url(privacy_policy().'/')); ?>" target="_blank">политике конфиденциальности</a> и
                        <a href="<?php echo esc_url(home_url(privacy_policy().'/')); ?>" target="_blank">пользовательскому соглашению</a></label>
                </div>
                <input type='hidden' name='product_id' value='<?php echo $var_product_id; ?>' />
                <input class="submit_popup" type="submit" value="Отправить">
            </div>
        </form>
    </div>
<?php endif;