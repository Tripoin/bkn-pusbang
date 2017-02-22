<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controller\Base;

/**
 * Description of Chat
 *
 * @author sfandrianah
 */
use app\Util\Database;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;

class Chat {

    public $dir;
    public $file_path;

    //put your code here
    public function __construct() {
        setLog(false);
        $this->dir = DIR_CHAT;
//        $this->file_path = $this->dir . $_SESSION[SESSION_USERNAME] . '-' . $admin . '/' . 'chat-' . date('Ymd') . '.txt';
    }

    public function sendChat() {

        ini_set("display_errors", "Off");
        $db = new Database();
        $db->insert_log = false;
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
        $db->connect();

        $user_post = $_POST['admin'];
        $message = $_POST['message'];

        $path_after = $_SESSION[SESSION_USERNAME] . '-' . $user_post;
        $file_path = $this->dir . $path_after . '/' . 'chat.txt';
        $path = FILE_PATH($file_path);

        if (file_exists(FILE_PATH($this->dir . $path_after))) {
//            if (file_exists(FILE_PATH($file_path))) {
            if (filesize($file_path) == 3145728) {
                file_put_contents($file_path);
            } else {
//                file_put_contents($file_path);
            }

//            }
        } else {
            mkdir(FILE_PATH($this->dir . $path_after));
            file_put_contents($file_path);
        }

//        $file_path = $this->dir . $user_post . '-' . $_SESSION[SESSION_USERNAME] . '/' . 'chat-' . date('Ymd') . '.txt';

        $inp = file_get_contents($path);
        if (empty($inp)) {
//            $data = '{"total":0,"item":';
//            $data = rtrim($data, ',');

            $query_admin = SELECT . 'up.*,u.' . $user->getCode() . ' as username ' . FROM . $user->getEntity() . ' as u ' . JOIN . $userProfile->getEntity() . ' as up' . ON
                    . 'u.' . $user->getId() . EQUAL . 'up.' . $user->getId() . WHERE
                    . 'u.' . $user->getCode() . EQUAL . "'" . $_SESSION[SESSION_USERNAME] . "'";
            $db->sql($query_admin);
            $rs_admin = $db->getResult();
//            $inp = file_get_contents($path);
//            $tempArray = json_decode($inp);
//            $hitung = count($tempArray->item) + 1;
            $datas2 = $_SESSION[SESSION_USERNAME] . ';' . $rs_admin[0][$userProfile->getFullname()] . ';' . date('Y-m-d') . ";" . date('h:i:s') . ";" . $_POST['message'] . PHP_EOL;
            $data = '[';
            $data .= '{"username":"' . $_SESSION[SESSION_USERNAME] . '",'
                    . '"fullname":"' . $rs_admin[0][$userProfile->getFullname()] . '",'
                    . '"date":"' . date('Y-m-d') . '",'
                    . '"time":"' . date('h:i:s') . '",'
                    . '"chat":"' . $_POST['message'] . '"'
                    . '}';
            $data .= ']';
            file_put_contents($path, $datas2);

            $file_path_staging = $this->dir . $path_after . '/' . 'chat-staging.txt';
            $path_staging = FILE_PATH($file_path_staging);
            $datas2_staging = $_SESSION[SESSION_USERNAME] . ';' . $rs_admin[0][$userProfile->getFullname()] . ';' . date('Y-m-d') . ";" . date('h:i:s') . ";" . $_POST['message'] . ";0" . PHP_EOL;
            file_put_contents($path_staging, $datas2_staging . PHP_EOL, FILE_APPEND | LOCK_EX);

            $data_1 = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data), true);
            $data_2 = json_encode($data_1);
            echo $data_2;
        } else {

            $query_admin = SELECT . 'up.*,u.' . $user->getCode() . ' as username ' . FROM . $user->getEntity() . ' as u ' . JOIN . $userProfile->getEntity() . ' as up' . ON
                    . 'u.' . $user->getId() . EQUAL . 'up.' . $user->getId() . WHERE
                    . 'u.' . $user->getCode() . EQUAL . "'" . $_SESSION[SESSION_USERNAME] . "'";
            $db->sql($query_admin);
            $rs_admin = $db->getResult();

//            $inp = file_get_contents($path);
//            $tempArray = json_decode($inp);
//            $hitung = count($tempArray->item) + 1;
            $data = '[';
            $data .= '{"username":"' . $_SESSION[SESSION_USERNAME] . '",'
                    . '"fullname":"' . $rs_admin[0][$userProfile->getFullname()] . '",'
                    . '"date":"' . date('Y-m-d') . '",'
                    . '"time":"' . date('h:i:s') . '",'
                    . '"chat":"' . $_POST['message'] . '"'
                    . '}';
            $data .= ']';

//            array_push($tempArray->item, $j_data);
//            $jsonData = json_encode($tempArray);
            $datas2 = $_SESSION[SESSION_USERNAME] . ';' . $rs_admin[0][$userProfile->getFullname()] . ';' . date('Y-m-d') . ";" . date('h:i:s') . ";" . $_POST['message'] . PHP_EOL;
            file_put_contents($path, $datas2 . PHP_EOL, FILE_APPEND | LOCK_EX);

            $file_path_staging = $this->dir . $path_after . '/' . 'chat-staging.txt';
            $path_staging = FILE_PATH($file_path_staging);
            $datas2_staging = '';
            if (!file_exists($path_staging)) {
                file_put_contents($path_staging, '');
            }
            if (filesize($path_staging) == 3000) {
                $con_stag = file_get_contents($path_staging);
                $exp_stag = explode(PHP_EOL, $con_stag);
                $noo = 0;
                foreach ($exp_stag as $value_stag) {
                    $exp_d_stag = explode(';', $value_stag);
                    if (!empty($value_stag)) {
                        if ($noo >= 1) {
                            $datas2_staging .= $exp_d_stag[0] . ';' . $exp_d_stag[1] . ';' . $exp_d_stag[2] . ";" . $exp_d_stag[3] . ";" . $exp_d_stag[4] . ";" . $exp_d_stag[5] . PHP_EOL;
                        }
                    }
                    $noo++;
                }
                $datas2_staging .= $_SESSION[SESSION_USERNAME] . ';' . $rs_admin[0][$userProfile->getFullname()] . ';' . date('Y-m-d') . ";" . date('h:i:s') . ";" . $_POST['message'] . ";0";
                file_put_contents($path_staging, $datas2_staging);
            } else {
                $datas2_staging = $_SESSION[SESSION_USERNAME] . ';' . $rs_admin[0][$userProfile->getFullname()] . ';' . date('Y-m-d') . ";" . date('h:i:s') . ";" . $_POST['message'] . ";0";
                file_put_contents($path_staging, $datas2_staging . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
            $data_1 = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data), true);
            $data_2 = json_encode($data_1);
            echo $data_2;
//            echo $data;
        }
        $file_path_user = $this->dir . '/' . 'chat-' . $user_post . '.txt';
        $path_user = FILE_PATH($file_path_user);
        $inp_user = file_get_contents($path_user);
        $expl_user = explode(PHP_EOL, $inp_user);
        $data_user = '';
        $total_all = 0;
        foreach ($expl_user as $ex_del) {
            if (!empty($ex_del)) {
                $val_user = explode(";", $ex_del);
                if ($val_user[4] >= 1) {
                    $total_all += 1;
                }
                if ($val_user[0] == $_SESSION[SESSION_USERNAME]) {
                    $last_totals = $val_user[4] + 1;
                    if ($val_user[4] == 0) {
                        $total_all += 1;
                    }
                    $data_user .= $val_user[0] . ';' . $val_user[1] . ";" . $val_user[2] . ";" . $message . ";" . $last_totals . ";" . date('Y-m-d h:i:s') . PHP_EOL;
                } else {
                    $data_user .= $val_user[0] . ';' . $val_user[1] . ";" . $val_user[2] . ";" . $val_user[3] . ";" . $val_user[4] . ";" . $val_user[5] . PHP_EOL;
                }
            }
        }
