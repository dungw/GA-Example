
<div align="center">
    <table width="90%" class="tbl">
        <tr>
            <th colspan="<?= (count($report['columnHeaders']) + 1) ?>">
                <h2>Report</h2>
                <span>Total: <?= $report['totalResults'] ?></span>
            </th>
        </tr>
        <tr class="h">
            <th>No</th>
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
                <td><?= $no ?></td>
                <?php for ($i=0; $i<count($report['columnHeaders']); $i++) { ?>
                <td><?= $item[$i] ?></td>
                <?php } ?>
            </tr>
            <?php
            $no++;
        }
        ?>
    </table>
</div>

