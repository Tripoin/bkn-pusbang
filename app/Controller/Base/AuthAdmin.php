<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author sfandrianah
 */

namespace app\Controller\Base;

use app\Util\RestClient;
use app\Util\Facebook\FacebookSession;
use app\Util\Facebook\FacebookRedirectLoginHelper;
use app\Util\Facebook\FacebookRequest;
use app\Util\Facebook\FacebookResponse;
use app\Util\Facebook\FacebookSDKException;
use app\Util\Facebook\FacebookRequestException;
use app\Util\Facebook\FacebookAuthorizationException;
use app\Util\Facebook\GraphObject;
use app\Util\Facebook\Entities\AccessToken;
use app\Util\Facebook\HttpClients\FacebookCurlHttpClient;
use app\Util\Facebook\HttpClients\FacebookHttpable;
use app\Util\Database;
use app\Model\SecurityUser;
use app\Model\SecurityUserProfile;
use app\Util\PHPMail\PHPMailer;
use app\Util\PasswordLib\TripoinCrypt;

class AuthAdmin {

    //put your code here
    public function __construct() {
        
    }

    public function login() {
        $this->loginProses();
    }

    public function register() {
        $this->registerProses();
    }

    public function registerProses() {
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
//        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];
        $code = explode("@", $email);
        $salt = substr(md5(uniqid(rand(), true)), 0, 9);
        $password_e = sha1($salt . sha1($salt . sha1($password)));


//        $user->setCode($code[0]);
//        $user->setEmail($email);
//        $user->setPassword($password_e);
//        $user->setSalt($salt);
//        print_r($user);
        $dbNew = new Database();
        $dbNew->connect();
//        $dbNew->insert($user->getEntity(),$user);

        $res_user = $dbNew->selectByID($user, $user->getEmail() . "='" . $email . "'");
        if ($password == $confirm) {
            if (empty($res_user)) {
                $dbNew->insert($user->getEntity(), array(
                    $user->getEmail() => $email,
                    $user->getCode() => $code[0],
//                    $user->getName() => $firstname . ' ' . $lastname,
                    $user->getPassword() => $password_e,
                    $user->getSalt() => $salt,
                    $user->getStatus() => 1,
                    $user->getApproved() => 1,
                    $user->getGroup()->getId() => 2,
                    $user->getCreatedOn() => date(DATE_FORMAT_PHP_DEFAULT),
                    $user->getCreatedByUsername() => $code[0],
                    $user->getCreatedByIp() => getClientIp(),
                ));
                $rsPostNew = $dbNew->getResult();
//        print_r($rsPostNew);
                if (!is_numeric($rsPostNew[0])) {
//            echo 'Login Failed';
                    echo toastAlert("error", lang('general.title_register_failed'), lang('general.message_register_failed'));
//            echo "<script>$(function(){ajaxPostModal('".URL('/page/login')."'); })</script>";
//            echo "<script>$(function(){window.history.back()})</script>";
//            echo "<script>$(function(){historyBackNoReset('".$_POST."')})</script>";
                } else {
                    $dbNew->insert($userProfile->getEntity(), array(
                        $userProfile->getId() => $rsPostNew[0],
                        $userProfile->getEmail() => $email,
                        $userProfile->getCode() => $code[0],
                        $userProfile->getTelp() => $telephone,
                        $userProfile->getFullname() => $firstname . ' ' . $lastname
                    ));
                    $rsPostNew_2 = $dbNew->getResult();
                    if (!is_numeric($rsPostNew_2[0])) {
                        echo toastAlert("error", lang('general.title_register_failed'), lang('general.message_register_failed'));
                    } else {
                        $_SESSION[SESSION_USERNAME] = $code[0];
                        $_SESSION[SESSION_EMAIL] = $email;
                        $_SESSION[SESSION_FULLNAME] = $firstname . ' ' . $lastname;
                        $_SESSION[SESSION_GROUP] = 2;
//                        $_SESSION[SESSION_ADMIN_PASSWORD] = $password;
//            echo '<h3 align="center">Login Sukses</h3>';
                        echo toastAlert("success", lang('general.title_register_success'), lang('general.message_register_success'));
                        echo '<script>window.location.href = "' . URL('') . '";</script>';
                    }
                }
            } else {
                echo toastAlert("error", lang('general.title_register_failed'), lang('general.message_register_failed_email'));
                echo "<script>$(function(){postAjaxGetValue('" . URL('/page/register') . "','modal-body-self','" . json_encode($_POST) . "'); })</script>";
            }
        } else {
            echo toastAlert("error", lang('general.title_register_failed'), lang('general.message_register_failed_not_same_password'));
            echo "<script>$(function(){postAjaxGetValue('" . URL('/page/register') . "','modal-body-self','" . json_encode($_POST) . "'); })</script>";
        }
    }

