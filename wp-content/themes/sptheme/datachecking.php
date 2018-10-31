<?php

/**
 * Template name: Проверка данных
 */

if (isset($_GET['bitrix_status'], $_SESSION['product_ID']) && $_GET['bitrix_status'] == 'success') {
    $var_product_id = $_SESSION['product_ID'];
    unset($_SESSION['product_ID']);
    set_query_var('var_product_id', $var_product_id);
}

if (isset($_GET['tinkoff_status'])) {
    if ($_GET['tinkoff_status'] == 'success') $tinkoff_success = true; // ?tinkoff_status=success
    if ($_GET['tinkoff_status'] == 'error') $tinkoff_error = true;     // ?tinkoff_status=error
}

$post = get_post();
$products = shop_product_data();
// $products = shop_product_data(false, 21);

get_header();

$breadcrumbs[] = [
    'title' => $post->post_title,
    'href'  => $post->post_name . '/',
];

set_query_var('var_breadcrumbs', $breadcrumbs);
get_template_part('template-parts/parts/bread', 'crumbs');

if ($products) :
?>
    <!-- Услуги -->
    <div class="services-dc">
        <div class="container">
            <div class="services-dc_title">у нас можно получить</div>
            <div class="row justify-content-around">
<?php
$currency = get_woocommerce_currency_symbol(get_option('woocommerce_currency', 'RUB'));

foreach ($products as $key => $product) :
    $product_image_full = wp_get_attachment_image_src(get_post_thumbnail_id($product->ID), 'medium')[0];
    $product_content = wp_trim_words($product->post_content, 13, ' ...');
    $price = number_format(get_post_meta($product->ID, '_price', true), 0, ',', ' ');

?>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="services-dc_elem">
                        <img src="<?php echo $product_image_full; ?>" alt="">
                        <div class="elem_title"><?php echo $product->post_title; ?></div>
                        <div class="elem_descr">
                            <?php echo $product_content; ?>
                        </div>
                        <strong><?php echo $price; ?> <?php echo $currency; ?></strong>
                        <a data-order-product="<?php echo $product->ID; ?>" class="popup button_call" href="#payment-bitrix">Заказать</a>
                    </div>
                </div>
