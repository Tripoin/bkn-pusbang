
<div class="faq_area">
    <div class="container">
        <div class="row">
            <div class="title">
                <h3 class="module-title">
                    Latest  <span>News</span>
                </h3>
            </div>
            <!-- start  blog left -->
            <div class="col-md-12 col-sm-12" id="pageArtikel">
                <!-- single blog item -->

                <!-- end single blog item -->
                <!-- single blog item -->

                <!-- end single blog item -->
                <!-- paginitaion-->

                <!--end  paginitaion-->						
            </div>
            <!-- end  blog left -->
            <!--  blog Right -->

        </div>
    </div>
</div>
<script>
    $(function () {
//        location.reload(true);
        ajaxPostManual('<?= FULLURL(); ?>', 'pageArtikel', 'urut=1');
    });
</script>