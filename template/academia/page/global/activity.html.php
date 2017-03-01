
<?php include_once getTemplatePath('page/content-page.html.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="module-title notice">
                <span>Kegiatan</span>
            </h3>
        </div>
    </div>		
    <div class="row">
        <select class="form-control pull-right margin-bottom" style="width: 250px;">
                <option value="">-- Select --</option>
                <option value="2017" selected="selected">2017</option>
            </select>
        <table border="0" class="table table-bordered">
            <tr>
                <th>Nama Kegiatan</th>
                <th>Angkatan</th>
                <th>Tipe Anggaran</th>
                <th>Waktu Pelaksanaan</th>
                <th>Status</th>
                <!--<th>Tanggal Akhir</th>-->
            </tr>
            <?php
            foreach($rs_activity as $data){
                $data_subject = valueComboBoxParent($masterSubject->getEntity(), 
                        $masterSubject->getId(), 
                        $masterSubject->getName(), 
                        $masterSubject->getParentId(), $masterSubject->getId() . equalToIgnoreCase($data[$transActivity->getSubjectId()]));
            ?>

            <tr>
                <th><?php echo $data_subject[0]['label'];?></th>
                <th><?php echo $data['generation'];?></th>
                <th><?php echo $data['budget_type_name'];?></th>
                <th><?php echo subMonth($data['start_activity']) ." s/d ". subMonth($data['end_activity']);?></th>
                <th>
                    <?php
                        $status = $data['status'];
                        if($status == 1){
                            $status = "Penuh";
                        }else{
                            $status = "<a href='".URL('/activity/'.$data['id'].'/register')."'>Daftar</a>";
                        }

                        echo $status;
                    ?>
                </th>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php include_once getTemplatePath('page/end-content-page.html.php'); ?>