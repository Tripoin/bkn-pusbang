<?= contentPage(); ?>
<?= pageBody(); ?>
<script>
    $(function () {
//        location.reload(true);
        postAjaxPagination();
    });
</script>
<?= endPageBody(); ?>
<?= endContentPage(); ?>