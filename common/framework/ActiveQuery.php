<?php

namespace common\framework;

use Yii;
use yii\helpers\StringHelper;
use yii\db\Expression;


class ActiveQuery extends \yii\db\ActiveQuery
{
    public function itemsList($attr, $type, $q = null, $limit = 20)
    {
        $lang = Yii::$app->language;
        
        $model_class = StringHelper::basename($this->modelClass);
        
        switch ($type) {
            case 'self':
                $this->select([
                    "$model_class.id",
                    "$model_class.$attr as text",
                ])->andFilterWhere([
                    'like', "$model_class.$attr", $q
                ]);
                
                break;
            case 'translation':
                $this->select([
                    "$model_class.id",
                    new Expression("$model_class.$attr->>'$.$lang' as text"),
                ])->andFilterWhere([
                    'like', new Expression("LOWER(JSON_EXTRACT($model_class.$attr, '$.$lang'))"), strtolower($q)
                ]);
                
                break;
        }
        
        return $this->limit($limit);
    }
}