<div class="part">
    <h4 class="mb-4">
        <?= $part_name . ' (' . $part_index . ')' ?>
        <button type="button" class="btn btn-danger btn-icon float-right btn-part-remove">
            <i class="fas fa-trash"></i>
            Delete
        </button>
    </h4>
    <table class="table table-relations">
        <thead>
            <tr>
                <th style="width: 3%;"></th>
                <th style="width: 15%;">Name</th>
                <th style="width: 15%;">Label</th>
                <th style="width: 4%;">I18N</th>
                <th style="width: 15%;">Type</th>
                <th style="width: 45%;">Attrs (for "groups" type)</th>
                <th style="width: 3%;"></th>
            </tr>
        </thead>
        
        <tbody data-toggle="sortable"></tbody>
        
        <tfoot>
            <tr>
                <td colspan="7">
                    <button type="button"
                            class="btn btn-success btn-block btn-block-add"
                            data-action="<?= Yii::$app->urlManager->createUrl(['speedrunner/staticpage/generator/new-block']) ?>"
                            data-part_name="<?= $part_name ?>"
                            data-part_index="<?= $part_index ?>"
                    >
                        <i class="fa fa-plus"></i>
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
    <hr>
</div>