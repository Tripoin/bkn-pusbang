<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataTable
 *
 * @author sfandrianah
 */

namespace app\Util;

use app\Util\Database;
use app\Util\RestClient\TripoinRestClient;
use app\Constant\IRestCommandConstant;

class DataTable {

    //put your code here

    protected $body = array();
    protected $attrRowBody = array();
    protected $tableOption = array(
        'HEADER' => array(),
        'FOOTER' => array(),
        'PAGINATION_MANUAL' => true,
        'ID' => null,
        'CREATE_BUTTON' => true,
        'BACK_BUTTON' => false,
        'ID_BODY' => null,
        'URL_DELETE_COLLECTION' => null,
        'OPTION_PAGINATION_RECORD' => array(),
        'STYLE_HEADER' => array(),
        'BODY_ROW_ATTRIBUT_MANUAL' => "",
        'HEADER_BUTTON' => "",
        'PAGE_TABLE' => null,
        'STYLE_BODY' => array(),
        'STYLE_COLUMN' => array(),
        'STYLE_FIRST_COLUMN' => '',
        'STYLE_LAST_COLUMN' => '',
        'DELETE_COLLECTION' => true,
        'ENABLE_RECORD' => true,
        'ENABLE_SEARCH' => true,
        'SEARCH_FILTER' => array(),
        'DEBUG' => false,
        'URL' => null,
        'QUERY' => '',
    );

    public function debug($debug = false) {
        return $this->setTableOption('DEBUG', $debug);
    }

    public function enableSearch($enableSearch = true) {
        return $this->setTableOption('ENABLE_SEARCH', $enableSearch);
    }

    public function enableRecord($enableRecord = true) {
        return $this->setTableOption('ENABLE_RECORD', $enableRecord);
    }

    public function headerButton($headerButton) {
        return $this->setTableOption('HEADER_BUTTON', $headerButton);
    }

    public function styleFirstColumn($styleFirstColumn) {
        return $this->setTableOption('STYLE_FIRST_COLUMN', $styleFirstColumn);
    }

    public function styleLastColumn($styleLastColumn) {
        return $this->setTableOption('STYLE_LAST_COLUMN', $styleLastColumn);
    }

    public function setPageTable($pageTable) {
        return $this->setTableOption('PAGE_TABLE', $pageTable);
    }

    public function deleteCollection($deleteCollection) {
        return $this->setTableOption('DELETE_COLLECTION', $deleteCollection);
    }

    public function attrRowBody($attrRowBody) {
        $this->attrRowBody[] = $attrRowBody;
//        $this->tableOption['BODY_ROW_ATTRIBUT_MANUAL'] = '';
//        return $this->setTableOption('BODY_ROW_ATTRIBUT_MANUAL', $attrRowBody);
    }

    public function createButton($createButton) {
        return $this->setTableOption('CREATE_BUTTON', $createButton);
    }

    public function backButton($backButton) {
        return $this->setTableOption('BACK_BUTTON', $backButton);
    }

    public function searchFilter($searchFilter) {
        return $this->setTableOption('SEARCH_FILTER', $searchFilter);
    }

    public function urlDeleteCollection($urlDeleteCollection) {
        return $this->setTableOption('URL_DELETE_COLLECTION', $urlDeleteCollection);
    }

    public function query($query) {
        return $this->setTableOption('QUERY', $query);
    }

    public function url($url) {
        return $this->setTableOption('URL', $url);
    }

    public function optionPaginationRecord($option = array()) {
        return $this->setTableOption('OPTION_PAGINATION_RECORD', $option);
    }

    public function id($id) {
        return $this->setTableOption('ID', $id);
    }

    public function idBody($id) {
        return $this->setTableOption('ID_BODY', $id);
    }

    public function header($header = array()) {
        return $this->setTableOption('HEADER', $header);
    }

    public function styleHeader($styleHeader = array()) {
        return $this->setTableOption('STYLE_HEADER', $styleHeader);
    }

    public function styleBody($styleBody = array()) {
        return $this->setTableOption('STYLE_BODY', $styleBody);
    }

    public function styleColumn($styleColumn = array()) {
        return $this->setTableOption('STYLE_COLUMN', $styleColumn);
    }

    public function footer($footer = array()) {
        return $this->setTableOption('FOOTER', $footer);
    }

    public function paginationManual($pagination) {
        return $this->setTableOption('PAGINATION_MANUAL', $pagination);
    }

    public function body($body = array()) {

//        print_r($body);
        $this->body[] = $body;
//        return $this->setTableOption('BODY', $body);
    }

