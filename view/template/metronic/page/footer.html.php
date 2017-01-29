<div class="page-footer">
    <div class="page-footer-inner"> <?= getSystemParameter('GENERAL_COPYRIGHT'); ?> By
        <?php
//    COMPANY_NAME
        $logo_text = COMPANY_NAME;
        if (getSystemParameter('SYSTEM_ADMINISTRATOR_COMPANY_NAME') != '') {
            $logo_text = getSystemParameter('SYSTEM_ADMINISTRATOR_COMPANY_NAME');
        }
        
        $url_logo_text = COMPANY_WEB_URL;
        if (getSystemParameter('SYSTEM_ADMINISTRATOR_COMPANY_URL') != '') {
            $url_logo_text = getSystemParameter('SYSTEM_ADMINISTRATOR_COMPANY_URL');
        }
        ?>
        <a target="_blank" href="<?= $url_logo_text; ?>"><?= $logo_text; ?> </a> 
        <!--<a href="http://tripoin.co.id" title="Tripoin Inc" target="_blank">Tripoin Inc</a>-->
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>