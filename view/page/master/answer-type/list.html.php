
<?php
//echo $_SESSION[SESSION_ADMIN_AUTHORIZATION];
//    $Datatable->styleHeader(array("text-align:center;"));
$Datatable->deleteCollection(false);
$Datatable->styleColumn(array("text-align:center;width:5%;", "", "","text-align:center","text-align:center","text-align:center", "text-align:center;width:150px;"));
$Datatable->header(array(lang("general.no"), lang("general.code")
    , lang("general.name")
    , lang("master.answer_category"),lang("general.action")));
$no = $list_data['from'];


foreach ($list_data['item'] as $value) {

    $action_delete = $Button->url($this->deleteUrl)->value($value->id)->buttonDelete();
    $action_edit = $Button->url($this->editUrl)->value($value->id)->buttonEdit();

    $parent_name = "";
    if(isset($value->answer_category_id)){
        $parent_name = $value->answer_category_id->name;
    } else {
        $parent_name = "";
    }
    $Datatable->body(array($no, $value->code, $value->name
            , $parent_name, $action_edit . $action_delete));
    $no += 1;
}

echo $Datatable->show();
?>
<!--<script>location.reload(true);</script>-->
