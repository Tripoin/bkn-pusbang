<!DOCTYPE HTML>
<html>
    <head>
        <title><?= FRAMEWORK_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?= URL('view/404/glossy/css/style.css'); ?>" rel="stylesheet" type="text/css" media="all"/>
        <link href='http://fonts.googleapis.com/css?family=Fenix' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class="wrap">
            <div class="main">
                <h3><?= COMPANY_NAME; ?></h3>
                <h1>Oops Could not found
                    <?php
//                    $error = error_get_last();
//                    print_r($error);
                    ?></h1>
                <p>There's a lot of reasons why this page is<span class="error"> 404</span>.<br>
                    <span>Don't waste your time enjoying the look of it</span></p>
                <div class="search">
                    <form>
                        <input type="text" onfocus="this.value = '';" onblur="if (this.value == '') {
                                    this.value = 'Enter ur email';
                                }" value="Enter ur email">
                        <input type="submit" value="Submit">		
                    </form>
                </div>
                <div class="icons">
                    <p>Follow us on:</p>
                    <ul>
                        <li><a href="#"><img src="<?= URL('view/404/glossy/images/img1.png'); ?>"></a></li>
                        <li><a href="#"><img src="<?= URL('view/404/glossy/images/img2.png'); ?>"></a></li>
                        <li><a href="#"><img src="<?= URL('view/404/glossy/images/img3.png'); ?>"></a></li>
                        <li><a href="#"><img src="<?= URL('view/404/glossy/images/img4.png'); ?>"></a></li>
                        <li><a href="#"><img src="<?= URL('view/404/glossy/images/img5.png'); ?>"></a></li>
                    </ul>	
                </div>
            </div>
            <div class="footer">
                <p>
                    <?= TEXT_COPYRIGHT; ?>
                </p>
            </div>
        </div>
    </body>
</html>

