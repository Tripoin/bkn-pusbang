<?php
include_once getTemplatePath('page/content-page.html.php');
?>
<style>
    /*    .page-breadcrumb > li + li:before {
            color: #CCCCCC;
            content: "/ ";
            padding: 0 5px;
        }*/
    /* Style the list */
    .display-hide{
        display: none;
    }
    
    #btn-save {
        .btn;
        .btn-primary;
    }
    
    #btn-reset{
        .btn;
        .btn-default;
    }
    
    .display-show{
        display: block;
    }
    
    ul.page-breadcrumb {
        padding: 10px 16px;
        list-style: none;
        background-color: #eee;
        font-size: 17px;
    }

    /* Display list items side by side */
    ul.page-breadcrumb li {
        display: inline;
    }

    /* Add a slash symbol (/) before/behind each list item */
    ul.page-breadcrumb li+li:before {
        padding: 8px;
        color: black;
        /*content: "/\00a0";*/
    }

    ul.page-breadcrumb i:before {
        padding: 8px;
        /*font-size: 10px;*/
        color: black;
        content: "/\00a0";
    }

    /* Add a color to all links inside the list */
    ul.page-breadcrumb li a {
        color: #0275d8;
        text-decoration: none;
    }

    /* Add a color on mouse-over */
    ul.page-breadcrumb li a:hover {
        color: #01447e;
        text-decoration: underline;
    }
</style>
<div id="content" class="container-fluid" style="padding-top: 130px;">
    <?php include_once FILE_PATH(PAGE_MEMBER_PATH); ?>
    <div class="signup col-md-9 member-page">
        <div class="page-bar">
            <?= breadCrumb(); ?>
        </div>
        <fieldset id="account">
            <div class="row">
                <div class="col-md-6">
                    <legend style="font-weight: bold;font-size: 20px;">
                        <?= $GLOBALS['title']; ?>
                        <br/><small><?= $GLOBALS['subtitle_body_global']; ?></small>
                    </legend>
                </div>
                <?php
                if ($GLOBALS['showActionHeader'] == true) {
                    echo '<div class="col-md-6" style="margin-top:20px;text-align:right" id="actionHeader">
                        </div>';
                }
                ?>
            </div>
            <div id="bodyPage">
            </div>
        </fieldset>
    </div>
    <input type="hidden" id="urlPage" name="urlPage" 
           value="<?= $GLOBALS['url_datatable']; ?>"/>
    <script>
        $(function () {
            postAjaxPagination();
        });
    </script>

    <?php include_once FILE_PATH(END_PAGE_MEMBER_PATH); ?>
</div>
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>
