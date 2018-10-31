<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

/*
    https://static2.tinkoff.ru/acquiring/cms/WooCommerce.pdf

    Нотификация по http(s)
    https://cicorp.ru/wp-content/plugins/tinkoff-woocommerce/tinkoff/success.php

    URL страницы успешного платежа:
    https://cicorp.ru/proverka-dannyh/?tinkoff_status=success

    URL страницы неуспешного платежа:
    https://cicorp.ru/proverka-dannyh/?tinkoff_status=error
*/

if (!class_exists('SP_tinkoff')) :

class SP_tinkoff extends WC_Payment_Gateway
{

    /**
     *
     */

    public function __construct()
    {
        $this->id = 'tinkoff';

        // Define user set variables
        $this->merchant_id = $this->get_option('merchant_id');
        $this->secret_key = $this->get_option('secret_key');

        $this->description = $this->get_option('description');
        $this->check_data_tax = $this->get_option('check_data_tax');
        $this->taxation = $this->get_option('taxation');
    }

    /**
     *
     */

    public function tinkoff_subscription_payment($order_id)
    {
        $order = new WC_Order($order_id);
        $arrFields = $this->send_data($order, $order_id);

        $arrFields = $this->get_setting_language($arrFields);

        $Tinkoff = new TinkoffMerchantAPI($this->get_option('merchant_id'), $this->get_option('secret_key'));
        $request = $Tinkoff->buildQuery('Init', $arrFields);

        return json_decode($request);
    }

    /**
     *
     */

    public function get_setting_language($arrFields)
    {
        if ($this->get_option('payment_form_language') == 'en') {
            $arrFields['Language'] = "en";
        }

        return $arrFields;
    }

    public function send_data($order, $order_id)
    {
        $arrCartItems = $order->get_items();
        $description = $this->description_tinkoff($arrCartItems);

        $arrFields = array(
            'OrderId' => $order_id,
            'Amount' => round($order->get_total() * 100),
            'Description' => $description,
            'DATA' => array('Email' => $order->get_billing_email(), 'Connection_type' => 'wp-woocommerce',),
        );

        if ($this->check_data_tax == 'yes') {
            $arrFields['Receipt'] = array(
                'Email' => $order->get_billing_email(),
                'Phone' => $order->get_billing_phone(),
                'Taxation' => $this->taxation,
                'Items' => $this->get_receipt_items($order_id),
            );
        }

        return $arrFields;
    }

    function description_tinkoff($arrCartItems)
    {
        $strDescription = '';

        foreach ($arrCartItems as $arrItem) {
            $strDescription .= $arrItem['name'];
            if ($arrItem['qty'] > 1) {
                $strDescription .= '*' . $arrItem['qty'] . "; ";
            } else {
                $strDescription .= "; ";
            }
        }

        if (strlen($strDescription) > 250) {
            $strDescription = mb_substr($strDescription, 0, 247) . '...';
        }

        return $strDescription;
    }

    protected static function getTaxForSend($tax)
    {
        switch ($tax) {
            case 18:
                $vat = 'vat18';
                break;
            case 10:
                $vat = 'vat10';
                break;
            case 0:
                $vat = 'none';//vat0
                break;
            default:
                $vat = 'none';
        }
        return $vat;
    }

    /**
     *
     */

