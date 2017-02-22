<?php
foreach ($data_member_post['item'] as $val_member_post) {
    
    $Datatable->body(array(
        "title"=>$val_member_post[$mp->getTitle()],
        "subtitle"=>$val_member_post[$mp->getSubtitle()],
        "img"=>URL(DIR_WEB . 'uploads/member/'.$val_member_post[$mp->getCreatedByUsername()].'/'.$val_member_post[$mp->getImg()]),
        "title_button"=>"Assign Post",
        "event"=>"ajaxPostModalByValue('".URL('/')."')",
            ));
    
}
echo $Datatable->showGallery();
?>
<script>
    $(function () {
//        location.reload(true);
        $('[rel="tooltip"]').tooltip();
        
    })
</script>