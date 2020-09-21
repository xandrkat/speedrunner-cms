<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class ProductSpecification extends ActiveRecord
{
    public $translation_attrs = [
        'name',
    ];
    
    public $options_tmp;
    
    public static function tableName()
    {
        return 'ProductSpecification';
    }
    
    public function behaviors()
    {
        return [
            'relations_one_many' => [
                'class' => \common\behaviors\RelationBehavior::className(),
                'type' => 'oneMany',
                'attributes' => [
                    [
                        'model' => new ProductSpecificationOption,
                        'relation' => 'options',
                        'attribute' => 'options_tmp',
                        'properties' => [
                            'main' => 'item_id',
                            'relational' => ['name'],
                        ],
                    ],
                ],
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['use_filter', 'use_compare', 'use_detail'], 'boolean'],
            [['options_tmp'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'use_filter' => Yii::t('app', 'Use in filter'),
            'use_compare' => Yii::t('app', 'Use in compare'),
            'use_detail' => Yii::t('app', 'Use in detail page'),
            'options_tmp' => Yii::t('app', 'Options'),
        ];
    }
    
    public function getOptions()
    {
        return $this->hasMany(ProductSpecificationOption::className(), ['item_id' => 'id'])->orderBy('sort');
    }
    
    public function getCategories()
    {
        return $this->hasMany(ProductCategory::className(), ['id' => 'category_id'])
            ->viaTable('ProductCategorySpecificationRef', ['specification_id' => 'id']);
    }
}
