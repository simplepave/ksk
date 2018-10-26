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
                <div class="hidden_box">
                    <p>Текст о согласии обработки персональных данных Текст о согласии обработки персональных данных Текст о согласии обработки персональных данных</p>
                </div>
                <input class="submit_popup" type="submit" value="Заказать">
                <div class="check_box">
                    <input type="checkbox" id="c1" name="cc" />
                    <label for="c1"><span></span>Я даю согласие на обработку своих персональных данных</label>
                </div>
            </div>
        </form>
    </div>