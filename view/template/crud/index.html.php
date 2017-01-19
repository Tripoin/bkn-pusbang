<!doctype html>
<html lang="en">
    <?= contentPage(); ?>
    <?= pageBody(); ?>
    <?= $Datatable->show(); ?>
    <script>
        $(function () {
    //        location.reload(true);
            postAjaxPagination();
        });
    </script>
    <?= endPageBody(); ?>
    <?= endContentPage(); ?>
</html>