    public function getArrayBody() {
        return $this->body;
    }

    protected function setTableOption($key, $value) {
        $this->tableOption[$key] = $value;
        return $this;
    }

    protected function headerPagination() {
        $result = '';

        $opr = $this->tableOption['OPTION_PAGINATION_RECORD'];
        if (empty($opr)) {
//            $opr = array(5, 10, 15, 20);
            $opr = array(10, 25, 50, 100);
        }

        if ($this->tableOption['PAGINATION_MANUAL'] == true) {
            $id = 'table-manual';
            if ($this->tableOption['ID'] != null) {
                $id = $this->tableOption['ID'];
            }

            $paginationPerPage = 'paginationPerPage()';
            $idPaginationPerPage = 'pagination_per_page';
            $listSearchBy = 'list_search_by';
            $pageId = 'pageId';
            $urlPage = 'urlPage';
            $urlDeleteCollection = 'url_delete_collection';
            $searchPagination = 'search_pagination';
            $searchPaginationEvent = 'searchPagination(event)';
            $pageTable = $this->tableOption['PAGE_TABLE'];
            if ($pageTable != null) {
                $paginationPerPage = "paginationPerPageManual('" . $pageTable . "')";
                $idPaginationPerPage = 'pagination_per_page-' . $pageTable;
                $listSearchBy = 'list_search_by-' . $pageTable;
                $pageId = 'pageId-' . $pageTable;
                $urlPage = 'urlPage-' . $pageTable;
                $urlDeleteCollection = 'url_delete_collection-' . $pageTable;
                $searchPagination = 'search_pagination-' . $pageTable;
                $searchPaginationEvent = 'searchPaginationManual(event,\'' . $pageTable . '\')';
            }
            $enableSearch = $this->tableOption['ENABLE_SEARCH'];
            $enableRecord = $this->tableOption['ENABLE_RECORD'];
            $result .= '<div id="' . $id . '-content" class="dataTables_wrapper no-footer">
        <div class="row">';
            if ($enableRecord == true) {
                $result .= '<div class="col-md-6 col-sm-6">
                <div class="dataTables_length" id="sample_5_length">
                    <label>' . lang("general.show") . '
                        <select name="sample_5_length" onchange="' . $paginationPerPage . '" id="' . $idPaginationPerPage . '" aria-controls="sample_5" class="form-control input-sm input-xsmall input-inline">';
                foreach ($opr as $val_opr) {
                    if ($this->per_page == $val_opr) {
                        $result .= '<option value="' . $val_opr . '" selected="selected">' . $val_opr . '</option>';
                    } else {
                        $result .= '<option value="' . $val_opr . '">' . $val_opr . '</option>';
                    }
                }
                $this->tableOption['ID'];
                $result .= '</select>
                    </label>
                </div>
            </div>';
            }
            if ($enableSearch == true) {
                $result .= '<div class="col-md-6 col-sm-6">
                <div id="sample_5_filter" class="dataTables_filter pull-right">
                        <label>' . lang('general.search') . ': </label>
                        <select name="' . $listSearchBy . '" id="' . $listSearchBy . '" class="form-control input-sm input-xsmall input-inline">';
                $search_filter = $this->tableOption['SEARCH_FILTER'];
                if (empty($search_filter)) {
                    $result .= '<option value="code">Code</option>';
                } else {
                    foreach ($search_filter as $key_filter => $value_filter) {
                        $result .= '<option value="' . $key_filter . '">' . $value_filter . '</option>';
                    }
                }

                $result .= '</select>
                        <input type="search" onkeyup="' . $searchPaginationEvent . '" id="' . $searchPagination . '" class="form-control input-sm input-small input-inline" placeholder="" aria-controls="sample_5">
                        <input type="hidden" value="' . $this->tableOption['URL_DELETE_COLLECTION'] . '" id="' . $urlDeleteCollection . '">
                </div>
            </div>';
            }
            $result .= '</div>
        <div class="table-scrollable">';
        }

        return $result;
    }

