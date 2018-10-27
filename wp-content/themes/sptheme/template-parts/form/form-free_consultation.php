<?php

/**
 * Оставьте свой вопрос и пожелание.
 * form-free_consultation
 */

?>
    <div id="free_consultation" class="free_consultation">
        <div class="head_credit_history">Оставьте свой вопрос и пожелание.</div>
        <p>Наши специалисты ответят вам в течение 20 минут</p>
        <form>
            <input class="input_popup" type="text" placeholder="Ваше имя">
            <input class="input_popup" type="tel" placeholder="Ваш телефон">
            <input class="input_popup" type="text" placeholder="Вид интересующего продукта">
            <textarea class="textarea_popup" placeholder="Ваше сообщение"></textarea>
            <div class="row_flex check">
                <input class="submit_popup" type="submit" value="Отправить">
                <div class="check_box">
                    <input type="checkbox" id="c1" name="cc" />
                    <label for="c1"><span></span>Я даю согласие на передачу и обработку своих персональных данных
                        согласно <a href="<?php echo esc_url(home_url(privacy_policy().'/')); ?>" target="_blank">политике конфиденциальности</a> и
                        <a href="<?php echo esc_url(home_url(privacy_policy().'/')); ?>" target="_blank">пользовательскому соглашению</a></label>
                </div>
            </div>
        </form>
    </div>