    function get_receipt_items($order_id)
    {
        global $wpdb;

        $order = new WC_Order($order_id);
        $vat = '';
        $items = array();

        foreach ($order->get_items() as $item) {
            if ($item->get_product()->get_tax_status() != 'none') {
                $_tax = new WC_Tax();
                $ratesData = $_tax->get_rates($item->get_product()->get_tax_class());
                $rates = array_shift($ratesData);
                $ratOne = $rates['rate'];
                $compoundOne = $rates['compound'];
                //Take only the item rate and round it.
                if ($rates)
                    $item_rate = round(array_shift($rates));

                $vat = self::getTaxForSend($item_rate);
                $rate = array(
                    array(
                        'rate' => $ratOne,
                        'compound' => $compoundOne,
                    )
                );
                $price = $item->get_product()->get_price();

                $tax = 0;
                /* если настройка на Нет */
                if (!wc_prices_include_tax()) {
                    $tax = WC_Tax::calc_tax($price, $rate, false);
                    foreach ($tax as $tax) {
                        $price += $tax;
                    }
                }
            } else {
                $price = $item->get_product()->get_price();
                $vat = 'none';
            }

            $quantity = $item->get_quantity();
            $newItem = array(
                'Name' => mb_substr($item->get_product()->get_name(), 0, 64),
                'Price' => round($price * 100),
                'Quantity' => round($quantity, 2),
                'Amount' => round($price * $quantity * 100),
                'Tax' => $vat,
            );

            array_push($items, $newItem);
        }

        $shippingPrice = $order->get_shipping_total();
        $isShipping = false;
        if ($shippingPrice > 0) {
            $shippingPriceTax = round($order->get_shipping_tax() * 100);
            $shippingPrice = round($shippingPrice * 100);
            $shippingPriceTax += $shippingPrice;

            $orderItemId = $wpdb->get_row("
              SELECT order_item_id FROM " . $wpdb->prefix . "woocommerce_order_items WHERE order_item_type = 'tax' and order_id = $order_id
            ");

            if (!empty($orderItemId)) {
                $taxRateData = $wpdb->get_row("
                SELECT * FROM " . $wpdb->prefix . "woocommerce_tax_rates WHERE tax_rate_id =
                    (SELECT meta_value FROM " . $wpdb->prefix . "woocommerce_order_itemmeta WHERE meta_key = 'rate_id' and order_item_id = $orderItemId->order_item_id)
                ");
                // налог на доставку вкл
                if ($taxRateData->tax_rate_shipping == 1) {
                    $shippingTax = self::getTaxForSend(round($taxRateData->tax_rate));
                } else {
                    $shippingTax = 'none';
                }
            } else {
                $shippingTax = 'none';
            }

            $shippingItem = array(
                'Name' => mb_substr($order->get_shipping_method(), 0, 64),
                'Price' => $shippingPriceTax,
                'Quantity' => 1,
                'Amount' => $shippingPriceTax,
                'Tax' => $shippingTax,
            );
            array_push($items, $shippingItem);
            $isShipping = true;
        }

        $amount = round($order->get_total() * 100);

        return $this->balance_amount($isShipping, $items, $amount);
    }

    /**
     *
     */

    function balance_amount($isShipping, $items, $amount)
    {
        $itemsWithoutShipping = $items;

        if ($isShipping) {
            $shipping = array_pop($itemsWithoutShipping);
        }

        $sum = 0;

        foreach ($itemsWithoutShipping as $item) {
            $sum += $item['Amount'];
        }

        if (isset($shipping)) {
            $sum += $shipping['Amount'];
        }

        if ($sum != $amount) {
            $sumAmountNew = 0;
            $difference = $amount - $sum;
            $amountNews = array();

            foreach ($itemsWithoutShipping as $key => $item) {
                $itemsAmountNew = $item['Amount'] + floor($difference * $item['Amount'] / $sum);
                $amountNews[$key] = $itemsAmountNew;
                $sumAmountNew += $itemsAmountNew;
            }

            if (isset($shipping)) {
                $sumAmountNew += $shipping['Amount'];
            }

            if ($sumAmountNew != $amount) {
                $max_key = array_keys($amountNews, max($amountNews))[0];    // ключ макс значения
                $amountNews[$max_key] = max($amountNews) + ($amount - $sumAmountNew);
            }

            foreach ($amountNews as $key => $item) {
                $items[$key]['Amount'] = $amountNews[$key];
            }
        }
        return $items;
    }
}

endif;