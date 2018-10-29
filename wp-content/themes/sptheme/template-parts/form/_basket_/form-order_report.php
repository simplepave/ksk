<?php

/**
 * Заказать отчёт
 * form-order_report
 */

?>
    <div id="order_report" class="order_report">
        <div class="head_order_report">Заказать отчёт</div>
        <p>Заполните форму заявки</p>
        <form id="order-form" action="" method="post">
            <input name="author" class="input_popup" type="text" placeholder="Фамилия Имя Отчество" required="required">
            <input name="phone" class="input_popup" type="tel" placeholder="Ваш телефон" required="required">
            <input name="email" class="input_popup" type="email" placeholder="E-mail" required="required">
            <div class="row_flex check">
                <div class="check_box">
                    <input type="checkbox" id="c1" name="cc" required="required">
                    <label for="c1"><span></span>Я даю согласие на передачу и обработку своих персональных данных
                        согласно <a href="<?php echo esc_url(home_url(privacy_policy().'/')); ?>" target="_blank">политике конфиденциальности</a> и
                        <a href="<?php echo esc_url(home_url(privacy_policy().'/')); ?>" target="_blank">пользовательскому соглашению</a></label>
                </div>
                <input class="submit_popup" type="submit" value="Отправить">
            </div>
        </form>
    </div>