
<?php include_once getTemplatePath('page/content-page.html.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="module-title notice">
                <span>Alumni Pusbang ASN</span>
            </h3>
        </div>
    </div>
    <div class="row">
        <form id="form-search" onsubmit="return false">
            <select class="form-control pull-right margin-bottom" 
                    onchange="postAjaxPagination();"
                    id="selectYears" 
                    name="years" 
                    style="width: 250px;">
                <?php
                foreach ($rs_years as $data) {
                    ?>
                    <option value="<?= $data['year_activity']; ?>"
                    <?php
                    if (date('Y') == $data['year_activity'])
                        echo "selected=\"selected\"";
                    ?>
                            ><?= $data['year_activity']; ?></option>
                            <?php
                        }
                        ?>
            </select>
        </form>
        <div id="bodyPage">

        </div>

        <input type="hidden" id="urlPage" value="<?= URL('alumni/search'); ?>"
    </div>
</div>
<script>
    $(function () {
        postAjaxPagination();
//        $('#selectYears').change();
    });
</script>
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>