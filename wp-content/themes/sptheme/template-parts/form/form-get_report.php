<?php

/**
 * Получить отчет
 * form-get_report
 */

?>
    <div id="get_report" class="get_report">
        <div class="head_get_report">Получить отчет</div>
        <p>Отчет будет готов в течении 15 мин, заполните форму</p>
        <form>
            <input class="input_popup" type="text" placeholder="Фамилия">
            <input class="input_popup" type="text" placeholder="Имя">
            <input class="input_popup" type="text" placeholder="Отчество">
            <input class="input_popup" type="text" placeholder="Дата рождения">

            <input class="input_popup" type="text" placeholder="Серия паспорта" id="medium_popup">
            <input class="input_popup" type="text" placeholder="Дата выдачи" id="medium_popup">

            <input class="input_popup" type="tel" placeholder="Ваш телефон" id="medium_popup">
            <input class="input_popup" type="email" placeholder="Ваш e-mail" id="medium_popup">

            <div class="row_flex check">

                <div class="check_box">
                    <input type="checkbox" id="c1" name="cc" />
                    <label for="c1"><span></span>Я даю согласие на передачу и обработку своих персональных данных
                        согласно <a href="<?php echo esc_url(home_url(privacy_policy().'/')); ?>" target="_blank">политике конфиденциальности</a> и
                        <a href="<?php echo esc_url(home_url(privacy_policy().'/')); ?>" target="_blank">пользовательскому соглашению</a></label>
                </div>
                <input class="submit_popup" type="submit" value="Отправить">
            </div>
        </form>
    </div>