//        print_r($data_user);
        file_put_contents($path_user, $data_user);

        $file_path_total_admin = $this->dir . '/' . 'chat-total-' . $user_post . '.txt';
        $path_total_admin = FILE_PATH($file_path_total_admin);
        $inp_total_admin = file_get_contents($path_total_admin);
//        $inp_total_admin2 = intval($inp_total_admin) + 1;
        $exp_total = explode("|", $inp_total_admin);
        $hitung_total_chat = $exp_total[1] + 1;
        file_put_contents($path_total_admin, $total_all . "|" . $hitung_total_chat);
    }

    public function loadChat() {
//        echo 'masuk';
//        $path = FILE_PATH('uploads/chat/chat.txt');
//        $file_path = $this->dir . '/' . 'chat-' . date('Ymd') . '.txt';
        $file_path = FILE_PATH($this->dir . '/' . 'chat-total-' . $_SESSION[SESSION_USERNAME] . '.txt');
        if (file_exists($file_path)) {
//            echo 'masuk';
            $inp = file_get_contents($file_path);
            $exp_total = explode("|", $inp);
            if (empty($inp)) {
//                echo 'masuk';
//                $tempArray = json_decode($inp);
                $data = '{"total":' . $exp_total[0] . ',"total_chat":' . $exp_total[1] . ',"item":';
                $data .= '[';
//        foreach ($tempArray->item as $value) {
//            if (intval($value->no > $_POST['total'])) {
//                $data .= '{"username":"' . $value->username . '","chat":"' . $value->chat . '","no":"' . $value->no . '"},';
//            }
//        }
                $data = rtrim($data, ',');
                $data .= ']}';
            } else {
//                $tempArray = json_decode($inp);
//                $datas = '';
                $data = '{"total":' . $exp_total[0] . ',"total_chat":' . $exp_total[1] . ',"item":';
                $data .= '[';

                $file_paths = FILE_PATH($this->dir . '/' . 'chat-' . $_SESSION[SESSION_USERNAME] . '.txt');
                $inp2 = file_get_contents($file_paths);
                $expl = explode(PHP_EOL, $inp2);
//                echo $expl;
                foreach ($expl as $values) {
                    if (!empty($values)) {
                        $value = explode(';', $values);
                        $last_total = intval($value[4]);
//                        $datas .= $value[0] . ';' . $value[1] . ';' . $value[2] . ";" . $value[3] . ";"
//                                . $last_total . ";" . date('Y-m-d h:i:s') . PHP_EOL;
                        $data .= '{"username":"' . $value[0] . '",'
                                . '"fullname":"' . $value[1] . '",'
                                . '"path_img":"' . $value[2] . '",'
                                . '"last_chat":"' . $value[3] . '",'
                                . '"last_total":"' . $last_total . '",'
                                . '"last_date":"' . date('Y-m-d h:i:s') . '"'
                                . '},';
                    }
                }

//        foreach ($tempArray->item as $value) {
//            if (intval($value->no > $_POST['total'])) {
//                $data .= '{"username":"' . $value->username . '","chat":"' . $value->chat . '","no":"' . $value->no . '"},';
//            }
//        }
                $data = rtrim($data, ',');
                $data .= ']}';
            }
//            print_r($data);
        } else {
            $this->loadChatParentUsers();
        }
        $data_1 = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data), true);
        $data_2 = json_encode($data_1);
        echo $data_2;

