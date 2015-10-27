
<div align="center">
    <table width="90%" class="tbl">
        <tr>
            <th colspan="7"><h2>Segments</h2></th>
        </tr>
        <tr class="h">
            <th width="<?= TBL_WIDTH ?>">id</th>
            <th width="<?= TBL_WIDTH ?>">kind</th>
            <th width="<?= TBL_WIDTH ?>">selfLink</th>
            <th width="<?= TBL_WIDTH ?>">segmentId</th>
            <th width="<?= TBL_WIDTH ?>">name</th>
            <th width="">definition</th>
            <th width="<?= TBL_WIDTH ?>">type</th>
        </tr>
        <?php
        $no = 1;
        foreach ($segments as $item) {
            ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= $item['kind'] ?></td>
                <td><?= $item['selfLink'] ?></td>
                <td><?= $item['segmentId'] ?></td>
                <td><?= $item['name'] ?></td>
                <td><?= $item['definition'] ?></td>
                <td><?= $item['type'] ?></td>
            </tr>
            <?php
            $no++;
        }
        ?>
    </table>
</div>