    function http_post_flds($url, $data, $headers = null) {
        $data = http_build_query($data);
        $opts = array('http' => array('method' => 'POST', 'content' => $data));

        if ($headers) {
            $opts['http']['header'] = $headers;
        }
        $st = stream_context_create($opts);
        $fp = fopen($url, 'rb', false, $st);

        if (!$fp) {
            return false;
        }
        return stream_get_contents($fp);
    }

    public function loginProses() {
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
//        $username = $_POST['username'];
        $code = $_POST['username'];
        $email = $_POST['username'];
        $password = $_POST['password'];
        $dbNew = new Database();
        $dbNew->connect();
//        AND (".$user->getPassword()." = SHA1(CONCAT(".$user->getSalt().", SHA1(CONCAT(".$user->getSalt().", SHA1('".$password."'))))) OR ".$user->getEmail()." = '".md5($password)."') 
        $dbNew->sql("SELECT * FROM " . $user->getEntity() . " 
            WHERE LOWER(" . $user->getCode() . ") = '" . $code . "' 
                AND " . $user->getGroupId() . " not in (1)
                AND " . $user->getStatus() . EQUAL . ONE);
        $rsPostNew = $dbNew->getResult();
//        print_r($rsPostNew);
//        echo 'masuk';
        if (empty($rsPostNew)) {
//            echo 'Login Failed';
//            echo toastAlert("error", "Login Failed", "Email Or Password Is Incorrect");
//            echo "<script>$(function(){postAjaxGetValue('".URL('/')."','page-login','".json_encode($_POST)."'); })</script>";
            $result = array("result" => "error", "title" => "Login Failed", "message" => "This User Is Not Registered");
            echo json_encode($result);
        } else {
            $user_profile = $dbNew->selectByID($userProfile, $userProfile->getId() . EQUAL . $rsPostNew[0][$user->getId()]);
            if ($rsPostNew[0][$user->getGroupId()] == 2) {
                $result = array("result" => "error", "title" => "Login Failed", "message" => "Email Or Password Is Incorrect");
                echo json_encode($result);
            } else {


//                $dbNew->selectByID($user->getEntity(), $user->getCode() . EQUAL . "'" . $code . "'");
//                $rsPostNews = $dbNew->getResult();
//                if ($rsPostNew[0][$user->getPassword()] == hash("sha256", $password . $rsPostNew[0][$user->getSalt()])) {

                if (password_verify($password, $rsPostNew[0][$user->getPassword()])) {
                    $_SESSION[SESSION_USERNAME] = $rsPostNew[0][$user->getCode()];
                    $_SESSION[SESSION_EMAIL] = $rsPostNew[0][$user->getEmail()];
                    $_SESSION[SESSION_FULLNAME] = $rsPostNew[0][$userProfile->getName()];
                    $_SESSION[SESSION_GROUP] = $rsPostNew[0][$user->getGroupId()];
                    $tripoinCrypt = new TripoinCrypt();
                    $crypt = $tripoinCrypt->encrypt($code . ':' . $password);
                    $_SESSION[SESSION_ADMIN_AUTHORIZATION] = $crypt;
//            echo '<h3 align="center">Login Sukses</h3>';
//            echo toastAlert("success", "Login Success", "You Have successfully login");

                    $result = array("result" => "success", "title" => "Login Success", "nexturl" => $_SERVER['HTTP_REFERER'], "message" => "You Have Successfully Login");
                    echo json_encode($result);
                } else {
                    $result = array("result" => "error", "title" => "Login Failed", "message" => "Email Or Password Is Incorrect");
                    echo json_encode($result);
                }
            }
            $_SESSION[SESSION_LOCK_SCREEN] = false;
        }
    }

    public function loginApplication() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $RestClient = new RestClient();
        $RestClient->to(URL_API_ECCOMERCE . '?action=login&rest=user')
                ->username($username)
                ->password($password)
                ->post();
        $response_decode = json_decode($RestClient->getBody);
        if ($response_decode->result == 0) {
            echo '
                <h5 class="text-danger text-center">' . lang('general.login_failed') . '</h5>
                <h6 class="text-inverse text-center">' . lang('general.login_failed_message') . '</h6>
                ';
        } else {
            $RestClient = new RestClient();
            $RestClient->to(URL_API_ECCOMERCE . '?action=profile&rest=user')
                    ->username($username)
                    ->password($password)
                    ->post();
            $response_decode_profile = json_decode($RestClient->getBody);
            $_SESSION[SESSION_USERNAME] = $username;
            $_SESSION[SESSION_FULLNAME] = $username;
            $_SESSION[SESSION_TOKEN] = $password;
            $_SESSION['profile'] = $response_decode_profile->item;
            echo '
                <h5 class="text-success text-center">' . lang('general.login_success') . '</h5>
                ';
            echo '<script>window.location.href = ".";</script>';
        }
    }