//        echo $data;
    }

    function loadChatStaging() {
        $user_post = $_POST['admin'];
        $path_after = $_SESSION[SESSION_USERNAME] . '-' . $user_post;
        $file_path_staging = $this->dir . $path_after . '/' . 'chat-staging.txt';
        $path = FILE_PATH($file_path_staging);

        $inp = file_get_contents($path);
        $expl = explode(PHP_EOL, $inp);
        $datas2_staging = '';
        foreach ($expl as $val_chat2) {
            if (!empty($val_chat2)) {
                $val_chat = explode(';', $val_chat2);
                if ($val_chat[5] == 0) {
                    if ($val_chat[0] == $user_post) {
                        echo '<div class="bubble-chat chat-you">'
                        . '<span style="font-weight: bold;">' . $val_chat[1] . '</span>'
                        . '<br/>' . $val_chat[4] . ''
                        . '<br/><span style="font-size: 8px;color:#8b7b8b;">' . $val_chat[3] . '</span>'
                        . '</div>';
                        $datas2_staging .= $val_chat[0] . ';' . $val_chat[1] . ';' . $val_chat[2] . ";" . $val_chat[3] . ";" . $val_chat[4] . ";1" . PHP_EOL;
                    } else {
                        $datas2_staging .= $val_chat[0] . ';' . $val_chat[1] . ';' . $val_chat[2] . ";" . $val_chat[3] . ";" . $val_chat[4] . ";" . $val_chat[5] . PHP_EOL;
                    }
                }
            }
        }
        if (!empty($inp)) {
            file_put_contents($path, $datas2_staging);
        }

        $file_path_user = $this->dir . '/' . 'chat-' . $_SESSION[SESSION_USERNAME] . '.txt';
        $path_user = FILE_PATH($file_path_user);
        $inp_user = file_get_contents($path_user);
        $expl_user = explode(PHP_EOL, $inp_user);
        $data_user = '';
        $total_all = 0;
        $total_chat = 0;
        foreach ($expl_user as $ex_del) {
            if (!empty($ex_del)) {
                $val_user = explode(";", $ex_del);
                if ($val_user[4] >= 1) {
                    $total_all += 1;
                }
                if ($val_user[0] == $user_post) {
//                    $total_all = $total_all - 1;
                    $total_chat = $val_user[4];
//                    $last_totals = $val_user[4] + 1;
//                    $total_all += 1;
                    $data_user .= $val_user[0] . ';' . $val_user[1] . ";" . $val_user[2] . ";" . $val_user[3] . ";0;" . $val_user[5] . PHP_EOL;
                } else {
                    $data_user .= $val_user[0] . ';' . $val_user[1] . ";" . $val_user[2] . ";" . $val_user[3] . ";" . $val_user[4] . ";" . $val_user[5] . PHP_EOL;
                }
            }
        }
        file_put_contents($path_user, $data_user);

        $file_path_total_admin = $this->dir . '/' . 'chat-total-' . $_SESSION[SESSION_USERNAME] . '.txt';
        $path_total_admin = FILE_PATH($file_path_total_admin);
        $inp_total_admin = file_get_contents($path_total_admin);
//        $inp_total_admin2 = intval($inp_total_admin) + 1;
        $exp_total = explode("|", $inp_total_admin);
//        print_r($total_chat);
        $hitung_total_chat = $exp_total[1] - $total_chat;
        file_put_contents($path_total_admin, $total_all . "|" . $hitung_total_chat);
    }

    public function loadChatUsers() {
        ini_set("display_errors", "Off");
        $user_post = $_POST['admin'];

//        echo 'masuk';
//        $file_path = $this->file_path;
//        $count_item = 0;
        $path_after = $_SESSION[SESSION_USERNAME] . '-' . $user_post;
        $file_path = $this->dir . $path_after . '/' . 'chat.txt';
        $file_path_staging = $this->dir . $path_after . '/' . 'chat-staging.txt';
//        $file_path = $this->dir . $path_after . '/' . 'chat.txt';
        if (file_exists(FILE_PATH($this->dir . $path_after))) {
            if (!file_exists(FILE_PATH($file_path))) {
                file_put_contents(FILE_PATH($file_path), "");
            }
        } else {
            mkdir(FILE_PATH($this->dir . $path_after));
            file_put_contents(FILE_PATH($file_path), "");
            file_put_contents(FILE_PATH($file_path_staging), "");
        }
        $path = FILE_PATH($file_path);

        $inp = file_get_contents($path);
        if (empty($inp)) {
//            $data = '{"total":0,"total_chat":0,"item":';
//            $data .= '[';
//            $data = rtrim($data, ',');
//            $data .= ']}';
//            file_put_contents($path, $data);
//            echo '<input type="hidden" id="totalchat" value="0"/>';
//            echo '<input type="hidden" id="usernameadmin" value="' . $user_post . '"/>';
        } else {

//            $tempArray = json_decode($inp);
//            if (empty($tempArray)) {
//                
//            } else {
            /*   $data = '{"total":' . count($tempArray->item) . ',"item":';
              $data .= '[';
              foreach ($tempArray->item as $value) {
              if (intval($value->no > $_POST['total'])) {
              $data .= '{"username":"' . $value->username . '","chat":"' . $value->chat . '","no":"' . $value->no . '"},';
              }
              }

              $data = rtrim($data, ',');
              $data .= ']}'; */
//            $str = file_get_contents(FILE_PATH('uploads/chat/chat.txt'));
//            $json_chat = json_decode($inp, true); // decode the JSON into an associative array

            $expl = explode(PHP_EOL, $inp);
            foreach ($expl as $val_chat2) {
                if (strlen($val_chat2) != 0) {
                    $val_chat = explode(';', $val_chat2);
                    if (!empty($val_chat)) {
                        if ($val_chat[0] == $_SESSION[SESSION_USERNAME]) {
                            echo '<div class="bubble-chat chat-me">'
                            . '<span style="font-weight: bold;">' . $val_chat[1] . '</span>'
                            . '<br/>' . $val_chat[4]
                            . '<br/><span style="font-size: 8px;color:#8b7b8b;">' . $val_chat[3] . '</span>'
                            . '</div>';
                        } else if ($val_chat[0] == $user_post) {
                            echo '<div class="bubble-chat chat-you">'
                            . '<span style="font-weight: bold;">' . $val_chat[1] . '</span>'
                            . '<br/>' . $val_chat[4] . ''
                            . '<br/><span style="font-size: 8px;color:#8b7b8b;">' . $val_chat[3] . '</span>'
                            . '</div>';
                        }
                    }
                }
            }
//            }
//            echo '<input type="hidden" id="usernameadmin" value="' . $user_post . '"/>';

            $path_after = $_SESSION[SESSION_USERNAME] . '-' . $user_post;
            $file_path_staging = $this->dir . $path_after . '/' . 'chat-staging.txt';
            $path_staging = FILE_PATH($file_path_staging);

            $inp_stag = file_get_contents($path_staging);
            $expl_stag = explode(PHP_EOL, $inp_stag);
            $datas2_staging = '';
            foreach ($expl_stag as $val_chat2) {
                if (!empty($val_chat2)) {
                    $val_chat = explode(';', $val_chat2);
                    if ($val_chat[5] == 0) {
                        if ($val_chat[0] == $user_post) {
                            $datas2_staging .= $val_chat[0] . ';' . $val_chat[1] . ';' . $val_chat[2] . ";" . $val_chat[3] . ";" . $val_chat[4] . ";1" . PHP_EOL;
                        } else {
                            $datas2_staging .= $val_chat[0] . ';' . $val_chat[1] . ';' . $val_chat[2] . ";" . $val_chat[3] . ";" . $val_chat[4] . ";" . $val_chat[5] . PHP_EOL;
                        }
                    }
                }
            }
            if (!empty($inp_stag)) {
                file_put_contents($path_staging, $datas2_staging);
            }

//            echo '<input type="hidden" id="totalchat" value="' . count($tempArray->item) . '"/>';
        }



//        count($json_chat['item']);
//                        print_r($json);
//        echo $data;
    }

    public function loadChatParentUsers() {

//        ini_set("display_errors", "Off");
//        $admin = $_POST['admin'];
        $type = 3;

        $db = new Database();
        $db->insert_log = false;
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();

        $db->connect();
        $query_admin = SELECT . 'up.*,u.' . $user->getCode() . ' as username ' . FROM . $user->getEntity() . ' as u ' . JOIN . $userProfile->getEntity() . ' as up' . ON
                . 'u.' . $user->getId() . EQUAL . 'up.' . $user->getId() . WHERE . 'u.' . $user->getGroup()->getId() . EQUAL . $type;
        $db->sql($query_admin);
        $select_admin = $db->getResult();

        $file_path = $this->dir . '/' . 'chat-' . $_SESSION[SESSION_USERNAME] . '.txt';
        if (!file_exists(FILE_PATH($file_path))) {
            file_put_contents($file_path);
        }

        $file_path_total = $this->dir . '/' . 'chat-total-' . $_SESSION[SESSION_USERNAME] . '.txt';
        if (!file_exists(FILE_PATH($file_path_total))) {
            file_put_contents($file_path_total);
        }

        $path = FILE_PATH($file_path);
        $path_total = FILE_PATH($file_path_total);

        $inp = file_get_contents($path);
        $inp_total = file_get_contents($path_total);
//        $inp_total_admin2 = intval($inp_total_admin) + 1;
        $exp_total = explode("|", $inp_total);
//        $tempArray_admin = json_decode($inp, true);
        if (empty($inp)) {
            file_put_contents(FILE_PATH($file_path_total), '0|0');
            $data = '{"total":0,"total_chat:0","item":';
            $data .= '[';
//            $data = '[';
            $datas = '';
            foreach ($select_admin as $value) {

                $datas .= $value['username'] . ';' . $value[$userProfile->getFullname()] . ';' . $value[$userProfile->getPathimage()] . ";;0;" . date('Y-m-d h:i:s') . PHP_EOL;
                $data .= '{"username":"' . $value['username'] . '",'
                        . '"fullname":"' . $value[$userProfile->getFullname()] . '",'
                        . '"path_img":"' . $value[$userProfile->getPathimage()] . '",'
                        . '"last_chat":"",'
                        . '"last_total":"0",'
                        . '"last_date":"' . date('Y-m-d h:i:s') . '"'
                        . '},';

//                $data[] = array($value['username'], $value[$userProfile->getFullname()], $value[$userProfile->getPathimage()], "|", "|", 0);
            }
//            $datas = rtrim($datas, PHP_EOL);
            $data = rtrim($data, ',');
            $data .= ']}';
            file_put_contents($path, $datas);

            /* $data_admin = '{"username":"' . $_SESSION[SESSION_USERNAME] . '",
              "fullname":"' . $rs_admin[0][$userProfile->getFullname()] . '",
              "path_img":"' . $rs_admin[0][$userProfile->getPathimage()] . '",
              "last_chat":"' . $message . '",
              "last_total":1}';
              $j_data_admin = json_decode($data_admin);
              array_push($tempArray_admin['item'], $j_data_admin);
              $jsonData_admin = json_encode($tempArray_admin);
              file_put_contents($path_admin, $jsonData_admin); */
        } else {
            $expl = explode(PHP_EOL, $inp);
            $data = '{"total":' . $exp_total[0] . ',"total_chat":' . $exp_total[1] . ',"item":';
//            print_r($expl);
            $data .= '[';
            foreach ($expl as $val_chats) {
                $val_chat = explode(';', $val_chats);
//                print_r($val_chat);
//                foreach ($expl_ch as $val_chat) {
                /* $query_admin = SELECT . 'up.*,u.' . $user->getCode() . ' as username ' . FROM . $user->getEntity() . ' as u ' . JOIN . $userProfile->getEntity() . ' as up' . ON
                  . 'u.' . $user->getId() . EQUAL . 'up.' . $user->getId() . WHERE . 'u.' . $user->getGroup()->getId() . EQUAL . '3'
                  . " AND " . $user->getCode() . EQUAL . "'" . $val_chat[0] . "'";
                  $db->sql($query_admin);
                  $sel_user = $db->getResult();
                  if (empty($sel_user)) {
                  $data .= '{"username":"' . $val_chat[0] . '",'
                  . '"fullname":"' . $val_chat[1] . '",'
                  . '"path_img":"' . $val_chat[2] . '",'
                  . '"last_chat":"' . $val_chat[3] . '",'
                  . '"last_total":"' . $val_chat[4] . '",'
                  . '"last_date":"' . $val_chat[5] . '"'
                  . '},';
                  } else {
                  $data .= '{"username":"' . $val_chat[0] . '",'
                  . '"fullname":"' . $val_chat[1] . '",'
                  . '"path_img":"' . $val_chat[2] . '",'
                  . '"last_chat":"' . $val_chat[3] . '",'
                  . '"last_total":"' . $val_chat[4] . '",'
                  . '"last_date":"' . $val_chat[5] . '"'
                  . '},';
                  } */
                if (!empty($val_chats)) {
                    $data .= '{"username":"' . $val_chat[0] . '",'
                            . '"fullname":"' . $val_chat[1] . '",'
                            . '"path_img":"' . $val_chat[2] . '",'
                            . '"last_chat":"' . $val_chat[3] . '",'
                            . '"last_total":"' . $val_chat[4] . '",'
                            . '"last_date":"' . $val_chat[5] . '"'
                            . '},';
                }
            }
            $data = rtrim($data, ',');
            $data .= ']}';
//            print_r($data);
//            $tempArray = json_decode($data, true);
            $tempArray = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data), true);
            $db->connect();
