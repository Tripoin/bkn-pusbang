<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Util\PasswordLib;

/**
 * Description of TripoinCrypt
 *
 * @author sfandrianah
 */
use app\Constant\IApplicationConstant;

class TripoinCrypt {
    //put your code here
    private $HASH_MODE = 'sha256';

    public function encrypt($p_DataToEncrypt){
        $iv = mcrypt_create_iv(
            mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
            MCRYPT_DEV_URANDOM
        );

        $encrypted = base64_encode(
            $iv .
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_128,
                hash($this->HASH_MODE, IApplicationConstant::APPLICATION_CRYPT, true),
                $p_DataToEncrypt,
                MCRYPT_MODE_CBC,
                $iv
            )
        );
        return $encrypted;
    }

    public function decrypt($p_DataToDecrypt){
        $data = base64_decode($p_DataToDecrypt);
        $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
        $decrypted = rtrim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128,
                hash($this->HASH_MODE, IApplicationConstant::APPLICATION_CRYPT, true),
                substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
                MCRYPT_MODE_CBC,
                $iv
            ),
            "\0"
        );
        return $decrypted;
    }
}
