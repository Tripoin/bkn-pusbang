<?php include_once getTemplatePath('page/content-page.html.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="module-title notice">
                <span>Analisa Kebutuhan Diklat</span>
            </h3>
        </div>
    </div>
    <div class="row" id="pageAKD">

        <?php
        if (isset($_SESSION[SESSION_CODE_AKD_GUEST])) {
            include getTemplatePath('page/global/akd/page-akd-next.html.php');
        } else {
            include getTemplatePath('page/global/akd/page-email-request-code.html.php');
        }
        ?>


    </div>
</div>
<script>
    $(function () {
        $('.alert-danger').hide();
    });

</script>	
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>