    public function loginPage() {
//        echo 'masuk';
        include FILE_PATH('/view/page/user/login.html.php');
    }

    public function registerPage() {
//        echo 'masuk';
        include FILE_PATH('/view/page/user/register.html.php');
    }

    public function forgotPasswordPage() {
//        echo 'masuk';
        if (isset($_GET['v'])) {
            $token = $_GET['v'];
            $exp_token = explode('-', $token);
            $user = new SecurityUser();
            $userProfile = new SecurityUserProfile();
            $dbNew = new Database();
            $dbNew->connect();
            $rsPostUser = $dbNew->selectByID($user, $user->getCode() . "='" . $exp_token[0] . "' AND " . $user->getPassword() . "='" . $exp_token[1] . "'");
            if (empty($rsPostUser)) {
                include FILE_PATH(PAGE_404);
            } else {
                include FILE_PATH('/view/page/user/forgot_password_member.html.php');
            }
        } else {
            include FILE_PATH('/view/page/user/forgot_password.html.php');
        }
    }

    public function changePassword() {
        $user = new SecurityUser();

        $password_new = $_POST['password_new'];
        $password_renew = $_POST['password_renew'];
        $token = $_POST['token'];

//        $username = $_POST['username'];

        if ($password_new == $password_renew) {
            $salt = substr(md5(uniqid(rand(), true)), 0, 9);
            $password_e = sha1($salt . sha1($salt . sha1($password_renew)));
            $exp_token = explode('-', $token);
            $dbNew = new Database();
            $dbNew->connect();
            $dbNew->update($user->getEntity(), array(
                $user->getPassword() => $password_e,
                $user->getSalt() => $salt
                    ), $user->getCode() . "='" . $exp_token[0] . "' AND " . $user->getPassword() . "='" . $exp_token[1] . "'");
            $rs_c_password = $dbNew->getResult();
            if ($rs_c_password[0] == 1) {
                echo resultPageMsg('success', lang('user.title_change_password_success'), lang('user.title_change_password_success'));
                echo '<script>window.location.href = "' . URL('') . '";</script>';
            } else {
                echo resultPageMsg('danger', lang('user.title_change_password_failed'), lang('user.title_change_password_failed'));
            }
        } else {
            echo resultPageMsg('danger', lang('user.title_change_password_failed'), lang('user.message_change_password_failed_not_same'));
        }
    }