//            $json_chat = json_decode($inp); // decode the JSON into an associative array
//            $amount_last_total = 0;
            $no = 0;
            $code_all = '';
            $datas = '';
            foreach ($tempArray['item'] as $val_chat) {
                $code_all .= "'" . $val_chat['username'] . "',";
            }
            $code_all_trim = rtrim($code_all, ',');
//            print_r($code_all_trim);
            $not_in_sql = '';
            if (empty($code_all_trim)) {
                $not_in_sql = "";
            } else {
                $not_in_sql = " AND u." . $user->getCode() . " NOT IN(" . $code_all_trim . ") ";
            }

            $query_admin_2 = SELECT . 'up.*,u.' . $user->getCode() . ' as username ' . FROM . $user->getEntity() . ' as u ' . JOIN . $userProfile->getEntity() . ' as up' . ON
                    . 'u.' . $user->getId() . EQUAL . 'up.' . $user->getId() . WHERE . 'u.' . $user->getGroup()->getId() . EQUAL . $type
                    . " " . $not_in_sql;
//            print_r($query_admin_2);
            $db->sql($query_admin_2);
            $sel_admin2 = $db->getResult();
//            print_r($query_admin_2);
//            $datas .= '{"total":' . $inp_total . ',"item":';
//            $datas .= '[';
            $datas = ',';
            $datas2 = '';
            foreach ($sel_admin2 as $val_admin2) {
//                $last_total = '';
//                if ($value['last_total'] != 0) {
//                    $last_total = $value['last_total'];
//                }
                $datas2 .= $val_admin2['username'] . ';' . $val_admin2[$userProfile->getFullname()] . ';' . $val_admin2[$userProfile->getPathimage()] . ";;0;" . date('Y-m-d h:i:s') . PHP_EOL;
                /* $data2 = '{"username":"' . $val_admin2['username'] . '",
                  "fullname":"' . $val_admin2[$userProfile->getFullname()] . '",
                  "path_img":"' . $val_admin2[$userProfile->getPathimage()] . '",
                  "last_chat":"","last_total":"0"}';
                  $j_data = json_decode($data2);
                  array_push($tempArray['item'], $j_data);

                 */
                $datas .= '{"username":"' . $val_admin2['username'] . '",'
                        . '"fullname":"' . $val_admin2[$userProfile->getFullname()] . '",'
                        . '"path_img":"' . $val_admin2[$userProfile->getPathimage()] . '",'
                        . '"last_chat":"",'
                        . '"last_total":"0",'
                        . '"last_date":"' . date('Y-m-d h:i:s') . '"'
                        . '},';
            }
            $datas = rtrim($datas, ',');
