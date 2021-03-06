<?php

namespace common\query;

use Yii;
use yii\db\Expression;
use common\framework\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;


class NestedSetsQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
    
    public function itemsTree($attr, $type)
    {
        $lang = Yii::$app->language;
        
        switch ($type) {
            case 'self':
                $this->addSelect(['id', new Expression("CONCAT(REPEAT(('- '), (depth - 1)), name) as text")]);
                break;
            case 'translation':
                $this->addSelect(['id', new Expression("CONCAT(REPEAT(('- '), (depth - 1)), name->>'$.$lang') as text")]);
                break;
        }
        
        return $this->orderBy('lft ASC');
    }
}