<?php

namespace backend\modules\Product\models;

use Yii;
use common\framework\ActiveRecord;


class ProductRelatedRef extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductRelatedRef';
    }
}