    protected function footerPagination() {
        $result = '';
        if ($this->tableOption['PAGINATION_MANUAL'] == true) {
//            $url = $this->tableOption['URL'];

            $idBody = 'table-manual-body';
            if ($this->tableOption['ID_BODY'] != null) {
                $idBody = $this->tableOption['ID_BODY'];
            }
            $id = 'table-manual';
            if ($this->tableOption['ID'] != null) {
                $id = $this->tableOption['ID'];
            }

            $pageTable = $this->tableOption['PAGE_TABLE'];
            $currentPage = 'currentPage';
            $currentPagePaginationEventOne = 'currentPagePagination(1)';
            if ($pageTable != null) {
                $currentPage = 'currentPage-' . $pageTable;
                $currentPagePaginationEventOne = 'currentPagePaginationManual(1,\'' . $pageTable . '\')';
            }

            $result .= '<input type="hidden" id="idContentPage" value="' . $id . '-content"/>';

            $result .= '<input type="hidden" id="' . $currentPage . '" value="1"/>';
            $result .= '</div>
        <div class="row">
            <div class="col-md-5 col-sm-5">
                <div class="dataTables_info" id="sample_5_info" role="status" aria-live="polite">';
            $result .= lang('general.showing') . ' ' . $this->from . ' ' . lang('general.to_pagination') . ' ' . $this->to . ' ' . lang('general.of_pagination') . ' ' . $this->total . ' ' . lang('general.record_pagination');
            $result .= '</div>
            </div>
            <div class="col-md-7 col-sm-7">
                <div class="  pull-right" id="">
                    <ul class="pagination pagination-sm" >';
            if ($this->current_page == 1) {
                $disabled = 'disabled';
                $last_page = '';
            } else {
                if ($pageTable != null) {
                    $last_page = 'onclick="currentPagePaginationManual(' . $this->prev_page . ',\'' . $pageTable . '\')"';
                } else {
                    $last_page = 'onclick="currentPagePagination(' . $this->prev_page . ')"';
                }
                $disabled = '';
            }
            $result .= '<li class="prev ' . $disabled . '">
                            <a href="javascript:void(0)" onclick="' . $currentPagePaginationEventOne . '" rel="tooltip" title="' . lang('general.prev_last') . '" style="height: 30px;">
                                <i class="fa fa-angle-double-left" style="margin-top:3px;"></i>
                            </a>
                        </li>';
            $result .= '<li class="prev ' . $disabled . '">
                            <a href="javascript:void(0)" ' . $last_page . ' rel="tooltip" title="' . lang('general.prev') . '" style="height: 30px;">
                                <i class="fa fa-angle-left" style="margin-top:3px;"></i>
                            </a>
                        </li>';
            $pagi = explode(',', $this->pagination_item);
//            echo $this->pagination_item;
//            print_r($this->pagination_item);
            foreach ($pagi as $value) {
                $check = '';
                if ($this->current_page == $value) {
                    $check = 'class="active"';
                }
                if ($pageTable != null) {
                    $urut_page_last = 'onclick="currentPagePaginationManual(' . $value . ',\'' . $pageTable . '\')"';
                } else {
                    $urut_page_last = 'onclick="currentPagePagination(' . $value . ')"';
                }
                $result .= '<li ' . $check . '><a href="javascript:void(0)" ' . $urut_page_last . ' style="height: 30px;">' . $value . '</a></li>';
            }
            if ($this->current_page == end($pagi)) {
                $disabled = 'disabled';
                $last_page = '';
            } else {
                if ($pageTable != null) {
                    $last_page = 'onclick="currentPagePaginationManual(' . $this->next_page . ',\'' . $pageTable . '\')"';
                } else {
                    $last_page = 'onclick="currentPagePagination(' . $this->next_page . ')"';
                }
                $disabled = '';
            }
            $result .= '<li class="next ' . $disabled . '">
                            <a href="javascript:void(0)"  ' . $last_page . ' rel="tooltip" title="' . lang('general.next') . '" style="height: 30px;">
                                <i class="fa fa-angle-right" style="margin-top:3px;">

                                </i>
                            </a>
                        </li>';
            if ($pageTable != null) {
                $last_last_page = 'onclick="currentPagePaginationManual(' . $this->last_page . ',\'' . $pageTable . '\')"';
            } else {
                $last_last_page = 'onclick="currentPagePagination(' . $this->last_page . ')"';
            }
            $result .= '<li class="next ' . $disabled . '">
                            <a href="javascript:void(0)"  rel="tooltip" ' . $last_last_page . ' title="' . lang('general.next_last') . '" style="height: 30px;">
                                <i class="fa fa-angle-double-right" style="margin-top:3px;">

                                </i>
                            </a>
                        </li>';
            $result .= '</ul>
                </div>
            </div>
            
        </div>
    </div>';
        }
        return $result;
    }

