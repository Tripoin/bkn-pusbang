<!doctype html>
<html lang="en">
    <?= contentPage(); ?>
    <div id="content" class="container-fluid" style="padding-top: 85px;">
        <div class="row" id="breadcrumb">
            <?= breadCrumb($get_menu_child[0][$sf->getName()]); ?>

            <?php
            $years = date("Y");
            $month = date("m");
            ?>
            <div class="col-sm-24 col-md-8 col-lg-8 zeropad" id="datefilter">

                <select name="year" id="select_year" onchange="findPostRead('<?= FULLURL(); ?>', 1);">
                    <option value="0">Select Year</option>
                    <?php
                    for ($no = 0; $no < 4; $no++) {
                        $hasilyears = $years - $no;
                        echo '<option value="' . $hasilyears . '">' . $hasilyears . '</option>';
                    }
                    ?>

                </select>
                <select name="months" id="select_month" onchange="findPostRead('<?= FULLURL(); ?>', 1);">
                    <option value="0" selected="selected">Select Month</option>
                    <?php
                    for ($no = 1; $no <= 12; $no++) {
                        $hasilmonth = '';
                        if ($no > 9) {
                            $hasilmonth = $no;
                        } else {
                            $hasilmonth = '0' . $no;
                        }
                        echo '<option value="' . $hasilmonth . '">' . getMonth($no) . '</option>';
                    }
                    ?>

                </select>
            </div>
        </div>
        <div id="content-post">

        </div>

        <div class="clearfix"></div>
    </div>

    <?= endContentPage(); ?>
    <script>
        $(function () {
//            location.reload(true);
            findPostRead('<?= FULLURL(); ?>', 1);
        });
    </script>
</html>