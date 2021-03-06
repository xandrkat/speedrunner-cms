<?php

namespace backend\modules\Product\models\query;

use Yii;
use yii\db\Expression;
use common\framework\ActiveQuery;


class ProductSpecificationQuery extends ActiveQuery
{
    public function byAssignedCategies($categories)
    {
        $lang = Yii::$app->language;
        
        return $this->joinWith([
                'categories',
                'options' => fn ($query) => $query->select(['*', new Expression("ProductSpecificationOption.name->>'$.$lang' as name")]),
            ])
            ->andWhere(['ProductCategory.id' => $categories])
            ->select([
                'ProductSpecification.*',
                new Expression("ProductSpecification.name->>'$.$lang' as name"),
                'ProductSpecificationOption.sort',
            ])
            ->groupBy('ProductSpecification.id');
    }
}