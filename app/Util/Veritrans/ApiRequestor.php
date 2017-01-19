<?php

/**
 * Send request to Veritrans API
 * Better don't use this class directly, use Veritrans_VtWeb, Veritrans_VtDirect, Veritrans_Transaction
 */

namespace app\Util\Veritrans;

use app\Util\Veritrans\Config;
use app\Util\Veritrans\VtTests;

class ApiRequestor {

    /**
     * Send GET request
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     */
    public static function get($url, $server_key, $data_hash) {
        return self::remoteCall($url, $server_key, $data_hash, false);
    }

    /**
     * Send POST request
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     */
    public static function post($url, $server_key, $data_hash) {
        return self::remoteCall($url, $server_key, $data_hash, true);
    }

    /**
     * Actually send request to API server
     * @param string  $url
     * @param string  $server_key
     * @param mixed[] $data_hash
     * @param bool    $post
     */
    public static function remoteCall($url, $server_key, $data_hash, $post = true) {
        $ch = curl_init();
//    echo FILE_PATH("app/Util/Veritrans/cacert.pem");
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode($server_key . ':')
            ),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CAINFO => FILE_PATH("app/Util/Veritrans/cacert.pem")
        );

        // merging with Config::$curlOptions
        if (count(Config::$curlOptions)) {
            // We need to combine headers manually, because it's array and it will no be merged
            if (Config::$curlOptions[CURLOPT_HTTPHEADER]) {
                $mergedHeders = array_merge($curl_options[CURLOPT_HTTPHEADER], Config::$curlOptions[CURLOPT_HTTPHEADER]);
                $headerOptions = array(CURLOPT_HTTPHEADER => $mergedHeders);
            } else {
                $mergedHeders = array();
            }

            $curl_options = array_replace_recursive($curl_options, Config::$curlOptions, $headerOptions);
        }

        if ($post) {
            $curl_options[CURLOPT_POST] = 1;

            if ($data_hash) {
                $body = json_encode($data_hash);
                $curl_options[CURLOPT_POSTFIELDS] = $body;
            } else {
                $curl_options[CURLOPT_POSTFIELDS] = '';
            }
        }

        curl_setopt_array($ch, $curl_options);

        // For testing purpose
        if (class_exists('app\Util\Veritrans\VtTests') && VtTests::$stubHttp) {
            $result = self::processStubed($curl_options, $url, $server_key, $data_hash, $post);
        } else {
            $result = curl_exec($ch);
            // curl_close($ch);
        }
//    echo 'sampai';


        if ($result === FALSE) {
            throw new Exception('CURL Error: ' . curl_error($ch), curl_errno($ch));
        } else {
            $result_array = json_decode($result);
            if (!in_array($result_array->status_code, array(200, 201, 202, 407))) {
                $message = 'Veritrans Error (' . $result_array->status_code . '): '
                        . $result_array->status_message;
                throw new Exception($message, $result_array->status_code);
            } else {
                return $result_array;
            }
        }
    }

    private static function processStubed($curl, $url, $server_key, $data_hash, $post) {
        VtTests::$lastHttpRequest = array(
            "url" => $url,
            "server_key" => $server_key,
            "data_hash" => $data_hash,
            "post" => $post,
            "curl" => $curl
        );

        return VtTests::$stubHttpResponse;
    }

}
