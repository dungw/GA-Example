<div align="center">
    <table width="90%" class="tbl">
        <?php
        $no = 1;
        foreach ($metadata['dimensions'] as $key => $group) {
            ?>
            <tr>
                <td colspan="8"><h3><?= $no . '.&nbsp;Dimension&nbsp;[' . $key . ']' ?></h3></td>
            </tr>
            <?php
            $groupNo = 1;
            foreach ($group as $dimension) {
                ?>
                <?php if ($groupNo == 1) { ?>
                    <tr class="h">
                        <th width="<?= TBL_WIDTH ?>">id</th>
                        <th width="<?= TBL_WIDTH ?>">kind</th>
                        <th width="<?= TBL_WIDTH ?>">type</th>
                        <th width="<?= TBL_WIDTH ?>">dataType</th>
                        <th width="<?= TBL_WIDTH ?>">group</th>
                        <th width="<?= TBL_WIDTH ?>">status</th>
                        <th width="<?= TBL_WIDTH ?>">uiName</th>
                        <th>description</th>
                    </tr>
                <?php } ?>
                <tr>
                    <td><?= $dimension->id ?></td>
                    <td><?= $dimension->kind ?></td>
                    <td><?= $dimension->attributes->type ?></td>
                    <td><?= $dimension->attributes->dataType ?></td>
                    <td><?= $dimension->attributes->group ?></td>
                    <td><?= $dimension->attributes->status ?></td>
                    <td><?= $dimension->attributes->uiName ?></td>
                    <td><?= $dimension->attributes->description ?></td>
                </tr>
                <?php
                $groupNo++;
            }
            $no++;
        }
        ?>
    </table>
</div>

<div align="center">
    <table width="90%" class="tbl">
        <?php
        $no = 1;
        foreach ($metadata['metrics'] as $key => $group) {
            ?>
            <tr>
                <td colspan="8"><h3><?= $no . '.&nbsp;Metric&nbsp;[' . $key . ']' ?></h3></td>
            </tr>
            <?php
            $groupNo = 1;
            foreach ($group as $metric) {
                ?>
                <?php if ($groupNo == 1) { ?>
                    <tr class="h">
                        <th width="<?= TBL_WIDTH ?>">id</th>
                        <th width="<?= TBL_WIDTH ?>">kind</th>
                        <th width="<?= TBL_WIDTH ?>">type</th>
                        <th width="<?= TBL_WIDTH ?>">dataType</th>
                        <th width="<?= TBL_WIDTH ?>">group</th>
                        <th width="<?= TBL_WIDTH ?>">status</th>
                        <th width="<?= TBL_WIDTH ?>">uiName</th>
                        <th>description</th>
                    </tr>
                <?php } ?>
                <tr>
                    <td><?= $metric->id ?></td>
                    <td><?= $metric->kind ?></td>
                    <td><?= $metric->attributes->type ?></td>
                    <td><?= $metric->attributes->dataType ?></td>
                    <td><?= $metric->attributes->group ?></td>
                    <td><?= $metric->attributes->status ?></td>
                    <td><?= $metric->attributes->uiName ?></td>
                    <td><?= $metric->attributes->description ?></td>
                </tr>
                <?php
                $groupNo++;
            }
            $no++;
        }
        ?>
    </table>
</div>
