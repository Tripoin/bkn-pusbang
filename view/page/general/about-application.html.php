<?php
$logo_login = URL('/assets/img/logotripoin.png');
?>
<!doctype html>
<html lang="en">
    <?= contentPage(); ?>
    <?= pageBody(); ?>
    <div class="row">
        <div class="col-md-12">
            <!--<h2 class="text-center">Tripoin Studio</h2>-->
            <div class="logo text-center">
                <a href="http://tripoin.co.id">
                    <img src="<?= $logo_login; ?>" height="150" alt="LOGO" /> 
                </a>
            </div>
            <h2 class="text-center">Tripoin E-Pusbang</h2>
            <h4 class="text-center">Version 1.0</h4>
            <h5 class="text-center">Copyright © 2017 Tripoin, Inc. All Rights Reserved. </h5>
            <br/>
            <br/>
            <br/>
            <h5 class="text-center">
                This Product is licensed by :
            </h5>
            <h6 class="text-center">
                Syahrial Fandrianah, Nurul Hidayat, Ridla Fadillah, Achmad Fauzi, Fadhil Paramanindo, Ginanjar Sanjaya, Agung Rizkiono<br/>
            </h6>
        </div>
    </div>
    <?= endPageBody(); ?>
    <?= endContentPage(); ?>
</html>