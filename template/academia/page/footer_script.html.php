<script src="<?= URL('/assets/plugins/jquery-validation/js/jquery.validate.min.js'); ?>"></script>
<script src="<?= getTemplateURL('/assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?= getTemplateURL('/assets/js/wow.min.js'); ?>"></script>
<script src="<?= getTemplateURL('/assets/js/jquery.nivo.slider.pack.js'); ?>"></script>
<script src="<?= getTemplateURL('/assets/js/jquery.meanmenu.min.js'); ?>"></script>
<script src="<?= getTemplateURL('/assets/js/owl.carousel.min.js'); ?>"></script>
<script src="<?= getTemplateURL('/assets/js/jquery.scrollUp.min.js'); ?>"></script>
<script src="<?= URL('/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js'); ?>" ></script>
<script src="<?= URL('/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>" ></script>
<script src="<?= URL('/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js'); ?>" ></script>
<script src="<?= URL('/assets/plugins/bootstrap-toastr/toastr.min.js'); ?>" type="text/javascript"></script>
<script src="<?= URL('/assets/plugins/select2/js/select2.full.min.js'); ?>" type="text/javascript"></script>
<script src="<?= URL('/assets/plugins/bootstrap-sweetalert/sweetalert.min.js'); ?>" type="text/javascript"></script>
<script src="<?= getTemplateURL('/assets/js/atvImg-min.js'); ?>"></script>
<script src="<?= getTemplateURL('/assets/plugins/venobox/venobox.min.js'); ?>"></script>
<script src="<?= getTemplateURL('/assets/js/plugins.js'); ?>"></script>
<script src="<?= URL('/assets/js/function.js'); ?>?tripoin=<?=createRandomBooking();?>"></script>

<script src="<?= getTemplateURL('/assets/js/main.js'); ?>?tripoin=<?=createRandomBooking();?>"></script>


<script type="text/javascript">
    $().ready(function () {
//        location.reload(true);
    });
</script>

<div class="modal fade" id="myModal_self" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" id="modal-header-self" style="background:#d01c24;">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-10 col-sm-10 col-xs-10">
                            <h4 class="modal-title" id="modal-title-self" style="color:#FFFFFF">


                            </h4>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <button type="button" class="btn btn-circle btn-icon-only pull-right close" data-dismiss="modal">
                                <i class="fa fa-times" ></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" id="modal-body-self">
              <!--<p>Some text in the modal.</p>-->
            </div>
        </div>

    </div>
</div>