<?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

    <!-- Кредитный скоринг -->
    <div class="credit-scoring">
        <div class="container">
            <div class="credit-scoring_title">Кредитный скоринг</div>
            <div class="credit-scoring_subtitle">
                Contrary to popular belief, Lorem Ipsum is not simply
                <p>random text. Contrary to popular belief</p>
            </div>

            <div class="row">
                <div class="col-sm-12 col-lg-3">
                    <div class="credit-scoring_descr">
                        <img src="<?php echo esc_url(home_url('wp-content/uploads/2018/10/img1.png')); ?>">
                        <p>
                            Есть ли долги/просрочки
                            по кредитам
                        </p>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3">
                    <div class="credit-scoring_descr">
                        <img src="<?php echo esc_url(home_url('wp-content/uploads/2018/10/img2.png')); ?>">
                        <p>
                            Есть ли активные
                            кредиты и выплаты
                            по ним
                        </p>
                    </div>
                </div>
                <div class="w-100"></div>
                <div class="col-sm-12 col-lg-3">
                    <div class="credit-scoring_descr">
                        <img src="<?php echo esc_url(home_url('wp-content/uploads/2018/10/img3.png')); ?>">
                        <p>
                          Почему могут
                          отказать банки
                        </p>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3">
                    <div class="credit-scoring_descr">
                        <img src="<?php echo esc_url(home_url('wp-content/uploads/2018/10/img4.png')); ?>">
                        <p>
                          Одобрят ли кредит
                          и какова вероятность этого
                        </p>
                    </div>
                </div>

                <div class="w-100 "></div>

                <div class="col-xl-2 col-sm-12">
                    <a class="popup button_call" href="#get_report">Получить отчет</a>
                </div>
                <div class="credit-scoring_blank">
                    <img src="<?php echo esc_url(home_url('wp-content/uploads/2018/10/credit-scoring.jpg')); ?>">
                </div>

            </div>
        </div>
    </div>

    <!-- Пошаговая инструкция -->
    <div class="container">
        <div class="instruction">
            <div class="instruction_title">
                Как заказать справку или отчет?
            </div>

            <div class="instruction_first-step">
                <div class="instruction-img">
                    <img src="<?php echo esc_url(home_url('wp-content/uploads/2018/10/img1-4.jpg')); ?>">
                </div>

                <div class="descr">
                    <strong>Первий шаг</strong>
                    <p>
                     Выберите нужную проверку и оформите заявку на сайте. Если затрудняетесь с выбором проверки, закажите обратный звонок и наш менеджер поможет вам.
                    </p>
                </div>
            </div>


            <div class="instruction_second-step">
                <div class="descr">
                    <strong>Второй шаг</strong>
                    <p>
                      После получения заявки наш менеджер свяжется с вами и уточнит детали. Для некоторых видов проверки требуется личное присутствие.
                    </p>
                </div>

                <div class="instruction-img">
                    <img src="<?php echo esc_url(home_url('wp-content/uploads/2018/10/img2-4.jpg')); ?>">
                </div>
            </div>


            <div class="instruction_third-step">
                <div class="instruction-img">
                    <img src="<?php echo esc_url(home_url('wp-content/uploads/2018/10/img3-4.jpg')); ?>">
                </div>

                <div class="descr">
                    <strong>Третий шаг</strong>
                    <p>
                      Мы подготавливаем требуемые документы и передаем их вам.
                    </p>
                </div>
            </div>

            <div class="instruction_descr">
                <p>
                 Мы поможем проверить данные на кредит в Москве и Московской области. Расскажем, как проверить, дадут ли мне (вам) кредит
                 в Сбербанке или других банках, займ онлайн. Ответим на вопрос: как проверить, почему мне не дают кредит? Опытные менеджеры нашей компании сделают все необходимое, чтобы наши клиенты смогли получить займ на оптимальных для себя условиях, в любом банковском учреждении Москвы.
                </p>
            </div>
        </div>
    </div>

    <!-- Заполнить заявку -->
    <div class="request">
        <a class="popup button_call" href="#order_report">Заполнить заявку</a>
    </div>

    <!-- Заказать отчет -->
    <div class="order-descr">
        <div class="container">
            <div class="row justify-content-between">

                <div class="col-12 col-xl-7">
                    <div class="order-descr_title">
                     НА РУКАХ КРЕДИТНАЯ ИСТОРИЯ
                     И ВЫ НЕ ЗНАЕТЕ ЧТО
                     С НЕЙ ДЕЛАТЬ?
                    </div>

                    <div class="order-descr_subtitle">
                     Мы абсолютно бесплатно проведем ее детальный<br>
                     анализ, и предоставим вам отчет<br>
                     по его результатам.
                    </div>

                    <a class="popup button_call" href="#order_report">Заказать отчет</a>
                </div>

                <div class="col-5">
                    <img src="<?php echo esc_url(home_url('wp-content/uploads/2018/10/man.png')); ?>" alt="man">
                </div>

            </div>
        </div>
    </div>

    <!-- Помощь с вопросами -->
    <div class="request-call">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="request-call_title">
                         Если у вас<br>
                         возникли вопросы,<br>
                         мы всегда рады<br>
                         вам ответить
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="request-call_right">

                        <div class="request-call_descr">
                            по телефону
                        </div>

                        <div class="request-call_tel">
                            <strong><?php echo esc_html(get_option('phone', '')); ?></strong>
                        </div>

                        <div class="request-call_graph">
                            <?php echo esc_html(get_option('work_schedule', '')); ?>
                        </div>

                        <a class="popup button_call" href="#free_consultation">Заказать звонок</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main_text">
        <div class="container">
            <div class="row no-gutters"><?php echo $post->post_content; ?></div>
        </div>
    </div>
<?php
if (isset($var_product_id)) get_template_part('template-parts/form/form', 'payment');
if (isset($tinkoff_success)) get_template_part('template-parts/payment/message', 'tinkoff_success');
if (isset($tinkoff_error)) get_template_part('template-parts/payment/message', 'tinkoff_error');
get_template_part('template-parts/form/form', 'payment_bitrix');

get_template_part('template-parts/form/form', 'order_report');
get_template_part('template-parts/form/form', 'get_report');
get_footer();