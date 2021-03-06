<?php

namespace backend\modules\System\models;

use Yii;
use common\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class SystemLanguage extends ActiveRecord
{
    use \api\modules\v1\models\system\SystemLanguage;
    
    public static function tableName()
    {
        return 'SystemLanguage';
    }
    
    public function rules()
    {
        return [
            [['name', 'code', 'image'], 'required'],
            [['name', 'image'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 20],
            [['code'], 'unique'],
            [['code'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['is_active', 'is_main'], 'boolean'],
            [['is_main'], 'isMainValidation'],
        ];
    }
    
    public function isMainValidation($attribute, $params, $validator)
    {
        if (ArrayHelper::getValue($this->oldAttributes, $attribute) && !$this->{$attribute}) {
            $this->addError($attribute, Yii::t('app', 'One of the languages must be main'));
        }
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'image' => Yii::t('app', 'Image'),
            'is_active' => Yii::t('app', 'Active'),
            'is_main' => Yii::t('app', 'Main'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
    
    public function beforeSave($insert)
    {
        if ($this->is_main) {
            SystemLanguage::updateAll(['is_main' => 0]);
            $this->is_active = 1;
        }
        
        return parent::beforeSave($insert);
    }
    
    public function beforeDelete()
    {
        if ($this->is_main) {
            Yii::$app->session->addFlash('danger', Yii::t('app', 'You cannot delete main language'));
            return false;
        }
        
        return parent::beforeDelete();
    }
}