    public function forgotPassword() {
        $user = new SecurityUser();
        $userProfile = new SecurityUserProfile();
//        $username = $_POST['username'];
        $email = $_POST['email'];
        $dbNew = new Database();
        $dbNew->connect();

        /* $dbNew->sql("SELECT * FROM " . $user->getEntity() . " 
          WHERE LOWER(" . $user->getEmail() . ") = '" . $email . "'
          AND (" . $user->getPassword() . " = SHA1(CONCAT(user_salt, SHA1(CONCAT(user_salt, SHA1('" . $password . "')))))
          OR " . $user->getEmail() . " = '" . md5($password) . "') AND status = '1' AND " . $user->getApproved() . " = '1'");
          $rsPostNew = $dbNew->getResult(); */

        $rsPostUP = $dbNew->selectByID($userProfile, $userProfile->getEmail() . "='" . $email . "'");
//        $rsPostUP = $dbNew->getResult();
//        print_r($rsPostUP);
        if (empty($rsPostUP)) {
//            echo 'Login Failed';
            echo toastAlert("error", lang('general.forgot_password_failed'), lang('general.email_not_registered'));
            echo "<script>$(function(){postAjaxGetValue('" . URL('/page/forgot-password') . "','modal-body-self','" . json_encode($_POST) . "'); })</script>";
        } else {
            $rsPostUP2 = $dbNew->selectByID($user, $user->getId() . "='" . $rsPostUP[0][$userProfile->getId()] . "'");
//            $rsPostUP2 = $dbNew->getResult();
            if (empty($rsPostUP2)) {
                echo toastAlert("error", lang('general.forgot_password_failed'), lang('general.email_not_registered') . $rsPostUP2[0]);
                echo "<script>$(function(){postAjaxGetValue('" . URL('/page/forgot-password') . "','modal-body-self','" . json_encode($_POST) . "'); })</script>";
            } else {

                $mail = new PHPMailer;

                $mail->isSMTP();

                $mail->Debugoutput = 'html';
//$mail->SMTPDebug = 2;
                $mail->Host = MAIL_HOST;

                /*       $mail->Port = 465;
                  $mail->SMTPSecure = 'ssl';
                  $mail->SMTPAuth = true;

                  $mail->Username = "talaindonesia2@gmail.com";
                  $mail->Password = "t4l4indonesia";
                 */
                $mail->Port = MAIL_SMTP_PORT;
                $mail->SMTPSecure = 'ssl';
                $mail->SMTPAuth = true;

                $mail->Username = MAIL_USERNAME;
                $mail->Password = MAIL_PASSWORD;

                $mail->isHTML(true);

//Set who the message is to be sent from
                $mail->setFrom(MAIL_USERNAME, MAIL_FULLNAME);

//Set an alternative reply-to address
                $mail->addReplyTo($email, $rsPostUP[0][$userProfile->getFullname()]);

//Set who the message is to be sent to
                $mail->addAddress($email, $rsPostUP[0][$userProfile->getFullname()]);
                $img_logo_tala = 'http://talaindonesia.com/assets/images/logo.png';
                $mail->Subject = 'Validasi Reset Password';
                $mail->Body = '<div style="border-style: solid;border-width: thin;font-family: \'Roboto\';">
                      <div align="center" style="margin:15px;"><img src="' . $img_logo_tala . '" width="70" height="40"/></div>
                        <div align="left" style="margin:15px;">
                            Halo ' . $rsPostUP[0][$userProfile->getFullname()] . ',
                        <br/><br/>
                        Kami menerima permintaan melakukan reset password Anda. Jika Anda merasa tidak melakukan ini, mohon abaikan saja email ini. Email ini tidak akan berguna setelah 2 jam.
                        <br/><br/>
                        Untuk melakukan reset password Anda, silahkan klik link dibawah:
                        <br/><br/>
                        <a href="' . URL('/page/forgot-password?v=' . $rsPostUP2[0][$user->getCode()] . '-' . $rsPostUP2[0][$user->getPassword()]) . '" target="_blank">' . URL('/page/forgot-password?v=' . $rsPostUP2[0][$user->getCode()] . '-' . $rsPostUP2[0][$user->getPassword()]) . '</a>
                        <br/><br/>
                        Setelah Anda meng-klik link di atas, password Anda akan direset dan kemudian sebuah password baru akan dikirimkan ke email Anda.
                        <br/><br/>
                        Terimakasih
                        <br/><br/>
                        ' . MAIL_FULLNAME . '
                        <br/>
                        <a href="' . URL('') . '" target="_blank">' . URL('') . '</a>
                        </div>
                        </div>
                            ';
                if ($mail->smtpConnect()) {
                    $mail->smtpClose();
                    //echo "Connected";
                    if (!$mail->send()) {
                        // echo "1" . $mail->ErrorInfo;
//                echo json_encode($statusgagal);
//                        return 'GAGAL';
                        echo toastAlert("error", lang('general.forgot_password_failed'), $mail->ErrorInfo);
                        echo "<script>$(function(){postAjaxGetValue('" . URL('/page/forgot-password') . "','modal-body-self','" . json_encode($_POST) . "'); })</script>";
                    } else {
//                echo json_encode($status);
//                        return 'SUKSES';
//                        echo toastAlert("success", lang('general.send_email_success'), lang('general.send_email_success_msg'));
//                        echo "<script>$(function(){postAjaxGetValue('" . URL('/page/forgot-password') . "','modal-body-self','" . json_encode($_POST) . "'); })</script>";
                        echo resultPageMsg('success', lang('general.send_email_success'), lang('general.send_email_success_msg'));
                    }
                } else {
//            echo json_encode($statusgagal);
//            echo "Connection Failed";
//                    return 'GAGAL';
                    echo toastAlert("error", lang('general.forgot_password_failed'), lang('general.not_connected'));
                    echo "<script>$(function(){postAjaxGetValue('" . URL('/page/forgot-password') . "','modal-body-self','" . json_encode($_POST) . "'); })</script>";
                }

//                echo '<script>window.location.href = "' . URL('') . '";</script>';
            }
        }
    }

