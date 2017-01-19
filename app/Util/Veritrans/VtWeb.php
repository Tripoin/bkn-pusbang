<?php

/**
 * Create VtWeb transaction and return redirect url
 *
 */

namespace app\Util\Veritrans;

use app\Util\Veritrans\Config;
use app\Util\Veritrans\ApiRequestor;
use app\Util\Veritrans\Sanitizer;

class VtWeb {

    /**
     * Create VT-Web transaction
     *
     * Example:
     *
     * ```php
     *   $params = array(
     *     'transaction_details' => array(
     *       'order_id' => rand(),
     *       'gross_amount' => 10000,
     *     )
     *   );
     *   $paymentUrl = Veritrans_Vtweb::getRedirectionUrl($params);
     *   header('Location: ' . $paymentUrl);
     * ```
     *
     * @param array $params Payment options
     * @return string Redirect URL to VT-Web payment page.
     * @throws Exception curl error or veritrans error
     */
    public static function getRedirectionUrl($params) {
        $payloads = array(
            'payment_type' => 'vtweb',
            'vtweb' => array(
                // 'enabled_payments' => array('credit_card'),
                'credit_card_3d_secure' => Config::$is3ds
            )
        );
//        echo $params;
        
        if (array_key_exists('item_details', $params)) {
            $gross_amount = 0;
            foreach ($params['item_details'] as $item) {
                $gross_amount += $item['quantity'] * $item['price'];
            }
            $payloads['transaction_details']['gross_amount'] = $gross_amount;
        }

        $payloads = array_replace_recursive($payloads, $params);

        if (Config::$isSanitized) {
            Sanitizer::jsonRequest($payloads);
        }

        $result = ApiRequestor::post(
                        Config::getBaseUrl() . '/charge', Config::$serverKey, $payloads);
//        echo $result;
//print_r($result);
        return $result->redirect_url;
    }

}
