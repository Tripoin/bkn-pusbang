<?php

/**
 * @project pip.
 * @since 8/31/2016 5:50 PM
 * @author <a href = "fauzi.knightmaster.achmad@gmail.com">Achmad Fauzi</a>
 */

namespace app\Util\RestClient;

use app\Util\RestClient;
use app\Constant\IRestCommandConstant;
use app\Constant\IApplicationConstant;

class TripoinRestClient {

    public $token;
    public $sessionClient;

    /**
     * PIPRestClient constructor.
     */
    public function __construct() {
//        $this->sessionClient = new PIPSessionClient();
    }

    public function queryParamURL($p_TargetURL) {
        $parts = parse_url($p_TargetURL);
        $merge_array_key = array();
        if (isset($parts['query'])) {
//            print_r($parts['query']);
            $a = explode('&', $parts['query']);
            foreach ($a as $result) {
                $b = explode('=', $result);
                $array[$b[0]] = $b[1];
            }

            $merge_array_key = array_merge($merge_array_key, $array);
        }
        return $merge_array_key;
    }

    public function doGET($p_TargetURL, $param = array(), $header = array()) {
        $merge_array_key = $this->queryParamURL($p_TargetURL);
        $page_url = strtok($p_TargetURL, '?');
//        $this->getRefreshedToken();
        $merge_param_token = array("token" => $_SESSION[SESSION_ADMIN_TOKEN]);
        $merge_param = array_merge($param, $merge_array_key, $merge_param_token);
//        $merge_header = array(IApplicationConstant::SESSION_TOKEN_NAME . ": " . $_SESSION[SESSION_ADMIN_TOKEN]);
        $merge_header = array();
        $rs_url = new RestClient();
        $response = $rs_url->to($page_url)
                ->setParam($merge_param)
                ->setHeader(array_merge($merge_header, $header))
                ->get();
//        echo $_SESSION[IApplicationConstant::SESSION_USER][IApplicationConstant::TOKEN];
//        print_r($response);
        if (isset(json_decode($response->getBody)->error)) {
            $this->failGetBearer(json_decode($response->getBody)->error);

            return false;
        } else {
            $headers = json_decode($response->getHeader);
            if (isset($headers->Authorization)) {
                $this->setSessionFromBearer($headers->Authorization);
            }
        }
//        Log::info('Do Get menu');
        return $response;
    }

    public function failGetBearer($code) {
        if ($code == "X-Q04") {
            session_destroy();
            echo '<script>window.location = \'' . URL() . '\'</script>';
//            return \Redirect::to(IApplicationConstant::URL_LOGIN)->send();
        } else {
            $tripoinRestClient = new TripoinRestClient();
            $tripoinRestClient->doPOSTLoginNoAuth();
            return $this->save();
        }
        /* Session::forget(IApplicationConstant::SESSION_USER);
          Session::flush(); */
//        session_destroy();
//        return \Redirect::to(IApplicationConstant::URL_LOGIN)->send();
    }

    public function setSessionFromBearer($bearer) {
//        echo $bearer;
        $value = explode(' ', $bearer);

        if ($value != null) {
            if (isset($value[1])) {
                $_SESSION[SESSION_ADMIN_TOKEN] = $value[1];
            }
        } else {
//            return \Redirect::to(IApplicationConstant::URL_LOGIN)->send();
        }
    }

    public function doPOSTLogin($p_TargetURL, $data) {
        session_start();
//        $merge_array_key = $this->queryParamURL($p_TargetURL);
        $page_url = strtok($p_TargetURL, '?');
//        $this->getRefreshedToken();
//        $merge_param = array_merge($merge_array_key);
        $rs_url = new RestClient();
        $response = $rs_url->to($page_url)
                ->setBody(array(
                    "username" => $data[IApplicationConstant::USER_CODE],
                    "password" => $data[IApplicationConstant::VALIDATION_KEY_PASSWORD])
                )
                ->post();

        if (isset(json_decode($response->getBody)->token)) {
            $this->setSessionFromLogin(json_decode($response->getBody)->token, $data[IApplicationConstant::USER_CODE]);
        } else {
//            $this->failGetBearer();
        }
//        Log::info('Do POST');
        return $response;
    }

    public function doPOSTLoginNoAuth() {
//        session_start();
        $url_api = URL_REST . IRestCommandConstant::API . SLASH . IRestCommandConstant::VERSI . SLASH;
        $api_command_login = $url_api . IRestCommandConstant::COMMAND_STRING . EQUAL . IRestCommandConstant::LOGIN;

        $rs_url = new RestClient();
        $response = $rs_url->to($api_command_login)
                ->setHeader(array("Authorization: " . $_SESSION[SESSION_ADMIN_AUTHORIZATION]))
                ->post();

        if (isset(json_decode($response->getBody)->token)) {
            $this->setSessionFromLogin(json_decode($response->getBody)->token);
        } else {
            return false;
//            $this->failGetBearer();
        }
//        Log::info('Do POST');
        return $response;
    }

    public function setSessionFromLogin($token) {

        if (empty($token)) {
            $this->failGetBearer();
        } else {//            Log::info('user:' . $user_code . '; token:' . $token->token);
            //Session::put(IApplicationConstant::SESSION_USER, $user);
            $_SESSION[SESSION_ADMIN_TOKEN] = $token;
        }
    }

