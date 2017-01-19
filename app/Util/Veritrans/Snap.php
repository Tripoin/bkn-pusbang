<?php
/**
 * Create Snap payment page and return snap token
 *
 */
namespace app\Util\Veritrans;
use app\Util\Veritrans\Config;
use app\Util\Veritrans\SnapApiRequestor;
use app\Util\Veritrans\Sanitizer;
class Snap {

  /**
   * Create Snap payment page
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
   *   $paymentUrl = Veritrans_Snap::getSnapToken($params);
   * ```
   *
   * @param array $params Payment options
   * @return string Snap token.
   * @throws Exception curl error or veritrans error
   */
  public static function getSnapToken($params)
  {
    $payloads = array(
      'credit_card' => array(
        // 'enabled_payments' => array('credit_card'),
        'secure' => Config::$is3ds
      )
    );

    if (array_key_exists('item_details', $params)) {
      $gross_amount = 0;
      foreach ($params['item_details'] as $item) {
        $gross_amount += $item['quantity'] * $item['price'];
      }
      $params['transaction_details']['gross_amount'] = $gross_amount;
    }

    if (Config::$isSanitized) {
      Sanitizer::jsonRequest($params);
    }

    $params = array_replace_recursive($payloads, $params);

    $result = SnapApiRequestor::post(
        Config::getSnapBaseUrl() . '/charge',
        Config::$serverKey,
        $params);

    return $result->token_id;
  }
}
