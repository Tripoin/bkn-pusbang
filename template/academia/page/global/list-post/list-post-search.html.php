
<?php
//        print_r($list_post_function);
//        echo $db->myQuery;
$no = 0;
foreach ($list_post_function as $value) {
    $value_new = $value;
    if (isset($_SESSION[LANGUAGE_SESSION])) {
        $mp_lang = $db->selectByID($mpl, $mpl->getLanguage() . "='" . $_SESSION[LANGUAGE_SESSION] . "'"
                . " AND " . $mpl->getPost()->getId() . "=" . $value[$mp->getId()]);
        if (!empty($mp_lang)) {
//                    $post_function_lang = $mp_lang;
            unset($value[$mpf->getPost()->getTitle()]);
            unset($value[$mpf->getPost()->getSubtitle()]);
            unset($value[$mpf->getPost()->getContent()]);
            $value_new = array_merge($mp_lang[0], $value);
        } else {
            $value_new = $value;
        }
    }
    $no +=1;
    $moduls = $no % 2;
    if ($moduls != 0) {
        echo leftContentRightImg($value_new, $mpf, $list_post_function[0][$mpf->getFunction()->getName()]);
    } else {
        echo rightContentLeftImg($value_new, $mpf, $list_post_function[0][$mpf->getFunction()->getName()]);
    }
}
$last_page = $list_post_function_count[0]['count'] / $length;
$page_prev_dis = '';
$page_prev_minus = $current_page - 1;
$click_prev = '';
if ($current_page <= 1) {
    $page_prev_dis = 'disabled';
    $click_prev = '';
} else {
    $click_prev = "onclick=\"findPostRead('" . FULLURL() . "'," . $page_prev_minus . ")\"";
}

$page_next_dis = '';
$page_next_minus = $current_page + 1;
$click_next = '';
if ($current_page >= $last_page) {
    $page_next_dis = 'disabled';
    $click_next = '';
} else {
    $click_next = "onclick=\"findPostRead('" . FULLURL() . "'," . $page_next_minus . ")\"";
}

$min_page = $current_page - 2;
$max_page = $current_page + 2;

$res_page = "";

//        if ($last_page > 5) {
if ($current_page == 1) {
    $min_page = $current_page - 1;
    $max_page = $current_page + 4;
} else if ($current_page == 2) {
    $min_page = $current_page - 2;
    $max_page = $current_page + 3;
} else if ($current_page == 4) {
    $min_page = $current_page - 3;
    $max_page = $current_page + 2;
} else if ($current_page == ($last_page - 1)) {
    $min_page = $current_page - 3;
    $max_page = $current_page + 2;
//            echo 'masuk';
} else if ($current_page == $last_page) {
    $min_page = $current_page - 4;
    $max_page = $current_page + 1;
//                echo 'masuk';
}
for ($no = $min_page; $no <= $max_page; $no++) {
//            echo $no;
    if ($no > ceil($last_page)) {
        
    } else if ($no <= 0) {
        
    } else {
        $res_page .= $no . ",";
    }
}
$pagination_item = rtrim($res_page, ",");
$ex_pagination_item = explode(",", $pagination_item);
?>
<div class="row" style="text-align: center;">
    <ul class="pagination">
        <li class="prev <?= $page_prev_dis; ?>">
            <a href="javascript:void(0)"   rel="tooltip" <?= $click_prev; ?> title="" data-original-title="Previous">
                <i class="fa fa-angle-left" style="margin-top:3px;"></i>
            </a>
        </li>
        <?php
//        for ($no = 1; $no <= $menu_pagination; $no++) {
//        for ($no = $min_page; $no <= $max_page; $no++) {
        foreach ($ex_pagination_item as $no) {
            $active = '';
            if ($no == $current_page) {
                $active = 'active';
            }
            ?>

            <li class="<?= $active; ?>"><a href="javascript:void(0)" onclick="findPostRead('<?= FULLURL(); ?>', <?= $no; ?>)"><?= $no; ?></a></li>
        <?php } ?>
        <li class="next <?= $page_next_dis; ?>">
            <a href="javascript:void(0)" rel="tooltip" <?= $click_next; ?> title="" data-original-title="Next">
                <i class="fa fa-angle-right" style="margin-top:3px;">

                </i>
            </a>
        </li>

    </ul>
</div>