    public function showBodyArtikelReadMore() {
        $body = $this->body;
        $no = 0;
        $txt = '';
//        print_r($body);
        foreach ($body as $value) {
            $no++;
            $mod = $no % 4;
            $txt .= '<div class="row margin-bottom" style="margin-bottom:50px;">						
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="new_bulletin" style="width: 100%;height: 250px;overflow: hidden;">
                                <a href="' . $value['link'] . '">
                                    <img style=" width:100%;height:auto;" src="' . $value['img'] . '" ' . notFoundImg() . '>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div class="news_content news_buletin_pra">
                                <h1><a href="' . $value['link'] . '">' . $value['title'] . '</a></h1>
                                <p class="date">
                                    <span data-toggle="tooltip" data-placement="top" title="" 
                                        data-original-title="Written By"><i class="fa fa-user"></i> ' . $value['author_name'] . '
                                    </span>
                                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Published"><i class="fa fa-calendar"></i> ' . $value['publish_on'] . '</span>
                                    <span><i class="fa fa-eye"></i> Hits: ' . $value['read_count'] . '</span>
                                </p>							
                                ' . html_entity_decode(readMore($value['content'], $value['link'])) . '
                            </div>				
                        </div>				
                    </div>';
        }
        $txt .= $this->footerArtikel();
        return $txt;
    }

    public function footerArtikel() {
        $txt = '';
        $txt .= '<div class="row">
                    <div class="col-md-12">
                        <div class="pagenition_bar">
                            <nav>
                                <ul class="pagination paginition_text">';
        if ($this->current_page == 1) {
            $txt .= '<li><a>Previous</a></li>';
        } else {
            $prev = $this->current_page - 1;
            $txt .= '<li><a href="javascript:void(0)" '
                    . 'onclick="ajaxPostManual(\'' . FULLURL() . '\',\'pageArtikel\',\'urut=' . $prev . '\')">Previous</a></li>';
        }
        $item = explode(',', $this->pagination_item);
        foreach ($item as $value) {
            if ($value == $this->current_page) {
                $txt .= '<li class="disabled"><a>' . $value . '</a></li>';
            } else {
                $txt .= '<li><a href="javascript:void(0)" '
                        . 'onclick="ajaxPostManual(\'' . FULLURL() . '\',\'pageArtikel\',\'urut=' . $value . '\')">' . $value . '</a></li>';
            }
        }
        if ($this->current_page == $this->last_page) {
            $txt .= '<li><a>Next</a></li>';
        } else {
            $prev = $this->current_page + 1;
            $txt .= '<li><a href="javascript:void(0)" '
                    . 'onclick="ajaxPostManual(\'' . FULLURL() . '\',\'pageArtikel\',\'urut=' . $prev . '\')">Next</a></li>';
        }
        $txt .= '</ul>
                            </nav>					
                        </div>					
                    </div>
                </div>';
        return $txt;
    }

    public function showBodyGallery() {
        $body = $this->body;
        $no = 0;
        $txt = '';
//        print_r($body);
        foreach ($body as $value) {
            $no++;
            $mod = $no % 4;
            if ($mod == 1) {
                $txt .= '<div class="row" style="margin-bottom: 150px;">';
            }
            $txt .= '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="height: 200px;">
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-layers font-green"></i>
                    <span class="caption-subject font-green bold uppercase">' . $value['title'] . '</span>
                    <div class="caption-desc font-grey-cascade">' . $value['title'] . '</div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="mt-element-overlay">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-overlay-1">
                                <img src="' . $value['img'] . '">
                                <div class="mt-overlay">
                                    <ul class="mt-info">
                                        <li>
                                            <a class="btn default btn-outline" rel="tooltip" data-original-title="' . $value['title_button'] . '" onclick="' . $value['event'] . '" href="javascript:;">
                                                <i class="fa fa-check"></i> ' . $value['title_button'] . '
                                            </a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
            if ($mod == 0) {
                $txt .= '</div>';
            }
        }
        return $txt;
    }

    public function showGallery() {
//        printf($this->tableOption['QUERY']);
        $rs = '';
//        $rs = '<div class="row">';
//        $rs .= '<div class="col-md-10">';
        $rs .= $this->headerPagination();
        $rs .= $this->showBodyGallery();
        $rs .= $this->footerPagination();
//        $rs .= '</div>';
//        $rs .= '</div>';
        return $rs;
    }

