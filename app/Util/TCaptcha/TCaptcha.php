<?php

namespace app\Util\TCaptcha;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TCaptcha => Tripoin Captcha
 * 
 *
 * @author sfandrianah
 */
use app\Util\Form;

class TCaptcha {

    //put your code here
    function simple_php_captcha($config = array()) {

        // Check for GD library
        if (!function_exists('gd_info')) {
            throw new Exception('Required GD library is missing');
        }

        $bg_path = dirname(__FILE__) . '/backgrounds/';
        $font_path = dirname(__FILE__) . '/fonts/';
//        echo $bg_path;
        // Default values
        $captcha_config = array(
            'code' => '',
            'min_length' => 5,
            'max_length' => 5,
            'backgrounds' => array(
                $bg_path . '45-degree-fabric.png',
                $bg_path . 'cloth-alike.png',
                $bg_path . 'grey-sandbag.png',
                $bg_path . 'kinda-jean.png',
                $bg_path . 'polyester-lite.png',
                $bg_path . 'stitched-wool.png',
                $bg_path . 'white-carbon.png',
                $bg_path . 'white-wave.png'
            ),
            'fonts' => array(
                $font_path . 'times_new_yorker.ttf'
            ),
            'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
            'min_font_size' => 28,
            'max_font_size' => 28,
            'color' => '#666',
            'angle_min' => 0,
            'angle_max' => 10,
            'shadow' => true,
            'shadow_color' => '#fff',
            'shadow_offset_x' => -1,
            'shadow_offset_y' => 1
        );

        // Overwrite defaults with custom config values
        if (is_array($config)) {
            foreach ($config as $key => $value)
                $captcha_config[$key] = $value;
        }

        // Restrict certain values
        if ($captcha_config['min_length'] < 1)
            $captcha_config['min_length'] = 1;
        if ($captcha_config['angle_min'] < 0)
            $captcha_config['angle_min'] = 0;
        if ($captcha_config['angle_max'] > 10)
            $captcha_config['angle_max'] = 10;
        if ($captcha_config['angle_max'] < $captcha_config['angle_min'])
            $captcha_config['angle_max'] = $captcha_config['angle_min'];
        if ($captcha_config['min_font_size'] < 10)
            $captcha_config['min_font_size'] = 10;
        if ($captcha_config['max_font_size'] < $captcha_config['min_font_size'])
            $captcha_config['max_font_size'] = $captcha_config['min_font_size'];

        // Generate CAPTCHA code if not set by user
        if (empty($captcha_config['code'])) {
            $captcha_config['code'] = '';
            $length = mt_rand($captcha_config['min_length'], $captcha_config['max_length']);
            while (strlen($captcha_config['code']) < $length) {
                $captcha_config['code'] .= substr($captcha_config['characters'], mt_rand() % (strlen($captcha_config['characters'])), 1);
            }
        }
        $image_src = URL('captcha/search?_CAPTCHA&amp;t=' . urlencode(microtime()));

        // Generate HTML for image src
        /*   if (strpos($_SERVER['SCRIPT_FILENAME'], $_SERVER['DOCUMENT_ROOT'])) {
          $image_src = URL('captcha/search?_CAPTCHA&amp;t=' . urlencode(microtime()));
          //            $image_src = '/' . ltrim(preg_replace('/\\\\/', '/', $image_src), '/');
          } else {
          $_SERVER['WEB_ROOT'] = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME']);
          $image_src = substr(__FILE__, strlen(realpath($_SERVER['WEB_ROOT']))) . '?_CAPTCHA&amp;t=' . urlencode(microtime());
          //            $image_src = '/' . ltrim(preg_replace('/\\\\/', '/', $image_src), '/');
          }
         */
        $_SESSION['_CAPTCHA']['config'] = serialize($captcha_config);

        return array(
            'code' => $captcha_config['code'],
            'image_src' => $image_src
        );
    }

//if( !function_exists('hex2rgb') ) {
    function hex2rgb($hex_str, $return_string = false, $separator = ',') {
        $hex_str = preg_replace("/[^0-9A-Fa-f]/", '', $hex_str); // Gets a proper hex string
        $rgb_array = array();
        if (strlen($hex_str) == 6) {
            $color_val = hexdec($hex_str);
            $rgb_array['r'] = 0xFF & ($color_val >> 0x10);
            $rgb_array['g'] = 0xFF & ($color_val >> 0x8);
            $rgb_array['b'] = 0xFF & $color_val;
        } elseif (strlen($hex_str) == 3) {
            $rgb_array['r'] = hexdec(str_repeat(substr($hex_str, 0, 1), 2));
            $rgb_array['g'] = hexdec(str_repeat(substr($hex_str, 1, 1), 2));
            $rgb_array['b'] = hexdec(str_repeat(substr($hex_str, 2, 1), 2));
        } else {
            return false;
        }
        return $return_string ? implode($separator, $rgb_array) : $rgb_array;
    }

//}
// Draw the image
//if( isset($_GET['_CAPTCHA']) ) {
    public function getCaptcha() {
//        session_start();
//        sleep(5);
        if (!isset($_SESSION['_CAPTCHA'])) {
//        if(!isset($_SESSION[SESSION_CAPTCHA])){
//            $_SESSION['_CAPTCHA'] = $this->simple_php_captcha();
            $_SESSION[SESSION_CAPTCHA] = $this->simple_php_captcha();
        }
//        print_r($this->simple_php_captcha());
        $captcha_config = unserialize($_SESSION['_CAPTCHA']['config']);
        if (!$captcha_config)
            exit();
//        print_r($_SESSION['_CAPTCHA']);
        unset($_SESSION['_CAPTCHA']);

        // Pick random background, get info, and start captcha
        $background = $captcha_config['backgrounds'][mt_rand(0, count($captcha_config['backgrounds']) - 1)];
        list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($background);

        $captcha = imagecreatefrompng($background);

        $color = $this->hex2rgb($captcha_config['color']);
        $color = imagecolorallocate($captcha, $color['r'], $color['g'], $color['b']);

        // Determine text angle
        $angle = mt_rand($captcha_config['angle_min'], $captcha_config['angle_max']) * (mt_rand(0, 1) == 1 ? -1 : 1);

        // Select font randomly
        $font = $captcha_config['fonts'][mt_rand(0, count($captcha_config['fonts']) - 1)];

        // Verify font file exists
        if (!file_exists($font))
            throw new Exception('Font file not found: ' . $font);

        //Set the font size.
        $font_size = mt_rand($captcha_config['min_font_size'], $captcha_config['max_font_size']);
        $text_box_size = imagettfbbox($font_size, $angle, $font, $captcha_config['code']);

        // Determine text position
        $box_width = abs($text_box_size[6] - $text_box_size[2]);
        $box_height = abs($text_box_size[5] - $text_box_size[1]);
        $text_pos_x_min = 0;
        $text_pos_x_max = ($bg_width) - ($box_width);
        $text_pos_x = mt_rand($text_pos_x_min, $text_pos_x_max);
        $text_pos_y_min = $box_height;
        $text_pos_y_max = ($bg_height) - ($box_height / 2);
        if ($text_pos_y_min > $text_pos_y_max) {
            $temp_text_pos_y = $text_pos_y_min;
            $text_pos_y_min = $text_pos_y_max;
            $text_pos_y_max = $temp_text_pos_y;
        }
        $text_pos_y = mt_rand($text_pos_y_min, $text_pos_y_max);

        // Draw shadow
        if ($captcha_config['shadow']) {
            $shadow_color = $this->hex2rgb($captcha_config['shadow_color']);
            $shadow_color = imagecolorallocate($captcha, $shadow_color['r'], $shadow_color['g'], $shadow_color['b']);
            imagettftext($captcha, $font_size, $angle, $text_pos_x + $captcha_config['shadow_offset_x'], $text_pos_y + $captcha_config['shadow_offset_y'], $shadow_color, $font, $captcha_config['code']);
        }

        // Draw text
        imagettftext($captcha, $font_size, $angle, $text_pos_x, $text_pos_y, $color, $font, $captcha_config['code']);
//echo 'asuuu';
        // Output image
//        header("Content-type: image/png");
//        imagepng($captcha, dirname(__FILE__) . $_SESSION[SESSION_CAPTCHA] . '.png');
//        header("Content-type: image/png");
//        imagepng($captcha);
//        ob_start();
//        imagepng($captcha);
//        $image_data = ob_get_contents();
//        ob_end_clean();
//        $image_data_base64 = base64_encode($image_data);
//        $captcha = 
        $image_data_base64 = $this->gdImgToHTML($captcha, 'png');
        return $image_data_base64;
//        echo 'fu';
//        echo imagepng($captcha);
//        return $data_captcha;
    }

