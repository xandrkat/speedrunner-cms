<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\framework\grid\GridView;

$this->title = Yii::t('app', 'Product specifications');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Html::a(
        Html::tag('i', null, ['class' => 'fas fa-plus-square']) . Yii::t('app', 'Create'),
        ['create'],
        ['class' => 'btn btn-primary btn-icon float-right']
    ) ?>
</h2>

<div class="main-shadow p-3">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $modelSearch,
        'columns' => [
            [
                'class' => 'common\framework\grid\CheckboxColumn',
            ],
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 100px;'
                ]
            ],
            'name',
            'use_filter:boolean',
            'use_compare:boolean',
            'use_detail:boolean',
            'created',
            'updated',
            [
                'class' => 'common\framework\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [],
            ],
        ],
    ]); ?>
</div>
