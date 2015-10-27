<?php
include 'common.php';

define('TBL_WIDTH', '');

use core\GA_Service;
use core\controller\IndexController;

//google client
$client = new Google_Client();

//ga service
$ga = new GA_Service($client);

$controller = new IndexController($ga);
$controller->index();

$accounts = $controller->accounts();
//print '<pre>'; print_r($accounts);

$properties = json_decode($controller->properties($accounts[0]['id']), true);
print '<pre>'; print_r($properties);

$views = json_decode($controller->views($accounts[0]['id'], $properties[0]['id']));
print '<pre>'; print_r($views);

$metadata = $controller->metadata();
//print '<pre>'; print_r($metadata);

$report = $controller->report();
print '<pre>'; print_r($report);
?>

<div align="center">
    <table width="90%" class="tbl">
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
        <?php
        $no = 1;
        foreach ($metadata['dimensions'] as $key => $group) {
            ?>
            <tr>
                <td colspan="8"><h3><?= $no . '.&nbsp;' . $key ?></h3></td>
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

<style type="text/css">
    .tbl {
        border-collapse: collapse;
        border: 1px solid navy;
    }
    .tbl td {
        border: 1px solid navy;
        padding: 1px 3px;
    }
    tr.h {
        background-color: lightgray;
    }
    h3 {
        color: #001199;
    }
</style>

