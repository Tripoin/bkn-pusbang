<?php

use app\Util\PasswordLib\TripoinCrypt;
use app\Util\Database;
use app\Model\SecurityUserProfile;
use app\Model\MasterContact;
use app\Model\SecurityUser;

$tripoinCrypt = new TripoinCrypt();
//$tripoinCrypt->encrypt($p_DataToEncrypt);
$decrypt = $tripoinCrypt->decrypt($_SESSION[SESSION_AUTHORIZATION_GUEST]);
$data_explode = explode(":", $decrypt);

$username = $data_explode[0];
$password = $data_explode[1];
$ckfile = tempnam("/tmp", "CURLMOODCOOKIE");


//set POST variables
$url_elearning = 'http://54.251.168.102/e-learning/login/index.php';
//$fields_string = 'username=' . $username . '&password=';
//$fields_string .=$password . '&rememberusername=1&Login';
//
//rtrim($fields_string, '&');
/* define('DB_HOST', '54.251.168.102');
  define('DB_USER', 'bkn');
  define('DB_PASS', 'bknP@ssw0rd123');
  define('DB_NAME', 'e_portal');
  define('DB_DRIVER', 'mysqli');
 * 
 */
$securityUser = new SecurityUser();
$securityUserProfile = new SecurityUserProfile();
$masterContact = new MasterContact();

$db = new Database();


$db2 = new Database();
$db2->setDb_driver('mysqli');
$db2->setDb_host('localhost');
//$db2->setDb_host('54.251.168.102');
$db2->setDb_user('bkn');
$db2->setDb_pass('bknP@ssw0rd123');
$db2->setDb_name('e_learning');
$db2->connect();

$db2->select('mdl_user', "username", array(), "username='" . $username . "'");
$rs_user_moodle = $db2->getResult();
//print_r($rs_user_moodle);
$data_member = getUserMember();
$rs_contact = $db->selectByID($masterContact, $masterContact->getId() . equalToIgnoreCase($data_member[$securityUserProfile->getEntity()][$securityUserProfile->getContactId()]));
$phoneNumber = "";
if (!empty($rs_contact)) {
    $phoneNumber = $rs_contact[0][$masterContact->getPhoneNumber1()];
}
$result = true;
if (empty($rs_user_moodle)) {
    $name_exploded = explode(" ", $data_member[$securityUserProfile->getEntity()][$securityUserProfile->getName()]);
    $firstname = $name_exploded[0];
    $lastname = "";
    if (isset($name_exploded[1])) {
        $lastname = $name_exploded[1];
    }


    $db2->insert('mdl_user', array(
        "username" => $data_member[$securityUser->getEntity()][$securityUser->getCode()],
        "auth" => "manual",
        "confirmed" => "1",
        "policyagreed" => "0",
        "deleted" => "0",
        "suspended" => "0",
        "emailstop" => "0",
        "mnethostid" => "1",
        "password" => $data_member[$securityUser->getEntity()][$securityUser->getPassword()],
        "idnumber" => $data_member[$securityUser->getEntity()][$securityUser->getCode()],
        "email" => $data_member[$securityUser->getEntity()][$securityUser->getEmail()],
        "firstname" => $firstname,
        "lastname" => $lastname,
        "country" => "ID",
        "lang" => "en",
        "calendartype" => "gregorian",
        "timezone" => "Asia/Jakarta",
        "phone1" => $phoneNumber,
    ));
    $rs_insert_mdl_user = $db2->getResult();
//    print_r($rs_insert_mdl_user);
    if (is_numeric($rs_insert_mdl_user[0])) {
        $db2->insert('mdl_role_assignments', array(
            "roleid" => 5,
            "contextid" => "1",
            "modifierid" => "2",
            "userid" => $rs_insert_mdl_user[0],
                )
        );
        $rs_insert_mdl_role_assignment = $db2->getResult();
        if (is_numeric($rs_insert_mdl_user[0])) {
            $result = true;
        } else {
            $result = false;
        }
    } else {
        $result = false;
    }
} else {
    $result = true;
}
include_once getTemplatePath('page/content-page.html.php');
?>

<div id="content" class="container-fluid" style="padding-top: 130px;">
    <?php include_once FILE_PATH(PAGE_MEMBER_PATH); ?>

    <div class="signup col-md-9 member-page">
        <?php if ($result == true) { ?>
            <form
                id="moodleforms" target="iframess"
                method="post" action="<?= $url_elearning; ?>"
                >
                <input type="hidden" name="username" value="<?= $username; ?>"/>
                <input type="hidden" name="password" value="<?= $password; ?>"/>
                <input type="hidden" name="testcookies" value="1"/>
            </form>
            <iframe name="iframess" id="moodleframe" height="900" width="100%"></iframe>
            <script type="text/javascript">
                $(function () {
                    document.getElementById('moodleforms').submit();
                    setTimeout(
                            function () {
                                checkFrame();
                            }, 1);
                });
                function getParameterByName(url, name) {
                    if (!url) {
                        url = window.location.href;
                    }
                    name = name.replace(/[\[\]]/g, "\\$&");
                    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                            results = regex.exec(url);
                    if (!results)
                        return null;
                    if (!results[2])
                        return '';
                    return decodeURIComponent(results[2].replace(/\+/g, " "));
                }
                function checkFrame() {
                    var editFrame = document.getElementById('moodleframe');
                    var framehtml = $(editFrame).contents().find("html");
    //                    console.log(framehtml.find("body").find("#header").find('.header-top'));
    //                    if (typeof (framehtml.find("body").find("#header").find('.header-top')) == "undefined") {
    //                    console.log(framehtml.find("body").find("#header"));
                    if (framehtml.find("body").find("#header").length == 0) {
                        setTimeout(
                                function () {
                                    checkFrame();
                                }, 1);
                    } else {
    //                        alert("masuk");
                        var headerframe = framehtml.find("body").find("#header");
                        var usermenu = headerframe.find('.header-top').find('div').find('div').find('div').find('.usermenu');
                        var ulmenulogout = usermenu.find('#action-menu-0-menu').find('li');
                        var myArr = [];
                        ulmenulogout.each(function () {
    //                            myArr.push($(this).html());
                            myArr.push($(this).find('a').attr('href'));
                        });
    //                        console.log(myArr[7]);
    //                        framehtml.find("body").find("#header").remove();
    //                        framehtml.find("body").find("#footer").remove();
                        var sesskey = getParameterByName(myArr[7], 'sesskey');
                        $('#menu-logout-portal').attr('href', '<?= URL('page/logout'); ?>?sesskey=' + sesskey);
                        console.log(getParameterByName(myArr[7], 'sesskey'));
                        $.ajax({
                            type: "POST",
                            url: '<?= URL('e-learning/sesskey'); ?>',
                            data: 'sesskey='+sesskey,
                            success: function (data) {
                                console.log(data);
                            }
                        });
                    }
                }

            </script>
        <?php } ?>
    </div>
    <?php include_once FILE_PATH(END_PAGE_MEMBER_PATH); ?>
</div>

<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>
