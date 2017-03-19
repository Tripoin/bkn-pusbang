<table border="0" class="table table-bordered">
    <tr style="background: #D01C24;color: #FFF">
        <th><?= lang('alumnus.participant_name'); ?></th>
        <th><?= lang('alumnus.agencies'); ?></th>
        <th><?= lang('alumnus.activity'); ?></th>
        <th><?= lang('alumnus.generation'); ?></th>
    </tr>
    <?php
    foreach ($rs_alumnus as $data) {
    ?>
        <tr>
            <td><?php echo $data['participant_name']; ?></td>
            <td><?php echo $data['agencies']; ?></td>
            <td><?php echo $data['activity']; ?></td>
            <td><?php echo $data['generation']; ?></td>
        </tr>
    <?php
    }
    ?>
</table>