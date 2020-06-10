<?php

use yii\helpers\Html;

?>

<h4 class="text-center text-bold"><?= Yii::t('speedrunner', 'View relations') ?></h4>
<br>

<table class="table table-relations">
    <thead>
        <tr>
            <th style="width: 2%;"></th>
            <th style="width: 45%;"><?= Yii::t('speedrunner', 'Model') ?></th>
            <th style="width: 45%;"><?= Yii::t('speedrunner', 'Variable name') ?></th>
            <th style="width: 3%;"></th>
        </tr>
    </thead>
    <tbody>
        <tr class="table-new-relation" data-table="view_relations">
            <td class="table-sorter">
                <i class="fas fa-arrows-alt"></i>
            </td>
            <td>
                <?= Html::dropDownList('GeneratorForm[view_relations][__key__][model]', null, $tables, ['class' => 'form-control', 'required' => true]); ?>
            </td>
            <td>
                <?= Html::input('text', 'GeneratorForm[view_relations][__key__][var_name]', null, ['class' => 'form-control', 'required' => true]); ?>
            </td>
            <td class="text-right">
                <button type="button" class="btn btn-danger btn-remove">
                    <span class="fa fa-times"></span>
                </button>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7">
                <button type="button" class="btn btn-success btn-block btn-add" data-table="view_relations">
                    <i class="fa fa-plus"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>