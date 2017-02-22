<?php

use app\Model\MasterAuthor;
use app\Util\Database;

$db = new Database();
$masterAuthor = new MasterAuthor();
//                print_r($list_data);
foreach ($list_data['item'] as $value) {
    if (substr($value[$masterPost->getThumbnail()], 0, 7) == "http://") {
        $url = $value[$masterPost->getThumbnail()];
    } else if (substr($value[$masterPost->getThumbnail()], 0, 8) == "https://") {
        $url = $value[$masterPost->getThumbnail()];
    } else {
        $url = URL('contents/' . $value[$masterPost->getThumbnail()]);
    }
    $rs_author = $db->selectById($masterAuthor, $masterAuthor->getId() . EQUAL . $value[$masterPost->getAuthorId()]);
    $Datatable->body(array(
        'author_name' => $rs_author[0][$masterAuthor->getName()],
        'publish_on' => $value[$masterPost->getPublishOn()],
        'title' => $value[$masterPost->getTitle()],
        'read_count' => $value[$masterPost->getReadCount()],
        'content' => $value[$masterPost->getContent()],
        'img' => $url,
        'link' => URL($value[$masterPost->getCode()]),
            )
    );
}
echo $Datatable->showBodyArtikelReadMore();
if($_POST['urut'] != 1){
?>
<script>
    $(function(){
//        location.reload(true);
        $('html, body').animate({scrollTop: $('#pageArtikel').offset().top}, 'slow');
    })
</script>
<?php } ?>
