<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\framework\grid\GridView;
use yii\widgets\Pjax;
use yii\web\JsExpression;
use kartik\select2\Select2;

$this->title = Yii::t('app', 'Comments & rates: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-comments">
                    <?= Yii::t('app', 'Comments') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-rates">
                    <?= Yii::t('app', 'Rates') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-comments" class="tab-pane active">
                <?php Pjax::begin([
                    'id' => 'blog-comments-pjax',
                    'enablePushState' => false,
                ]) ?>
                
                <?= GridView::widget([
                    'dataProvider' => $dataProvider['comments'],
                    'filterModel' => $modelSearch['comments'],
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'headerOptions' => [
                                'style' => 'width: 100px;'
                            ]
                        ],
                        [
                            'attribute' => 'user_id',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                                'model' => $modelSearch['comments'],
                                'attribute' => 'user_id',
                                'data' => [$modelSearch['comments']->user_id => ArrayHelper::getValue($modelSearch['comments']->user, 'username')],
                                'options' => ['placeholder' => ' '],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'ajax' => [
                                        'url' => Yii::$app->urlManager->createUrl(['items-list/users']),
                                        'dataType' => 'json',
                                        'delay' => 300,
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ]
                            ]),
                            'value' => fn ($model) => ArrayHelper::getValue($model->user, 'username'),
                        ],
                        'text:ntext',
                        [
                            'attribute' => 'status',
                            'filter' => ArrayHelper::getColumn($modelSearch['comments']->statuses(), 'label'),
                            'value' => fn ($model) => ArrayHelper::getValue($modelSearch['comments']->statuses(), "$model->status.label"),
                        ],
                        'created',
                    ],
                ]); ?>
                
                <?php Pjax::end() ?>
            </div>
            
            <div id="tab-rates" class="tab-pane fade">
                <?php Pjax::begin([
                    'id' => 'blog-rates-pjax',
                    'enablePushState' => false,
                ]) ?>
                
                <?= GridView::widget([
                    'dataProvider' => $dataProvider['rates'],
                    'filterModel' => $modelSearch['rates'],
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'headerOptions' => [
                                'style' => 'width: 100px;'
                            ]
                        ],
                        [
                            'attribute' => 'user_id',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                                'model' => $modelSearch['rates'],
                                'attribute' => 'user_id',
                                'data' => [$modelSearch['rates']->user_id => ArrayHelper::getValue($modelSearch['rates']->user, 'username')],
                                'options' => ['placeholder' => ' '],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'ajax' => [
                                        'url' => Yii::$app->urlManager->createUrl(['items-list/users']),
                                        'dataType' => 'json',
                                        'delay' => 300,
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                ]
                            ]),
                            'value' => fn ($model) => ArrayHelper::getValue($model->user, 'username'),
                        ],
                        'mark',
                        'created',
                    ],
                ]); ?>
                
                <?php Pjax::end() ?>
            </div>
        </div>
    </div>
</div>
