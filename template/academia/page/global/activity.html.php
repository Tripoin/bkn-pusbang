
<?php include_once getTemplatePath('page/content-page.html.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="module-title notice">
                <span>Program Pusbang ASN</span>
            </h3>
        </div>
    </div>		
    <div class="row">
        <?php
        $StaringDate = date('Y-m-d');
        $oneYearOn = date("Y", strtotime(date("Y-m-d", strtotime($StaringDate)) . " + 1 year"));
        ?>
        <select class="form-control pull-right margin-bottom" id="selectYears" onchange="ajaxPostManual('<?= URL('activity/search'); ?>', 'listKegiatan', 'years=' + this.value)" style="width: 250px;">
            <option value="<?= date('Y'); ?>" selected="selected"><?= date('Y'); ?></option>
            <option value="<?= $oneYearOn; ?>"><?= $oneYearOn; ?></option>
        </select>
        <div id="listKegiatan">

        </div>
    </div>
</div>
<script>
    $(function(){
       $('#selectYears').change();
    });
</script>
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>