    function gdImgToHTML($gdImg, $format = 'jpg') {

        // Validate Format
        if (in_array($format, ['jpg', 'jpeg', 'png', 'gif'])) {

            ob_start();

            if ($format == 'jpg' || $format == 'jpeg') {

                imagejpeg($gdImg);
            } elseif ($format == 'png') {

                imagepng($gdImg);
            } elseif ($format == 'gif') {

                imagegif($gdImg);
            }

            $data = ob_get_contents();
            ob_end_clean();

            // Check for gd errors / buffer errors
            if (!empty($data)) {

                $data = base64_encode($data);

                // Check for base64 errors
                if ($data !== false) {

                    // Success
                    return "<img src='data:image/$format;base64,$data'>";
                }
            }
        }

        // Failure
        return '<img>';
    }

    public function reloadCaptcha() {
//        $this->getCaptcha();
//        $test = $this->simple_php_captcha();
//        $_SESSION[SESSION_CAPTCHA] = $test;
//        $path_image = dirname(__FILE__) . $_SESSION[SESSION_CAPTCHA] . '.png';
//        $type = pathinfo($path_image, PATHINFO_EXTENSION);
//        $data = file_get_contents($path_image);
//        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
//        print_r($test);
//        $captcha = '<img src="' . $_SESSION[SESSION_CAPTCHA]['image_src'] . '" alt="CAPTCHA code"></div>';
        $image = $this->getCaptcha();
//        $base64 = 'data:image/png;base64,' . base64_encode($image);
//        $captcha = '<img src="' . $base64 . '" alt="CAPTCHA code"></div>';
        echo $image;
    }

}