    public function loginfacebook() {

        FacebookSession::setDefaultApplication(APP_ID, APP_SECRET);
        $helper = new FacebookRedirectLoginHelper(URL('/page/user/login?type=2'));
        try {
            $session = $helper->getSessionFromRedirect();
        } catch (FacebookRequestException $ex) {
            // When Facebook returns an error
        } catch (Exception $ex) {

            // When validation fails or other local issues
        }
        if (isset($session)) {

            // graph api request for user data
            $request = new FacebookRequest($session, 'GET', '/me');
            $response = $request->execute();
//            print_r($response);
            // get response
            $graphObject = $response->getGraphObject();
            $token = $response->getRequest()->getSession()->getAccessToken();
//            print_r($response->getRequest()->getSession()->getAccessToken());
            $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
            $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
//            $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
            /* ---- Session Variables ----- */
            $_SESSION[SESSION_USERNAME] = $fbid;
            $_SESSION[SESSION_FULLNAME] = $fbfullname;
            $_SESSION[SESSION_TOKEN] = $token;
            echo "<script>
            window.close();
            window.opener.location.reload();
        </script>";
//            echo 'masuk';
            /* ---- header location after session ---- */
//            checkuser($fbid,$fbfullname,$femail);
//  header("Location: index.php");
        } else {
            $loginUrl = $helper->getLoginUrl();
            header("Location: " . $loginUrl);
        }
    }

    public function logout() {
//        ini_set("display_errors", "Off");
        if (isset($_GET['sesskey'])) {
//            unset($_COOKIE['MoodleSession']);

            $url = "http://54.251.168.102/e-learning/login/logout.php";
            ?>
            <form
                id="moodleformlogout" target="iframe"
                method="GET" action="<?= $url; ?>"
                >
                <input type="hidden" name="sesskey" value="<?= $_GET['sesskey']; ?>"/>
            </form>
            <iframe name="iframe" id="moodleframelogout" height="0" width="0"></iframe>
            <script>
                document.getElementById('moodleformlogout').submit();
            </script>
            <?php
        }
        session_destroy();
        if (isset($_SESSION[SESSION_ADMIN_USERNAME])) {
            unset($_SESSION[SESSION_ADMIN_USERNAME]);
        }
        if (isset($_SESSION[SESSION_ADMIN_EMAIL])) {
            unset($_SESSION[SESSION_ADMIN_EMAIL]);
        }
        if (isset($_SESSION[SESSION_ADMIN_FULLNAME])) {
            unset($_SESSION[SESSION_ADMIN_FULLNAME]);
        }
        if (isset($_SESSION[SESSION_ADMIN_GROUP])) {
            unset($_SESSION[SESSION_ADMIN_GROUP]);
        }
        if (isset($_SESSION[SESSION_ADMIN_TOKEN])) {
            unset($_SESSION[SESSION_ADMIN_TOKEN]);
        }
        if (isset($_SESSION[SESSION_ADMIN_AUTHORIZATION])) {
            unset($_SESSION[SESSION_ADMIN_AUTHORIZATION]);
        }
        $admin_url = getAdminTheme();
        echo '<script>window.location.href = "' . URL($admin_url) . '";</script>';
    }

    public function lockScreen() {
        ini_set("display_errors", "Off");
        $_SESSION[SESSION_LOCK_SCREEN] = true;
        $admin_url = getAdminTheme();
        echo '<script>window.location.href = "' . URL($admin_url) . '";</script>';
    }

}
