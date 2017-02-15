<?php include_once getTemplatePath('page/content-page.html.php'); ?>
<div class="map_area">
    <div class="container-fulid">
        <div class="map">
            <!-- Start contact-map -->
            <div class="contact-map">
                <div id="googleMap"></div>
            </div>
            <!-- End contact-map -->
        </div>							
    </div>	
</div>	
<div class="contact_area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <p class="lead">
                        We are always here to hear from you.
                    </p>
                </div>
            </div>
        </div>		
        <div class="row">
            <!-- start  blog left -->
            <div class="col-md-4 col-sm-4">
                <div class="contact-address">	
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= lang('general.phone'); ?></h4>
                            <p>
                                <span class="contact-emailto"><?= getSystemParameter('CONTACT_PHONE'); ?></span>
                            </p>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-fax"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= lang('general.fax'); ?></h4>
                            <p>
                                <span class="contact-emailto"><?= getSystemParameter('CONTACT_FAX'); ?></span>
                            </p>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= lang('general.email'); ?></h4>
                            <p>
                                <span class="contact-emailto"><a href="mailto:<?= getSystemParameter('CONTACT_EMAIL'); ?>"><?= getSystemParameter('CONTACT_EMAIL'); ?></a></span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= lang('general.address'); ?></h4>
                            <p>
                                <span class="contact-emailto">
                                    <?= getSystemParameter('CONTACT_ADDRESS'); ?>									
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-taxi"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= lang('general.transportation'); ?></h4>
                            <p>
                                <span class="contact-emailto">
                                    <?= getSystemParameter('CONTACT_TRANSPORTATION'); ?>									
                                </span>
                            </p>
                        </div>
                    </div>
                </div>				
            </div>
            <div class="col-md-8 col-sm-8">
                <div class="contact_us">
                    <?php
//                    conver
                    ?>
                    <?= $Form->formHeader(); ?>
                    <?php echo $Form->id('name')->alignLabel('right')->title(lang('general.name'))->classComponent('i_box')->formLayout('horizontal')->placeholder(lang('general.name') . ' ....')->textbox(); ?>
                    <?php echo $Form->id('email')->alignLabel('right')->title(lang('general.email'))->classComponent('i_box')->formLayout('horizontal')->placeholder(lang('general.email') . ' ....')->textbox(); ?>
                    <?php echo $Form->id('subject')->alignLabel('right')->title(lang('general.subject'))->classComponent('i_box')->formLayout('horizontal')->placeholder(lang('general.subject') . ' ....')->textbox(); ?>
                    <?php echo $Form->id('message')->alignLabel('right')->title(lang('general.message'))->classComponent('i_box')->formLayout('horizontal')->placeholder(lang('general.message') . ' ....')->textarea(); ?>
                    <?php echo $Form->id('security_code_contact')->alignLabel('right')->title(lang('general.security_code'))->classComponent('i_box')->formLayout('horizontal')->placeholder(lang('general.security_code') . ' ....')->captcha(); ?>
                    
                    <?= $Form->formFooter(null, '<button type="submit" onclick="postFormAjaxPostSetContent(\''.  FULLURL('submit').'\',\'form-newedit\')" class="read_more buttonc">submit</button>'); ?>
                    <br/>
                    <br/>
                </div>
            </div>			
        </div>
    </div>
</div>	
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script>
                        function initialize() {
                            var mapOptions = {
                                zoom: 15,
                                scrollwheel: false,
                                center: new google.maps.LatLng(<?= getSystemParameter('CONTACT_LATLONG'); ?>)
                            };

                            var map = new google.maps.Map(document.getElementById('googleMap'),
                                    mapOptions);


                            var marker = new google.maps.Marker({
                                position: map.getCenter(),
                                animation: google.maps.Animation.BOUNCE,
                                icon: '<?= URL('assets/img/map-marker-icon-kecil.png'); ?>',
                                map: map
                            });

                        }
                        $(function () {
                            google.maps.event.addDomListener(window, 'load', initialize);
                            $('.alert-danger').hide();
                            $('#message').attr('class','');
                        });

</script>	
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>