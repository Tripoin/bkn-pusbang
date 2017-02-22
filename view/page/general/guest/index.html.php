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
                            <h4 class="media-heading">Phone</h4>
                            <p>
                                <span class="contact-emailto"><?=getSystemParameter('CONTACT_PHONE');?></span>
                            </p>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Email</h4>
                            <p>
                                <span class="contact-emailto"><a href="mailto:<?=getSystemParameter('CONTACT_EMAIL');?>"><?=getSystemParameter('CONTACT_EMAIL');?></a></span>
                            </p>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Address</h4>
                            <p>
                                <span class="contact-emailto">
                                    <?=getSystemParameter('CONTACT_ADDRESS');?>									
                                </span>
                            </p>
                        </div>
                    </div>							
                </div>				
            </div>
            <div class="col-md-8 col-sm-8">
                <div class="contact_us">
                    <?= $Form->formHeader(); ?>
                        <div class="form-group">
                            <div class="col-md-4 col-sm-4">
                                <p class="fnone"><label class="" for="Name">Name <em>*</em></label></p>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <div class="i_box">									
                                    <input type="text" name="name" id="Name"/>								
                                </div>						
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-sm-4">
                                <p class="fnone"><label class="" for="Email">Email <em>*</em></label></p>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <div class="i_box">									
                                    <input type="email" name="email" id="Email"/>							
                                </div>						
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-sm-4">
                                <p class="fnone"><label class="" for="mes">Message <em>*</em></label></p>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <div class="i_box">									
                                    <textarea name="comment" id="mes" cols="30" rows="10"></textarea>							
                                </div>						
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-sm-4"></div>
                            <div class="col-md-8 col-sm-8">
                                <p class=""><button type="submit" name="ok" class="read_more buttonc">submit</button></p>
                            </div>							
                        </div>
                    <?= $Form->formFooter($this->insertUrl); ?>
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
            center: new google.maps.LatLng(-6.2596795,106.8678393)
        };

        var map = new google.maps.Map(document.getElementById('googleMap'),
                mapOptions);


        var marker = new google.maps.Marker({
            position: map.getCenter(),
            animation: google.maps.Animation.BOUNCE,
            icon: '<?=URL('assets/img/map-marker-icon-kecil.png');?>',
            map: map
        });

    }
$(function(){
    google.maps.event.addDomListener(window, 'load', initialize);
});
    
</script>	
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>