    public function show() {
//        printf($this->tableOption['QUERY']);
        $rs = '';
        $rs .= $this->headerPagination();
        $id = 'table-manual';
        if ($this->tableOption['ID'] != null) {
            $id = $this->tableOption['ID'];
        }

        $rs .= '<table border="0" id="' . $id . '" class="table table-striped table-bordered order-column dataTable" width="100%">
        <thead>
        
        <tr>';
        $header = $this->tableOption['HEADER'];
        $styleHeader = $this->tableOption['STYLE_HEADER'];

        $styleColumn = $this->tableOption['STYLE_COLUMN'];
//        foreach ($header as $header_value) {
        $style_head = '';
        for ($urut = 0; $urut < count($header); $urut++) {
            if (!empty($styleColumn)) {
                if (!isset($styleColumn[$urut])) {
                    $styleColumn[$urut] = '';
                }
                $style_head = $styleColumn[$urut];
            } else {
                if (!isset($styleHeader[$urut])) {
                    $styleHeader[$urut] = '';
                }
                $style_head = $styleHeader[$urut];
            }
            $rs .= '<th style="' . $style_head . '">' . $header[$urut] . '</th>';
        }

        $rs .= '</tr></thead>';
        $idBody = 'table-manual-body';
        if ($this->tableOption['ID_BODY'] != null) {
            $idBody = $this->tableOption['ID_BODY'];
        }
        $rs .= '<tbody id="' . $idBody . '">';
        $body = $this->body;
        if (!empty($body)) {
            $rs .= $this->showBody();
        }
        $rs .= '</tbody>';
        $rs .= '<tfoot>';
        $footer = $this->tableOption['FOOTER'];
        foreach ($footer as $footer_value) {
            $rs .= '<td style="font-weight: bold;">' . $footer_value . '</td>';
        }
        $rs .= '</tfoot>';
        $rs .= '</table>';
        $rs .= $this->footerPagination();

//        $button = '<a class="btn btn-warning" href="javascript:void(0)" onclick="postAjaxCreate(\'' . $GLOBALS['url_create'] . '\')"> <i class="fa fa-plus"></i>Create</a>';
        $rs .= "<script>
                $(function () {
                    $(\"[rel='tooltip']\").tooltip();";
        if ($this->tableOption['BACK_BUTTON'] == false) {
            $rs .= "$(\"#buttonBack\").hide();";
        }

        if ($this->tableOption['CREATE_BUTTON'] == true) {
            $rs .= " $(\"#actionHeader\").html(comButtonCreate('" . lang('general.create') . "','btn-warning','fa-plus','" . $GLOBALS['url_create'] . "'));";
        } else {
            $rs .= "$(\"#buttonCreate\").remove();";
        }
        if ($this->tableOption['HEADER_BUTTON'] != "") {
            $rs .= " $(\"#actionHeader\").append('" . $this->tableOption['HEADER_BUTTON'] . "');";
        }

        $rs .= "});
            </script>
        ";

        return $rs;
    }

    function showBody() {
        $styleColumn = $this->tableOption['STYLE_COLUMN'];
        $styleFirstColumn = $this->tableOption['STYLE_FIRST_COLUMN'];
        $styleLastColumn = $this->tableOption['STYLE_LAST_COLUMN'];

        $body = $this->body;
        $styleBody = $this->tableOption['STYLE_BODY'];
        $attrRowBody = $this->attrRowBody;
        $style_body = '';
        $rs = '';

        for ($no = 0; $no < count($body); $no++) {
            if (!isset($attrRowBody[$no])) {
                $attrRowBody[$no] = '';
            } else {
                
            }
            if ($this->tableOption['DELETE_COLLECTION'] == true) {
                $rs .= '<tr ' . $attrRowBody[$no] . '  onclick="checkCollectionRow(this)" class="collection" style="cursor:pointer">';
            } else {
                $rs .= '<tr ' . $attrRowBody[$no] . ' >';
            }
//            foreach ($body[$no] as $body_value) {
            $countBody = count($body[$no]);
            for ($urut = 0; $urut < count($body[$no]); $urut++) {
//                if (!isset($styleBody[$urut])) {
//                    $styleBody[$urut] = '';
//                }


                if (!empty($styleColumn)) {
                    if (!isset($styleColumn[$urut])) {
                        $styleColumn[$urut] = '';
                    }
                    $style_body = $styleColumn[$urut];
                } else {
                    if (!isset($styleBody[$urut])) {
                        $styleBody[$urut] = '';
                    }
                    $style_body = $styleBody[$urut];
                }
                if (is_not_null($body[$no][$urut])) {
                    if ($urut == 0) {
//                        echo $styleFirstColumn;
                        if (!empty($styleFirstColumn)) {
                            $style_body = $styleFirstColumn;
                        }
                    }
                    if (($urut + 1) == $countBody) {
                        if (!empty($styleLastColumn)) {
                            $style_body = $styleLastColumn;
                        }
//                        echo $cou
                        $rs .= '<td style="' . $style_body . '">' . $body[$no][$urut] . '</td>';
                    } else {

                        $rs .= '<td style="' . $style_body . '">' . $body[$no][$urut] . '</td>';
                    }
                } else {
                    $rs .= '<td style="' . $style_body . '"></td>';
                }
            }
            $rs .= '</tr>';
        }

        return $rs;
    }

    public $per_page = null;
    public $next_page = null;
    public $current_page = null;
    public $last_page = null;
    public $prev_page = null;
    public $from = null;
    public $pagination_item = null;
    public $to = null;
    public $search = null;
    public $total = null;
    public $sql;
    public $query = "";

    public function select_pagination_sql($query) {
        $this->query = $query;
        return $this->select_pagination(null);
    }

    public function perPage($perPage = 10) {
        $this->per_page = $perPage;
    }

    public function select_pagination($dto = null, $entity = null, $where = null, $join = null, $search_pagination = null, $order = null, $select_entity = null, $group_by = null) {
//        $this->current_page = $_POST['current_page'];
//        $this->per_page = $_POST['per_page'];
//        echo $this->per_page;
//        $this->search = $_POST['search'];
        $db = new Database();
        $db->connect();

//        echo $sql_select . " COUNT(".$entity.".*) as total " . $sql_from. $sql_search;
        if (!empty($this->query)) {
//            echo $this->query;
//            $sql = $this->query . " " . $limit;
            $rpl_btw = replace_between($this->query, "SELECT", "FROM", " COUNT(*) as total ");
//            $rpl_btws =replace_between($rpl_btw, "group by", " ", "");
            $new_str = strstr($rpl_btw, 'group by');
            $fix_replace = str_replace($new_str, "", $rpl_btw);
//            $new_str = preg_replace('/group$/', '', $rpl_btw);
//            echo $rpl_btw;
//            echo $fix_replace;
            $db->sql($fix_replace);
        } else {
            $sql_select = " SELECT ";
            if ($select_entity == null) {
                $sql_all = " * ";
            } else {
                $sql_all = $select_entity;
            }
            $join_str = '';
            if ($join != null) {
                if (is_array($join)) {
                    foreach ($join as $value_join) {
                        $join_str .= " JOIN " . $value_join;
                    }
                } else {
                    $join_str .= " JOIN " . $join;
                }
            }

            $search_pagination_str = '';
            if ($search_pagination != null) {
                $search_pagination_str .= $search_pagination . '.';
            }
            if ($where == null) {
                $sql_from = " FROM " . $entity . " " . $join_str . " ";
                if ($this->search == NULL) {
                    $sql_search = "";
                } else {
                    $ex_search = explode(",", $this->search);
                    $sql_search = " WHERE ";
                    foreach ($ex_search as $value) {
                        $ex_search2 = explode(">", $value);
                        $s_1 = $ex_search2[0];
                        if ($ex_search2[1] == "") {
                            $sql_search .= " " . $search_pagination_str . $dto->search($s_1) . " is null OR " . $search_pagination_str . $dto->search($s_1) . " LIKE '%" . $ex_search2[1] . "%' OR";
                        } else {
                            $sql_search .= " " . $search_pagination_str . $dto->search($s_1) . " LIKE '%" . $ex_search2[1] . "%' OR";
                        }
                    }
                }
            } else {
                $sql_from = " FROM " . $entity . " " . $join_str . " " . " WHERE " . $where . " ";
                if ($this->search == NULL) {
                    $sql_search = "";
                } else {
                    $ex_search = explode(",", $this->search);
                    $sql_search = " AND ";
                    foreach ($ex_search as $value) {
                        $ex_search2 = explode(">", $value);
                        $s_1 = $ex_search2[0];
                        if ($ex_search2[1] == "") {
                            $sql_search .= " " . "(" . $search_pagination_str . $dto->search($s_1) . " is null OR " . $search_pagination_str . $dto->search($s_1) . " LIKE '%" . $ex_search2[1] . "%') OR";
                        } else {
                            $sql_search .= " " . "(" . $search_pagination_str . $dto->search($s_1) . " LIKE '%" . $ex_search2[1] . "%') OR";
                        }
                    }
                }
            }

//        echo $sql_from;
            if ($dto == "")
                $sql_search = "";
            $sql_search = rtrim($sql_search, "OR");
            $sql_group = "";
            $sql_group2 = "";
            if ($group_by != NULL) {
                $sql_group = " GROUP BY " . $group_by;
                $sql_group2 = $group_by . ",";
            }
            $db->sql($sql_select . $sql_group2 . " COUNT(*) as total " . $sql_from . $sql_search . $sql_group);  // Table name, column names and respective values
        }

//        echo $sql_select . $sql_group2. " COUNT(*) as total " . $sql_from . $sql_search . $sql_group;
        $count_row = $db->getResult();

//        echo json_encode($count_row);
//        print_r($count_row);
        if (isset($count_row[0]['total'])) {
            $this->total = $count_row[0]['total'];
        } else {
            $this->total = 0;
        }
//echo $this->per_page;
        if (isset($_POST['current_page'])) {
            $this->current_page = $_POST['current_page'];
        }

        if ($this->current_page == NULL)
            $this->current_page = 1;
//        echo $this->per_page;
        if ($this->per_page == NULL)
            $this->per_page = 10;
        if ($this->per_page == "")
            $this->per_page = 10;




        $current_page = $this->current_page;
        $total = $this->total;
        $per_page = $this->per_page;
        $last_page = $total / $per_page;
        if ($current_page >= ceil($last_page)) {
            $this->next_page = NULL;
        } else {
            $this->next_page = $current_page + 1;
        }

        if ($current_page <= 1) {
            $this->prev_page = NULL;
        } else {
            $this->prev_page = $current_page - 1;
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
            $min_page = $current_page - 2;
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
//        } else {
//            if ($current_page == 4) {
//                $res_page .= "1,";
//            } else if ($current_page == 5) {
//                $res_page .= "1,2,";
//            }
//        }
//        echo $min_page . $max_page . $last_page;
//        echo $current_page . ($last_page - 1);
        for ($no = $min_page; $no <= $max_page; $no++) {
//            echo $no;
            if ($no > ceil($last_page)) {
                
            } else if ($no <= 0) {
                
            } else {
                $res_page .= $no . ",";
            }
        }

        $this->pagination_item = rtrim($res_page, ",");
        $this->last_page = ceil($last_page);

        $to = $current_page * $per_page;

        $from = $to - $per_page;
//        echo ceil($last_page);
//        echo $last_page;
//        echo $per_page;
        if ($this->per_page == "all") {
            $limit = "";
        } else {
            $limit = " LIMIT " . $from . "," . $per_page;
        }
//        echo $limit;
        $this->from = $from;
        $this->to = $to;
//        echo $this->per_page;
//        LOGGER($sql);

        if (!empty($this->query)) {
            $sql = $this->query . " " . $limit;
        } else {
            $order_str = '';
            if ($order != null) {
                $order_str .= " ORDER BY " . $order;
            }

            $group_by_str = '';
            if ($group_by != null) {
                $group_by_str .= " GROUP BY " . $group_by;
            }
            $sql = $sql_select . $sql_all . $sql_from . $sql_search . $group_by_str . $order_str . $limit;
        }
        if ($this->tableOption['DEBUG'] == true) {
            echo $sql;
        }
        $this->sql = $sql;
        $db->sql($this->sql);  // Table name, column names and respective values
        $res = $db->getResult();
        if ($this->tableOption['DEBUG'] == true) {
            print_r($res);
        }
        if (!empty($res)) {
            if ($current_page == 1)
                $from = 1;
            else
                $from = $to - $per_page + 1;
            $this->from = $from;
            if ($this->to > $this->total)
                $to = $this->total;
            $this->to = $to;
//        if($res == FALSE){
//            $res = array();
//        }
//        echo json_encode($db->selectRelation($entity));
            if (empty($this->query)) {
                $relation = $db->selectRelation($entity);
                if (!empty($relation)) {
                    $key_parent = array_keys($res[0]);
                    foreach ($relation as $val_relation) {
                        if (in_array($val_relation['COLUMN_NAME'], $key_parent)) {
                            $ex_val2 = explode('_', $val_relation['COLUMN_NAME']);
                            $count_ex_val2 = count($ex_val2);
                            $min_ex_val2 = $count_ex_val2 - 1;
                            $parent_class_data = '';
                            for ($no = 0; $no < $count_ex_val2; $no++) {
                                $parent_class_data .= $ex_val2[$no] . '_';
                            }
                            $parent_class_data = rtrim($parent_class_data, '_');
                            foreach ($res as $key => $val2) {
                                $db->select($val_relation['REFERENCED_TABLE_NAME'], "*", null, $val_relation['REFERENCED_COLUMN_NAME'] . "='" . $val2[$val_relation['COLUMN_NAME']] . "'");
                                $res_rel = $db->getResult();
//                            print_r($res_rel);
                                if (!empty($res_rel)) {
//                                $res[$key][$val_relation['COLUMN_NAME']] = $res_rel[0];
                                    $res[$key][$parent_class_data] = $res_rel[0];
                                } else {
                                    $res[$key][$parent_class_data] = array();
                                }
                            }
                        }
                    }
                }
            }
//            print_r($res);
            $res = array_merge(array("item" => $res), $this->json_pagination());
        } else {
            $res = array_merge(array("item" => array()), $this->json_pagination());
        }
//        echo json_encode($res);
        return $res;
    }

    public function select_pagination_rest($url, $param = array(), $order = array()) {
        $search = explode('>', $this->search);

        $tripoinRestClient = new TripoinRestClient();
        if ($this->current_page == 1) {
            $full_url = $url . SLASH . IRestCommandConstant::COMMAND_STRING . EQUAL . IRestCommandConstant::ADVANCED_PAGINATION;
        } else {
            $full_url = $url . SLASH . IRestCommandConstant::COMMAND_STRING . EQUAL . IRestCommandConstant::ADVANCED_PAGINATION . '?page=' . $this->current_page;
        }
//        $this->se
        $keyOrder = 'code';
        $valOrder = 'asc';
        if (!empty($order)) {
            $keyOrder = key($order);
            $valOrder = $order[key($order)];
        }
        $result = $tripoinRestClient->doPOST($full_url, array(), array(), array_merge(array(
            "item_number" => $this->per_page,
            "filter_key" => $search[0],
            "filter_value" => $search[1],
            "sorting_key" => $keyOrder,
            "sorting_direction" => $valOrder
                        ), $param));
//print_r($result);
        if ($result == false) {
            $tripoinRestClient = new TripoinRestClient();
            $tripoinRestClient->doPOSTLoginNoAuth();
            return $this->select_pagination_rest($url, $param, $order);
        }
//        print_r($result);
        $json = json_decode($result->getBody);

//        $this->result = $json;
        if (!empty($json->data)) {
            $this->per_page = $json->per_page;
            $this->current_page = $json->current_page;
            $this->last_page = $json->last_page;
            $this->total = $json->total;
            $this->from = $json->from;
            $this->to = $json->to;



            $current_page = $this->current_page;
            $total = $this->total;
            $per_page = $this->per_page;
            $last_page = $total / $per_page;
            if ($current_page >= ceil($last_page)) {
                $this->next_page = NULL;
            } else {
                $this->next_page = $current_page + 1;
            }

            if ($current_page <= 1) {
                $this->prev_page = NULL;
            } else {
                $this->prev_page = $current_page - 1;
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
                $min_page = $current_page - 2;
                $max_page = $current_page + 2;
            } else if ($current_page == ($this->last_page - 1)) {
                $min_page = $current_page - 3;
                $max_page = $current_page + 2;
//            echo 'masuk';
            } else if ($current_page == $this->last_page) {
                $min_page = $current_page - 4;
                $max_page = $current_page + 1;
//                echo 'masuk';
            }
            for ($no = $min_page; $no <= $max_page; $no++) {
//            echo $no;
                if ($no > ceil($this->last_page)) {
                    
                } else if ($no <= 0) {
                    
                } else {
                    $res_page .= $no . ",";
                }
            }

            $this->pagination_item = rtrim($res_page, ",");

            $res = array_merge(array("item" => $json->data), $this->json_pagination());
        } else {
//            print_r($json);
            $res = array_merge(array("item" => array()), $this->json_pagination());
        }

        return $res;
    }

    public $result;

    public function getResult() {
        return $this->result;
    }

    function json_pagination() {
        $res = array(
            "total" => $this->total,
            "per_page" => $this->per_page,
            "current_page" => $this->current_page,
            "last_page" => $this->last_page,
            "next_page" => $this->next_page,
            "prev_page" => $this->prev_page,
            "from" => $this->from,
            "to" => $this->to,
            "pagination_item" => $this->pagination_item,
        );
        /*
          $res = "";
          $res .= '"total":"' . $this->total . '",';
          $res .= '"per_page":"' . $this->per_page . '",';
          $res .= '"current_page":"' . $this->current_page . '",';
          $res .= '"last_page":"' . $this->last_page . '",';
          $res .= '"next_page":"' . $this->next_page . '",';
          $res .= '"prev_page":"' . $this->prev_page . '",';
          $res .= '"from":"' . $this->from . '",';
          $res .= '"to":"' . $this->to . '",';
          $res .= '"pagination_item":"' . $this->pagination_item . '"';
         */
        return $res;
    }

}
