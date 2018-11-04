<?php

/**
 * Получить отчет
 * form-data_checking
 */

?>
    <div id="popup-data-checking" class="get_report">
        <div class="head_get_report">Получить отчет</div>
        <p>Отчет будет готов в течении 15 мин, заполните форму</p>
        <form id="form-data-checking" action="" method="post">
            <input name="last_name" class="input_popup" type="text" placeholder="Фамилия">
            <input name="first_name" class="input_popup" type="text" placeholder="Имя">
            <input name="middle_name" class="input_popup" type="text" placeholder="Отчество">
            <input name="date_birth" class="input_popup" type="text" placeholder="Дата рождения">

            <input name="passport_series" class="input_popup" type="text" placeholder="Серия паспорта" id="medium_popup">
            <input name="passport_issued" class="input_popup" type="text" placeholder="Дата выдачи" id="medium_popup">

            <input name="phone" class="input_popup phone-mask" type="tel" placeholder="Ваш телефон" id="medium_popup" required="required">
            <input name="email" class="input_popup" type="email" placeholder="Ваш e-mail" id="medium_popup" required="required">

            <div class="row_flex check">

                <div class="check_box">
                    <input type="checkbox" id="c1" name="cc" checked="checked">
                    <label for="c1"><span></span>Я даю согласие на передачу и обработку своих персональных данных
                        согласно <a href="<?php echo esc_url(home_url(privacy_policy().'/')); ?>" target="_blank">политике конфиденциальности</a> и
                        <a href="<?php echo esc_url(home_url(privacy_policy().'/')); ?>" target="_blank">пользовательскому соглашению</a></label>
                </div>
                <input type='hidden' name='subject' value='Получить отчет'>
                <input class="submit_popup" type="submit" value="Отправить">
            </div>
        </form>
    </div>