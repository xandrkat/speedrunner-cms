<?php

$index_title = ($model->module_name == $model->controller_name) ? $model->module_name : $model->module_name . ' ' . $model->controller_name;
$use = isset($model->use['view_update']) ? $model->use['view_update'] : [];

//      ATTRIBUTES

$attrs = $model->attrs_fields ?: [];

echo '<?php';

?>


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
<?php foreach ($use as $u) { ?>
use <?= $u['value'] ?>;
<?php } ?>

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '<?= $index_title ?>s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= "<?php " ?>$form = ActiveForm::begin([
    'options' => ['id' => 'edit-form', 'enctype' => 'multipart/form-data'],
]); ?>

<h2 class="main-title">
    <?= "<?= \$this->title ?>\n" ?>
<?php
    echo "        <?= Html::submitButton(
        Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save'),
        ['class' => 'btn btn-primary btn-icon float-right']
    ) ?>\n";
?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-general">
                    <?= "<?= Yii::t('app', 'General') ?>\n" ?>
                </a>
            </li>
<?php foreach ($model->view_relations as $r) { ?>
<?php $var_name_rel = str_replace('_tmp', '', $r['var_name']); ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-<?= $var_name_rel ?>">
                    <?= "<?= Yii::t('app', '" . ucfirst($var_name_rel) . "') ?>\n" ?>
                </a>
            </li>
<?php } ?>
<?php if ($model->has_seo_meta) { ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-seo-meta">
                    <?= "<?= Yii::t('app', 'SEO meta') ?>\n" ?>
                </a>
            </li>
<?php } ?>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-general" class="tab-pane active">
<?php
    foreach ($attrs as $key => $a) {
        switch ($a['type']) {
            case 'textInput':
                echo "                <?= \$form->field(\$model, '$key')->textInput() ?>\n";
                break;
            case 'textArea':
                echo "                <?= \$form->field(\$model, '$key')->textArea(['rows' => 5]) ?>\n";
                break;
            case 'checkbox':
                echo "                <?= \$form->field(\$model, '$key', [
                    'checkboxTemplate' => Yii::\$app->params['switcher_template'],
                ])->checkbox([
                    'class' => 'custom-control-input',
                ])->label(null, [
                    'class' => 'custom-control-label'
                ]) ?>\n";
                break;
            case 'select':
                echo "                <?= \$form->field(\$model, '$key')->dropDownList([]) ?>\n";
                break;
            case 'CKEditor':
                echo "                <?= \$form->field(\$model, '$key')->widget(Widget::className(), [
                    'settings' => [
                        'imageUpload' => Yii::\$app->urlManager->createUrl('connection/editor-image-upload'),
                        'imageManagerJson' => Yii::\$app->urlManager->createUrl('connection/editor-images'),
                    ],
                ]); ?>\n";
                break;
            case 'ElFinder':
                echo "                <?= \$form->field(\$model, '$key')->widget(ElFinderInput::className(), [
                    'connectorRoute' => '/connection/elfinder-file-upload',
                ]) ?>\n";
                break;
        }
    }
?>
            </div>
<?php foreach ($model->view_relations as $r) { ?>
<?php $var_name_rel = str_replace('_tmp', '', $r['var_name']); ?>
            
            <div id="tab-<?= $var_name_rel ?>" class="tab-pane fade">
                <?= '<?= ' ?>$this->render('_<?= $var_name_rel ?>', [
                    'model' => $model,
                    'form' => $form,
                ]); ?>
            </div>
<?php } ?>
<?php if ($model->has_seo_meta) { ?>
            
            <div id="tab-seo-meta" class="tab-pane fade">
                <?= "<?= Yii::\$app->sr->seo->getMetaLayout(\$model) ?>\n" ?>
            </div>
<?php } ?>
        </div>
    </div>
</div>

<?= "<?php ActiveForm::end(); ?>\n" ?>