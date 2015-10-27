
<div align="center">
    <table width="90%" class="tbl">
        <tr>
            <th colspan="7"><h2>Report</h2></th>
        </tr>
        <tr class="h">
            <?php
            foreach ($report['columnHeaders'] as $header) {
                ?>
                <th width="<?= TBL_WIDTH ?>"><?= $header->columnType . ' [' . $header->name . ']'; ?></th>
                <?php
            }
            ?>
        </tr>
        <?php
        $no = 1;
        foreach ($report['items'] as $item) {
            ?>
            <tr>
                <td><?= $item[0] ?></td>
                <td><?= $item[1] ?></td>
                <td><?= $item[2] ?></td>
            </tr>
            <?php
            $no++;
        }
        ?>
    </table>
</div>

