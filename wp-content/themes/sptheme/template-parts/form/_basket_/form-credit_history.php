<?php

/**
 * проверить кредитную историю
 * form-credit_history
 */

?>
    <div id="credit_history" class="credit_history">
        <div class="head_credit_history">проверить кредитную историю</div>
        <form>
            <input class="input_popup" type="text" placeholder="Ваше имя">
            <input class="input_popup" type="tel" placeholder="Ваш телефон">
            <input class="input_popup" type="email" placeholder="Ваша почта">
            <select>
                <option>Услуга</option>
                <option>Услуга</option>
                <option>Услуга</option>
                <option>Услуга</option>
                <option>Услуга</option>
            </select>
            <div class="row_flex check">
                <input class="submit_popup" type="submit" value="Заказать">
                <div class="check_box">
                    <input type="checkbox" id="c1" name="cc" />
                    <label for="c1"><span></span>Я даю согласие на передачу и обработку своих персональных данных
                        согласно <a href="<?php echo esc_url(home_url(privacy_policy().'/')); ?>" target="_blank">политике конфиденциальности</a> и
                        <a href="<?php echo esc_url(home_url(privacy_policy().'/')); ?>" target="_blank">пользовательскому соглашению</a></label>
                </div>
            </div>
        </form>
    </div>