//            $datas2 = rtrim($datas2, PHP_EOL);
            $data = '{"total":' . $exp_total[0] . ',"total_chat":' . $exp_total[1] . ',"item":';
//            print_r($expl);
            $data .= '[';
            foreach ($expl as $val_chats) {
                if (!empty($val_chats)) {
                    $val_chat = explode(';', $val_chats);
                    $datas2 .= $val_chat[0] . ';' . $val_chat[1] . ';' . $val_chat[2] . ";" . $val_chat[3] . ";" . $val_chat[4] . ";" . $val_chat[5] . PHP_EOL;
//                print_r($val_chat);
//                foreach ($expl_ch as $val_chat) {
                    $last_date = rtrim($val_chat[5], " ");
                    $data .= '{"username":"' . $val_chat[0] . '",'
                            . '"fullname":"' . $val_chat[1] . '",'
                            . '"path_img":"' . $val_chat[2] . '",'
                            . '"last_chat":"' . $val_chat[3] . '",'
                            . '"last_total":"' . $val_chat[4] . '",'
                            . '"last_date":"' . $last_date . '"'
                            . '},';
//                    print_r($val_chat[5]);
                }
            }
            $data = rtrim($data, ',');
            $datas = rtrim($datas, ',');
//            if($datas)
            $data .= $datas . ']}';
//            print_r($datas2);
//            $jsonData = json_encode($tempArray);
//            foreach ($expl as $val_chats) {
//                $datas2 .= $val_chats . ';' . $val_admin2[$userProfile->getFullname()] . ';' . $val_admin2[$userProfile->getPathimage()] . ";;0;" . date('Y-m-d h:i:s') . PHP_EOL;
//            }
//            if (!empty($datas2)) {
            file_put_contents($path, $datas2);
//            }
//            $datas .= ']}';
//            $data = $datas;
        }
//        $data = file_get_contents($path);
//$data_1 = json_decode($data);
//$data_2 = json_encode($data_1);
//        ini_set("display_errors", "On");
        header('Content-Type: application/json');
        $data_1 = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data), true);
//        $data_1 = json_decode($data,true);
//        print_r($data);
        $data_2 = json_encode($data_1);
        echo $data_2;



//        count($json_chat['item']);
//                        print_r($json);
//        echo $data;
    }

}
