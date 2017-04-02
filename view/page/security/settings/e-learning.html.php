<?php
use app\Util\PasswordLib\TripoinCrypt;

$tripoinCrypt = new TripoinCrypt();
$decrypt = $tripoinCrypt->decrypt($_SESSION[SESSION_ADMIN_AUTHORIZATION]);
$data_explode = explode(":", $decrypt);

$username = $data_explode[0];
$password = $data_explode[1];
$ckfile = tempnam("/tmp", "CURLMOODCOOKIE");


//set POST variables
$url = 'http://54.251.168.102/e-learning/login/index.php';
//$url = 'http://127.0.0.1/e-learning/login/index.php';
$fields_string = 'username=' . $username . '&password=';
$fields_string .=$password . '&rememberusername=1&Login';

rtrim($fields_string, '&');

//        echo $fields_string . '';
//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);


//execute post
$content = curl_exec($ch);
$response = curl_getinfo($ch);

//        echo 'response=';
//        echo 'content=' . $content;
//close connection
curl_close($ch);
?>
<!doctype html>
<html lang="en">
    <?= contentPage(); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php
            
            
//            echo $_COOKIE['MoodleSession'];
//            print_r($ckfile);
//            print_r($response);
//            echo $content;
//            global $USER;
//            $sesskey = $USER->sesskey;
//            print_r($sesskey);
            ?>
            <form
                id="moodleform" target="iframe"
                method="post" action="<?= $url; ?>"
                >
                <input type="hidden" name="username" value="<?= $username; ?>"/>
                <input type="hidden" name="password" value="<?= $password; ?>"/>
                <input type="hidden" name="testcookies" value="1"/>
            </form>
            <iframe name="iframe" id="moodleframe" height="900" width="100%"></iframe>
            <script type="text/javascript">
                document.getElementById('moodleform').submit();
                $(function () {
//                    checkFrame();
                    setTimeout(
                            function () {
                                checkFrame();
                            }, 1);
                    /* setTimeout(function () {
                     var editFrame = document.getElementById('moodleframe');
                     var framehtml = $(editFrame).contents().find("html");
                     var headerframe = framehtml.find("body").find("#header");
                     var usermenu = headerframe.find('.header-top').find('div').find('div').find('div').find('.usermenu');
                     var ulmenulogout = usermenu.find('#action-menu-0-menu').find('li');
                     var myArr = [];
                     ulmenulogout.each(function () {
                     //                            myArr.push($(this).html());
                     myArr.push($(this).find('a')attr('href'));
                     });
                     console.log(myArr);
                     //                        framehtml.find("body").find("#header").remove();
                     framehtml.find("body").find("#footer").remove();
                     //                        console.log(framehtml.html());
                     //                        alert(framehtml);
                     }, 7000);
                     */

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
                        framehtml.find("body").find("#header").remove();
                        framehtml.find("body").find("#footer").remove();
                        var sesskey = getParameterByName(myArr[7], 'sesskey');
                        $('[href="<?=URL(getAdminTheme().'/logout');?>"]').attr('href','<?=URL(getAdminTheme().'/logout');?>?sesskey='+sesskey);
                        console.log(getParameterByName(myArr[7], 'sesskey'));
                    }
                }
            </script>
            <?php // print_r($_COOKIE['MoodleSession']);?>
            <!--<iframe src="<?= $response['url']; ?>"  height="1200" width="1200"></iframe>-->
        </div>
    </div>
    <?= endContentPage(); ?>
</html>