    public function doPOST($p_TargetURL, $param = array(), $header = array(), $body = array()) {
//        $tripoinRestClient = new TripoinRestClient();
        if (isset($_SESSION[SESSION_ADMIN_TOKEN])) {
            if ($_SESSION[SESSION_ADMIN_TOKEN] == "") {
                $this->doPOSTLoginNoAuth();
            }
        } else {
            $this->doPOSTLoginNoAuth();
        }
//        $testLogin = 

        $merge_array_key = $this->queryParamURL($p_TargetURL);
        $page_url = strtok($p_TargetURL, '?');
//        $this->getRefreshedToken();
        $merge_param_token = array("token" => $_SESSION[SESSION_ADMIN_TOKEN]);
//        print_r($merge_param_token);
        $merge_param = array_merge($param, $merge_array_key, $merge_param_token);
//        $merge_header = array(IApplicationConstant::SESSION_TOKEN_NAME . ": " . $_SESSION[SESSION_ADMIN_TOKEN]);
        $merge_header = array();
        $rs_url = new RestClient();
        $response = $rs_url->to($page_url)
                ->setParam($merge_param)
                ->setHeader(array_merge($merge_header, $header))
                ->setBody($body)
                ->post();

//        echo $_SESSION[IApplicationConstant::SESSION_USER][IApplicationConstant::TOKEN];
//        print_r($response);
        if (isset(json_decode($response->getBody)->error)) {
            $this->failGetBearer(json_decode($response->getBody)->error);
//            $this->setSessionFromBearer(json_decode($response->getHeader)->Authorization);
            return false;
        } else {
            $headers = json_decode($response->getHeader);
//            $bear_exp = explode('', $headers->Authorization);
//            print_r($headers);
            if (isset($headers->Authorization)) {
                $this->setSessionFromBearer($headers->Authorization);
            }
        }
        return $response;
    }

    public function doDelete($p_TargetURL, $param = array(), $header = array(), $body = array()) {
        if (isset($_SESSION[SESSION_ADMIN_TOKEN])) {
            if ($_SESSION[SESSION_ADMIN_TOKEN] == "") {
                $this->doPOSTLoginNoAuth();
            }
        } else {
            $this->doPOSTLoginNoAuth();
        }
//        $testLogin = 

        $merge_array_key = $this->queryParamURL($p_TargetURL);
        $page_url = strtok($p_TargetURL, '?');
//        $this->getRefreshedToken();
        $merge_param_token = array("token" => $_SESSION[SESSION_ADMIN_TOKEN]);
        $merge_param = array_merge($param, $merge_array_key, $merge_param_token);
//        $merge_header = array(IApplicationConstant::SESSION_TOKEN_NAME . ": " . $_SESSION[SESSION_ADMIN_TOKEN]);
        $merge_header = array();
        $rs_url = new RestClient();
        $response = $rs_url->to($page_url)
                ->setParam($merge_param)
                ->setHeader(array_merge($merge_header, $header))
                ->setBody($body)
                ->delete();
//        echo $_SESSION[IApplicationConstant::SESSION_USER][IApplicationConstant::TOKEN];
//        print_r($response);
        if (isset(json_decode($response->getBody)->error)) {
            $this->failGetBearer(json_decode($response->getBody)->error);
//            $this->setSessionFromBearer(json_decode($response->getHeader)->Authorization);
            return false;
        } else {
            $headers = json_decode($response->getHeader);
//            $bear_exp = explode('', $headers->Authorization);
            if (isset($headers->Authorization)) {
                $this->setSessionFromBearer($headers->Authorization);
            }
        }
        return $response;
    }

    public function doPut($p_TargetURL, $param = array(), $header = array(), $body = array()) {
        if (isset($_SESSION[SESSION_ADMIN_TOKEN])) {
            if ($_SESSION[SESSION_ADMIN_TOKEN] == "") {
                $this->doPOSTLoginNoAuth();
            }
        } else {
            $this->doPOSTLoginNoAuth();
        }
//        $testLogin = 

        $merge_array_key = $this->queryParamURL($p_TargetURL);
        $page_url = strtok($p_TargetURL, '?');
//        $this->getRefreshedToken();
        $merge_param_token = array("token" => $_SESSION[SESSION_ADMIN_TOKEN]);
        $merge_param = array_merge($param, $merge_array_key, $merge_param_token);
//        $merge_header = array(IApplicationConstant::SESSION_TOKEN_NAME . ": " . $_SESSION[SESSION_ADMIN_TOKEN]);
        $merge_header = array();
        $rs_url = new RestClient();
        $response = $rs_url->to($page_url)
                ->setParam($merge_param)
                ->setHeader(array_merge($merge_header, $header))
                ->setBody($body)
                ->put();
//        echo $_SESSION[IApplicationConstant::SESSION_USER][IApplicationConstant::TOKEN];
//        print_r($response);
        if (isset(json_decode($response->getBody)->error)) {
            $this->failGetBearer(json_decode($response->getBody)->error);
//            $this->setSessionFromBearer(json_decode($response->getHeader)->Authorization);
            return false;
        } else {
            $headers = json_decode($response->getHeader);
//            $bear_exp = explode('', $headers->Authorization);
            if (isset($headers->Authorization)) {
                $this->setSessionFromBearer($headers->Authorization);
            }
        }
        return $response;
    }

    public function getRefreshedToken() {
        $this->token = $this->sessionClient->getRefreshedToken();
    }

}
