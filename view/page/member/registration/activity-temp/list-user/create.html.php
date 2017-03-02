<div class="row">
    <div class="col-md-7">
        <?= $data_activity[0][$modelActivity->getSubjectName()]; ?>
        :
        <?= subMonth($data_activity[0][$modelActivity->getStartActivity()]) . ' - ' . subMonth($data_activity[0][$modelActivity->getEndActivity()]); ?>
    </div>
    <div class="col-md-5" style="margin-bottom: 20px;" id="pageBtnHeader">
        <button id="buttonBack" title="<?= lang('general.back'); ?>" 
                rel="tooltip"
                class="btn btn-danger btn-sm pull-right" type="submit" 
                onsubmit="return false;" onclick="pageUser('<?= $data_activity[0][$modelActivity->getId()]; ?>', '<?= $_POST['registration_id']; ?>')" 
                style="margin-left: 10px;"
                class="btn">
            <i class="fa fa-arrow-circle-left"></i> <?= lang('general.back'); ?>
        </button>
    </div>
    <div class="col-md-12">
        <?php
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.participant_name'))
                ->id('participant_name')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.participant_name') . " ... ")
                ->textbox();
        $idNumber = '<div class="row">'
                . '<div class="col-md-4">' . Form()
                        ->title(lang('member.no_id'))
                        ->id('participant_name')
                        ->onlyComponent(true)
                        ->placeholder(lang('member.no_id') . " ... ")
                        ->textbox() . '</div>';
        $noType = '<div class="col-md-2">' . Form()->id('noidType')
                        ->required(false)
                        ->onlyComponent(true)
                        ->autocomplete(false)
                        ->data($data_noid_type)
                        ->combobox() . '</div></div>';
        echo Form()->required(false)
                ->label(lang('member.no_id'))
                ->formLayout('form-horizontal')
                ->title(lang('member.no_id'))
                ->formGroup($idNumber . $noType);
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.front_degree'))
                ->id('front_degree')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.front_degree') . " ... ")
                ->textbox();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.behind_degree'))
                ->id('behind_degree')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.behind_degree') . " ... ")
                ->textbox();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.behind_degree'))
                ->id('behind_degree')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.behind_degree') . " ... ")
                ->textbox();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.place_of_birth'))
                ->id('place_of_birth')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.place_of_birth') . " ... ")
                ->textbox();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.date_of_birth'))
                ->id('date_of_birth')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.date_of_birth') . " ... ")
                ->datepicker();
        echo Form()->id('religion')->attr('style="width:50%;"')->title(lang('member.religion'))
                ->autocomplete(false)
                ->formLayout('form-horizontal')
                ->data($data_religion)
                ->combobox();
        echo Form()->id('gender')->title(lang('member.gender'))
                ->autocomplete(false)
                ->formLayout('form-horizontal')
                ->data($data_gender)
                ->radiobox();
        echo Form()->id('marital_status')->title(lang('member.marital_status'))
                ->autocomplete(false)
                ->formLayout('form-horizontal')
                ->data($data_marital_status)
                ->radiobox();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.email'))
                ->id('email')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.email') . " ... ")
                ->textbox();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.telephone'))
                ->id('telephone')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.telephone') . " ... ")
                ->textbox();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.fax'))
                ->id('fax')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.fax') . " ... ")
                ->textbox();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.address'))
                ->id('address')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.address') . " ... ")
                ->textarea();

        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.zip_code'))
                ->id('zip_code')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.zip_code') . " ... ")
                ->textbox();
        echo Form()->id('government_classification')->attr('style="width:50%;"')->title(lang('member.government_classification'))
                ->autocomplete(false)
                ->formLayout('form-horizontal')
                ->data($data_government_class)
                ->combobox();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.json_occupation'))
                ->id('json_occupation')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.json_occupation') . " ... ")
                ->textbox();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.degree'))
                ->id('degree')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.degree') . " ... ")
                ->textbox();
        echo Form()->id('college')->attr('style="width:50%;"')->title(lang('member.college'))
                ->formLayout('form-horizontal')
                ->autocomplete(false)
//                ->data($data_college)
                ->data($data_government_class)
                ->combobox();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.faculity'))
                ->id('faculity')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.faculity') . " ... ")
                ->textbox();
        echo Form()->id('study_program')->attr('style="width:50%;"')->title(lang('member.study_program'))
                ->formLayout('form-horizontal')
                ->data($data_study_program)
                ->combobox();
        echo Form()->attr('style="width:50%;"')
                ->title(lang('member.graduation_year'))
                ->id('graduation_year')
                ->formLayout('form-horizontal')
                ->placeholder(lang('member.graduation_year') . " ... ")
                ->textbox();
//        $data_government_class
        ?>
    </div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function () {


        
        $("#college").combobox();
    });
</script>