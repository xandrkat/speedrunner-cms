<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\assets\AppAsset;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="elfinder-connection-url" content="<?= Yii::$app->urlManager->createUrl(['connection/elfinder-file-upload']) ?>">
    <meta name="ckeditor-image_upload-connection-url" content="<?= Yii::$app->urlManager->createUrl(['connection/editor-image-upload']) ?>">
    <meta name="ckeditor-images-connection-url" content="<?= Yii::$app->urlManager->createUrl(['connection/editor-images-get']) ?>">
    <meta name="theme-color" content="#067a7d">
    
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web/favicon.svg') ?>">
    
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<?= $this->render('@backend/views/layouts/themes/' . ArrayHelper::getValue(Yii::$app->user->identity, 'design_theme', 'nav_full'), [
    'content' => $content,
    'menu_items' => require '_nav.php',
    'flashes' => json_encode(Yii::$app->session->getAllFlashes(), JSON_UNESCAPED_UNICODE),
]); ?>

<?= $this->render('@backend/views/layouts/design/style'); ?>

<div class="modal fade" id="main-modal">
    <div class="modal-dialog"></div>
</div>

<div id="ajax-mask">
    <div class="ajax-mask-wrapper">
        <div class="line"></div>
        <div class="line"></div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>